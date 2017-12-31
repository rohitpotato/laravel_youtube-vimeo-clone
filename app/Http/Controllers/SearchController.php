<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Video;

class SearchController extends Controller
{
    public function index(Request $request)
    {
    	if(!$request->q) {

    		return redirect()->back();
    	}

    	$channels = Channel::search($request->q)->take(7)->get();
    	$videos = Video::search($request->q)->get();


    	return view('search.index', compact('channels', 'videos'));
    }
}
