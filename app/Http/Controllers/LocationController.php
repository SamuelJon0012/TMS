<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sites;
use Auth;

class LocationController extends Controller
{
    // Update, Refresh, and set initial modal data content on page load

    function index(Request $request) {

        return $this->getLocationModalData($request->get('id'));

    }


    function getLocationModalData($userId) {

        return false;
    }

    function searchSites(Request $request){
        $user = Auth::user();
        if ($user == null)
            return redirect('/login');

        $search = $request->get('q');
        if (empty($search)){
            $rows = Sites::orderBy('name')->get();
        } else {
            $v = "%$search%";
            $rows = Sites::where('name','LIKE',$v)
                    ->orWhere('address1','LIKE',$v)
                    ->orWhere('city','LIKE',$v)
                    ->orWhere('zipcode',$search)
                    ->orWhere('county','LIKE', $v)
                    ->orderBy('name')
                    ->get();
        }
        
        if (count($rows) == 0)
            return 'Nothing matches that';
        return view('app.sites_results', ['rows'=>$rows, 'siteId'=>$user['site_id']??0 ]);
    }

    function switchSite(Request $request){
        $user = Auth::user();
        if ($user == null)
            return redirect('/login');

        if (!$siteId = $request['siteId'] ?? null)
            abort(500, 'Site ID required');
        
        $site = Sites::findOrFail($siteId);
    
        $user->site_id = $siteId;
        $user->save();

        return $site;
    }
}
