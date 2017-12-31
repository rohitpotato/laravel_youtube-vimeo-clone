<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use App\Http\Requests\ChannelUpdateRequest;
use App\Jobs\UploadImage;

class ChannelSettingsController extends Controller
{
    public function edit(Channel $channel) 
    {	
    	$this->authorize("update", $channel);

    	return view('channel.settings.edit', compact('channel'));
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
  		 $this->authorize('update', $channel);

  		 $channel->update([

  		 	'name' => request('name'), 
  		 	'slug' => request('slug'),
  		 	'description' => request('description'),

  		 	]);

       if($request->file('image')) {

            $request->file('image')->move(storage_path() . '/uploads', $fileId = uniqid(true));

            $this->dispatch(new UploadImage($channel, $fileId));

       }

  		 return redirect()->route('channel.edit', $channel->slug);
    }
}
