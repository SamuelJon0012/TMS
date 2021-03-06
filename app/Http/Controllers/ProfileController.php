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

        $id = Auth::id();

        if($user->hasRole('patient')) { # For provider, use the json array (currently referenced in edit.blade)

            $BC = new BurstIqController();
                $id=4577; # Yain't Getting Nuthin Cuz Yaint Got No Patients In Staging
            $data = $BC->getPatient($id);

            # Gotta pivot to BlockChain stuff, sorry.  Come back again

            dd($data);

            return view('profile.edit', compact('user', 'jsonobj'));

        }
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
