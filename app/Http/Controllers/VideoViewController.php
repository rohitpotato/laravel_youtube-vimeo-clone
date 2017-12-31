<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\VideoView;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Redis;

class VideoViewController extends Controller
{
	const BUFFER = 30;

    public function create(Request $request, Video $video)
    {
    	if(!$video->canBeAccessed($request->user())) {

    		return false;
    	}

    	if($request->user()) {

    		$lastUserView = $video->views()->where('user_id', Auth::user()->id)->latest()->first();

    		if($this->withinBuffer($lastUserView)) {

    			return;
    		}
    	}

    	$lastIpView = $video->views()->where('ip', $request->ip())->latest()->first();

    	if($this->withinBuffer($lastIpView)) {

    		return;
    	}

      Redis::zincrby('trending_vids', 1, json_encode([

        'title' => $video->title,
        'thumbnail' => $video->getThumbnail(),
        'visibility' => $video->visibility,
        'channel' => $video->channel(),
        'uid' => $video->uid,
        'description' => $video->description,
        'view_count' => $video->viewCount(),
        'created_at' => $video->created_at,
        'channel_name' => $video->channel->name,
        'channel_slug' => $video->channel->slug

        ]));


    	$video->views()->create([

    		'user_id' => $request->user() ? $request->user()->id : null,
    		'ip' => $request->ip(),

    		]);

    	return response()->json(null, 200);
    }

    public function withinBuffer($view)
    {
    	return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
    }
}
