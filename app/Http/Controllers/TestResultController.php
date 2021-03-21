<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestResultController extends Controller
{
    public function result($check) {
        if ($check !== "positive" && $check !== "negative")
            return abort(404);

        $positive = false;
        $negative = false;
        if ($check === "positive")
            $positive = true;
        else
            $negative = true;

        return view('results', compact('positive', 'negative'));
    }

}
