<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        $id = Auth::id();

        $v = $request->get('v');

        $m = $request->get('m');

        $file = '/var/www/tokens/' . $id;

        if (file_exists($file)) {
            $token = file_get_contents($file);
        } else {
            $token = '0';
        }

            return view('home', ['token' => $token, 'id' => $id, 'v' => $v, 'm' => $m]);
    }
}
