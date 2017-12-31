<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Channel;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $videos = Auth::user()->subscribedChannels()->with(['videos' => function ($query) {

            $query->visible()->take(10);

       }])->get()->pluck('videos')->flatten();

        return view('home', compact('videos'));

    }
}
