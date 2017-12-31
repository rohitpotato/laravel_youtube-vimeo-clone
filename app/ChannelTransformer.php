<?php

namespace App;
use App\Channel;

use League\Fractal\TransformerAbstract;

class ChannelTransformer extends TransformerAbstract
{
	protected $availableIncludes = [

			'channel'	
		];

	public function transform(Channel $channel)
	{
		
		return [

			'name' => $channel->name,
			'slug' => $channel->slug,
			'image' => $channel->getImage(),
		];
	}
}