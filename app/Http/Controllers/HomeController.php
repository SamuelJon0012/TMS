<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sites;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (!$user = Auth::user())
            redirect('/login');

        if ($user->site_id){
            $site = Sites::where('id',$user->site_id)->first();
            $siteName = $site->name ?? '';
        } else
            $siteName = '';

        $v = $request->get('v');

        $m = $request->get('m');

        $file = '/var/www/tokens/' . $user->id;

        if (file_exists($file)) {
            $token = file_get_contents($file);
        } else {
            $token = '0';
        }
            return view('home', ['token' => $token, 'id' => $user->id, 'v' => $v, 'm' => $m, 'siteId'=>$user->site_id, 'siteName'=>$siteName]);
    }
}
