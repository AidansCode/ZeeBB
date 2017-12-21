<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;

class PageController extends Controller
{
    public function __construct()
    {
        //
    }

    public function index() {
        $allForums = Forum::all();
        return view('pages.index')->with('forums', $allForums);
    }
}
