<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use File;
use Storage;
use FFMpeg;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;


class UploadVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    protected $video;

    public function __construct($video)
    {
       $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = storage_path() . '/app/uploads/' . $this->video->video_filename;

        $format = new FFMpeg\Format\Video\X264('libmp3lame', 'libx264');

        FFMpeg::fromDisk('local')->open("/uploads/{$this->video->video_filename}")->export()->toDisk('s3drop')->inFormat($format)->save("{$this->video->video_filename}");

        $this->video->processed = 1;
        $this->video->save();

        $filename = pathinfo($this->video->video_filename, PATHINFO_FILENAME);

        FFMpeg::fromDisk('local')->open("/uploads/{$this->video->video_filename}")->getFrameFromSeconds(3)->export()->toDisk('s3drop')->save("{$filename}_1.png");

        File::delete($file);
        
        /*if (Storage::disk('s3drop')->put($this->video, fopen($file, 'r+'))) {
            File::delete($file);
        }*/

    }
}
