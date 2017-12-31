<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Video;
use App\CommentTransformer;
use App\Comment;

class VideoCommentController extends Controller
{
    public function index(Video $video)
    {
    	return response()->json(

    		fractal()->collection($video->comments()->latestFirst()->get())
    			->parseIncludes(['channel', 'replies', 'replies.channel'])
    			->transformWith(new CommentTransformer)->toArray()

    		);
    }

    public function create(Request $request, Video $video)
    {
    	$this->validate($request, ['body' => 'required', 'reply_id' => 'exists:comments,id']);

    	$this->authorize('vote', $video);

    	$comment = $video->comments()->create([

    			'body' => $request->body,
    			'reply_id' => $request->get('reply_id', null),
    			 'user_id' => auth()->id(),

    		]);

    	return response()->json(

    				fractal()->item($comment)->parseIncludes(['channel'])->transformWith(new CommentTransformer)->toArray()

    		);
    }

    public function delete(Video $video, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 200);
    }
}
