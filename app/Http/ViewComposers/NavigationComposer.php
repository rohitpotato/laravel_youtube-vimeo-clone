<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;
use Auth;


class NavigationComposer 
{
	public function compose(View $view)
	{
		if(!Auth::check()) {
			return;
		}

		$view->with('channel', Auth::user()->channel->first());
	}
}