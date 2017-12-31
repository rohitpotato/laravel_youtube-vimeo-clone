<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use Auth;
use App\Vote;

class VideoVoteController extends Controller
{
    public function show(Request $request, Video $video)
    {

    	$response = [

    		'up' => null,
    		'down' => 'null',
    		'can_vote' => $video->votesAllowed(),
    		'user_vote' => null,

    	];

    	if($video->votesAllowed()) {

    		$response['up'] = $video->upVotes()->count();
    		$response['down'] = $video->downVotes()->count();
    	}

    	if(Auth::check()) {

    		$voteFromUser = $video->voteFromUser($request->user())->first();

    		$response['user_vote'] = $voteFromUser ? $voteFromUser->type : null;
    	}

    	return response()->json($response, 200);
    }

    public function create(Request $request, Video $video)
    {
    	$this->authorize('vote', $video);

    	$this->validate($request, [

    		'type' => 'required|in:up,down',

    		]);

    	
    		$video->voteFromUser($request->user())->delete();

    		$video->votes()->create([

    			'type' => $request->type,
    			'user_id' => auth()->id()

    			]);

    		return response()->json(null, 200);
    	

    }

    public function delete(Request $request, Video $video)
    {
    	$this->authorize('vote', $video);

    	$video->votes()->where('user_id', auth()->id())->first()->delete();

    	return response()->json(null, 200);
    }
}
