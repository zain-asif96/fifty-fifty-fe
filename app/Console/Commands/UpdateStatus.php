<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\UpdateStatusTime;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the status of posts created exactly minutes added by admin';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        /*get post time*/
        $time = Carbon::now()->subMinutes(UpdateStatusTime::where('model_name','App\Models\Post')->first()->time);
        /*get posts created before the time*/
        $posts = Post::where('status', Post::AVAILABLE)
            ->where('is_selected', '=', '0')
            ->where('created_at', '<=', $time)
            ->get();

        /*update status of posts*/
        $posts->each(function ($post) {
            $post->update([
                'status' => Post::ON_HOLD,
                'put_on_hold_at' => Carbon::now(),
            ]);
        });
    }
}
