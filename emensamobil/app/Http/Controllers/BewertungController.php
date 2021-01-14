<?php


namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BewertungController extends BaseController
{
    function show(Request $rd) {
        if (session('auth') != 'token') {
            return redirect()->to('/');
        } else {
            return view('bewertung', ['request' => $rd]);
        }
    }

    function rate(Request $rd) {
        var_dump($_POST);
    }
}
