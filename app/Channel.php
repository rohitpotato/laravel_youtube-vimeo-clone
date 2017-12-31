<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Channel extends Model
{
     use Searchable;

     protected $guarded = [];

     public function user()
     {
     	return $this->belongsTo(User::class);
     }

     public function getRouteKeyName()
     {
     	return 'slug';
     }

     public function videos()
     {
     	return $this->hasMany(Video::class);
     }

     public function getImage()
     {
          if(!$this->image_filename)
          {
               return config('codetube.buckets.images') . '/profile/default.jpg';
          }

          return config('codetube.buckets.images') . '/profile/' . $this->image_filename;
     }

     public function subscriptions()
     {
          return $this->hasMany(Subscription::class);
     }

     public function subscriptionCount()
     {
          return $this->subscriptions()->count();
     }

     public function totalVideoViews()
     {
          $totalviews = 0;

          foreach($this->videos as $video)
          {
               $totalviews =$totalviews + $video->viewCount();
          }

          return $totalviews;
     }
}
