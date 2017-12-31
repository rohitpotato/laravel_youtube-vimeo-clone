<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class TrendingController extends Controller
{
    public function index()
    {
    	 $videos = array_map('json_decode', Redis::zrevrange('trending_vids', 0, 1));

    	 return view('video.trending', compact('videos'));
    }
}
