<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function index()
    {
        return view('pages.admin.screens.screens');
    }
}
