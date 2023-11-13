<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\UpdateStatusTime;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePostTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:post-transaction';

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
        $time = Carbon::now()->subMinutes(UpdateStatusTime::where('model_name','App\Models\Transaction')->first()->time);
        /*get posts created before the time*/
        $posts = Post::where('status', Post::ON_HOLD)
            ->where('is_selected', '=', 1)
            ->where('put_on_hold_at', '<=', $time)
            ->get();

//        dd($time->toDateTimeString(), Carbon::now()->toDateTimeString(), $posts);

        /*update status of posts*/
        $posts->each(function ($post) {
            $post->update([
                'status' => Post::AVAILABLE,
                'put_on_hold_at' => null,
                'is_selected' => 0,
                'created_at' => Carbon::now(),
            ]);
        });

    }
}
