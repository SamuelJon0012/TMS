<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sites;
use App\SiteProfile;
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
        
        $SP = new SiteProfile();

        $user = Auth::user();
        if ($user == null)
            abort(401, 'Please login');

        $search = $request->get('q');
        if (empty($search)){
            
            $rows = $SP->find(" WHERE asset.customer_product_id =2");

        } else {
            $v = "%$search%";
            $query = ' WHERE asset.customer_product_id =2 and (asset.name like \''.$v.'\' or asset.address1 like \''.$v.'\' or asset.city like \''.$v.'\' or asset.zipcode like \''.$v.'\' or asset.county like \''.$v.'\' or asset.name like \''.$v.'\' )';
            $rows = $SP->find($query);
            
//             $rows = Sites::where('name','LIKE',$v)
//                     ->orWhere('address1','LIKE',$v)
//                     ->orWhere('city','LIKE',$v)
//                     ->orWhere('zipcode',$search)
//                     ->orWhere('county','LIKE', $v)
//                     ->orderBy('name')
//                     ->take(50)
//                     ->get();
        }

        if (count($rows->data->records) == 0)
            return 'Nothing matches that';
        return view('app.sites_results', ['rows'=>$rows->data->records, 'siteId'=>$user['site_id']??0 ]);
    }

    function switchSite(Request $request){
        $user = Auth::user();
        if ($user == null)
            abort(401, 'Please login');

        if (!$siteId = $request['siteId'] ?? null)
            abort(500, 'Site ID required');
        
        $site = Sites::findOrFail($siteId);
    
        $user->site_id = $siteId;
        $user->save();

        return $site;
    }
}
