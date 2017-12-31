<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\UploadVideo;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;


class testerController extends Controller
{
    public function index()
    {
        return view('video.upload');
    }

    public function store(Request $request)
    {

        $channel = $request->user()->channel()->first();

        $video = $channel->videos()->where('uid', $request->uid)->firstOrFail();

        $request->file('video')->move(storage_path() . '/app/uploads', $video->video_filename);

        //$enc = FFMpeg::open('uploads'. '\\' . $video->video_filename)->export()->todisk('local')->inFormat(new \FFMpeg\Format\Video\X264)->save("{$video->video_filename}");

        $this->dispatch(new UploadVideo($video));

        return response()->json(null, 200);
    }
}
