<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PaymentIntent extends Model
{
    use HasFactory;

    protected $fillable = ['stripe_payment_intent_id', 'status', 'receiver_id', 'amount', 'currency', 'payment_proof', 'amount_in_receiver_currency'];

    public static function getByStripePaymentId($id)
    {
        return PaymentIntent::where('stripe_payment_intent_id', $id)->first();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function receiver(): HasOne
    {
        return $this->hasOne(Receiver::class);
    }

    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::create($created_at)->toFormattedDateString();
    }
}
