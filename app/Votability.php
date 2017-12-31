<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use App\Vote;

trait Votability
{

    public static function bootVotability()
    {
        static::deleting(function($model) {

            $model->votes->each->delete();
        });
    }

     public function votes()
    {
        return $this->morphMany(Vote::class, 'voteable');
    }

    public function upVotes()
    {
        return $this->votes->where('type', 'up');
    }

    public function downVotes()
    {
        return $this->votes->where('type', 'down');
    }

    public function voteFromUser(User $user)
    {
        return $this->votes()->where('user_id', $user->id);
    }

}