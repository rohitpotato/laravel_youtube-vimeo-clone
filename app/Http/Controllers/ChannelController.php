<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;

class ChannelController extends Controller
{
    public function show(Channel $channel)
    {
    	$videos = $channel->videos()->get();
    	return view('channel.show', compact('channel', 'videos'));
    }
}
