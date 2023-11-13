<?php

namespace App\Models;

use App\Classes\GeoLocation;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Post extends Model
{
    use HasFactory;

    const AVAILABLE = 'available';
    const CANCELLED = 'cancelled';
    const ON_HOLD = 'on_hold';
    const COMPLETED = 'completed';

    public static function STATUSES(): array
    {
        return [
            self::AVAILABLE,
            self::CANCELLED,
            self::ON_HOLD,
            self::COMPLETED,
        ];
    }


    protected $guarded = [];

    public static function createTransactionPost($transaction)
    {
        return Post::create([
            'transaction_id' => $transaction->id,
            'country_code' => $transaction->receiver->country,
            'status' => Post::AVAILABLE
        ]);
    }

    public static function getAvailablePosts($limit = 100, $withOnHold = false, $countryCode = null)
    {
        if(!$countryCode){
            $locationDetails = GeoLocation::getCurrentUserLocationDetails();
            $countryCode = $locationDetails['country_code'];
        }


        $postStatuses = [Post::AVAILABLE];

        if($withOnHold){
            $postStatuses[] = Post::ON_HOLD;
        }

        $posts = Post::select('country_code', 'status', 'created_at', 'id', 'transaction_id')
            ->with([
                'transaction:id,hashed_id,user_id,payment_intent_id,receiver_id',
                'transaction.user:id,first_name,country',
                'transaction.receiver:id,first_name,country',
                'transaction.paymentIntent:id,currency,amount,amount_in_receiver_currency',
            ])
            ->where('country_code', $countryCode)
            ->whereIn('status', $postStatuses)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $posts->each(function ($post) {
            $post->transaction_id = $post->transaction->hashed_id;
            $post->transaction->id = $post->transaction->hashed_id;
        });

        return $posts;
    }

    // attributes:
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    // Helpers:

    public function getCreatedAtAttribute($created_at)
    {
        $date = new Carbon($created_at);
        return $date->diffForHumans();
    }

    public function putOnHold(): bool
    {
        return $this->update([
            'status' => Post::ON_HOLD,
            'put_on_hold_at' => Carbon::now()
        ]);
    }

    public function putOnHoldSelected(): bool
    {
        return $this->update([
            'status' => Post::ON_HOLD,
            'is_selected' => true, // this is to make sure that the post is not available for other users.
            'put_on_hold_at' => Carbon::now()
        ]);
    }

    public function makeAvailable(): bool
    {
        // we can not make it available if the corresponding transaction has any state higher than pairing pending.
        return $this->update([
            'status' => Post::AVAILABLE,
            'put_on_hold_at' => null,
            'created_at' => Carbon::now(),
        ]);
    }

}
