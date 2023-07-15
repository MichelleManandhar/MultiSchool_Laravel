<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SinglePageController extends Controller
{
    public function index() {
        try{
            return view('app');
        } catch (Exception $e) {
            throw $e;
        }
    }
}
