<?php

namespace App\Jobs;

use Image;
use File;
use Storage;
use App\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
 
class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $channel;
    public $fileId;

    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path() . '/uploads/' . $this->fileId;
        $filename = $this->fileId . '.png';

        Image::make($path)->encode('png')->fit(40, 40, function ($c) {

            $c->upsize();
        })->save();

        if(Storage::disk('s3Images')->put('profile/' . $filename, fopen($path, 'r+'))) {

            File::delete($path);
        }

        $this->channel->image_filename = $filename;
        $this->channel->save();
    }
}
