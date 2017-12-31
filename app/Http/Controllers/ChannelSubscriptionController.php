<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Auth;

class ChannelSubscriptionController extends Controller
{
    public function show(Request $request, Channel $channel)
    {
    	$response = [

    		'count' => $channel->subscriptionCount(),
    		'user_subscribed' => false,
    		'can_subscribe' => false,

    	];

    	if(Auth::check())
    	{
    		$response['user_subscribed'] = Auth::user()->isSubscribedTo($channel);

    		$response['can_subscribe'] = !Auth::user()->ownsChannel($channel);
    	}

    	return response()->json($response, 200);
    }

    public function create(Channel $channel)
    {
       if(!Auth::user()->ownsChannel($channel) && !Auth::user()->isSubscribedTo($channel)) {

             $channel->subscriptions()->create(['user_id' => auth()->id()]);

            return response()->json(null, 200);
       }

       return false;
    }

    public function delete(Channel $channel)
    {
        if(Auth::user()->isSubscribedTo($channel)) {

            
            $channel->subscriptions()->where('user_id', auth()->id())->delete();

            return response()->json(null, 200);
        }
    }
}
