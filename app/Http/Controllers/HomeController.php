<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Record;

class HomeController extends Controller
{
    public function index()
    {
        $records = Record::orderBy('date')->get();
        return view('home', compact('records'));
    }
}
