<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Video extends Model
{

    use Searchable, Votability;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {

            $model->views->each->delete();
        });
    }

    protected $guarded = [];

    public function channel()
    {
    	return $this->belongsTo(Channel::class);
    }

    public function getRouteKeyName()
    {
    	return 'uid';
    }

    public function isProcessed()
    {
    	return $this->processed;
    }

    public function getThumbnail()
    {
    	if (!$this->isProcessed())
    	{
    		return config('codetube.buckets.videos') . '/default.jpg';
    	}

    	return config('codetube.buckets.videos') . '/' . $this->uid . '_1.png';
    }

    public function votesAllowed()
    {
        return (bool) $this->allow_votes;
    }

    public function commentsAllowed()
    {
        return (bool) $this->allow_comments;
    }

    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

    public function ownedByUser(User $user)
    {
        return $this->channel->user->id === $user->id;
    }

    public function canBeAccessed($user = null)
    {
        if (!$user && $this->isPrivate()) {

            return false;
        }

        if($user && $this->isPrivate() && ($user->id !== $this->channel->user_id)) {

            return false;
        }

        return true;
    }

    public function getStreamUrl()
    {
            return config('codetube.buckets.videos') . '/' . $this->video_filename;
    }

    public function views()
    {
        return $this->hasMany(VideoView::class);
    }

    public function viewCount()
    {
        return $this->views->count();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('reply_id');
    }

    public function scopeProcessed($query)
    {
        return $query->where('processed', true);
    }

    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    public function scopeVisible($query)
    {
        return $query->processed()->public();
    }

}
