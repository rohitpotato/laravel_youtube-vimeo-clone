<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Video;
use App\Http\Requests\VideoUpdateRequest;  
use Illuminate\Support\Facades\Redis;
use App\User;
use App\Notifications\NewVideoAdded;

class VideoController extends Controller
{
    public function index()
    {
        $videos = request()->user()->videos()->latest()->get();
        return view('video.index', compact('videos'));
    }

    public function edit(Video $video)
    {
        $this->authorize('update', $video);
        return view('video.edit', compact('video'));
    }

    public function show(Video $video)
    {
        return view('video.show', compact('video'));
    }

    public function update(VideoUpdateRequest $request, Video $video)
    {
        $this->authorize('update', $video);

        $video->update([

            'title' => $request->title,
            'description' => $request->description,
            'visibility' => request('visibility'),
            'allow_votes' => $request->has('allow_votes'),
            'allow_comments' => $request->has('allow_comments'),

            ]);

       if($request->ajax()) {

            return response()->json(null, 200);
        }

        return back();
    }

    public function store(Request $request)
    {
    	$uid = uniqid(true);

    	$channel = request()->user()->channel()->first();

    	$video = $channel->videos()->create([

    			'uid' => $uid,
    			'title' => $request->title,
    			'description' => $request->description,
    			'visibility' => $request->visibility,
    			'video_filename' => "{$uid}.{$request->extension}",

    		]);

          $users = $video->channel->subscriptions()->pluck('user_id');

          User::whereIn('id', $users)->get()->each( function ($user) use ($video) {

                $user->notify(new NewVideoAdded($video));

          });

         return response()->json([
            'uid' => $uid
        ]);
    }

    public function delete(Video $video)
    {
         $this->authorize('update', $video);
        $video->delete();
        return back();
    }
}
