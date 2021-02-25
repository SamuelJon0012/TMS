<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit(User $user)
    {
        $user = Auth::user();
        $jsonobj =  json_decode($user->json);
/*
    @if(Auth::check() && Auth::user()->hasRole('patient'))
    @include('app.patient_modals')
    @include('app.patient_js')
    @endif

    @if(Auth::check() && Auth::user()->hasRole('provider'))
    @include('app.provider_modals')
    @include('app.provider_js')
    @endif
 */

        if (empty($user->json)) {

            // default to patient
            $jsonobj = json_decode('{"first_name":"","last_name":"","date_of_birth":"1970-01-01","phone_number":"","phone_type":"0","address1":"","address2":"","city":"","state":"","zipcode":"","ssn":"","phone_number1":"","phone_type1":"0","dl_state":"","dl_number":"","ethnicity":"0","race":"0","birth_sex":"0"}');

            if ($user->hasRole('provider')) {
                $jsonobj = json_decode('{"first_name":"","last_name":"","npi":""}');
            }
        }

       # dd($jsonobj);

        return view('profile.edit', compact('user','jsonobj'));
    }

    public function update(User $user)
    {
        $this->validate(request(), [

            'first_name' => 'required',
            'last_name' => 'required',

        ]);
        $data = json_encode($_REQUEST);

        // echo $data;
        // echo "<br><br>";
        // var_dump($_REQUEST);
        // echo "<br><br>";
        $user->name = request('first_name')." ".request('last_name');
        $user->json = $data;
        $user->dob = request('date_of_birth') ?? '';

        // var_dump($user);
        // die();

        $user->save();
        return redirect()->back()->with('message', 'Updated Successfully!');

        //return back();
    }
}
