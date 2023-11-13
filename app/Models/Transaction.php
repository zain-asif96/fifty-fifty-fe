<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Uuid;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    const TYPE_DIRECT = 'direct';
    const TYPE_OPPOSITE = 'opposite';

    // Transaction Statuses:
    const TRANSACTION_INITIALIZED = 'transaction_initialized';
    const PAIRING_PENDING = 'pairing_pending';
    const PAIRING_COMPLETE = 'pairing_complete';

    const PAYMENT_TO_RECEIVER_PENDING = 'payment_to_receiver_pending';
    const PAYMENT_TO_RECEIVER_COMPLETE = 'payment_to_receiver_complete';
    const PAYMENT_TO_RECEIVER_CONFIRMED = 'payment_to_receiver_confirmed';

    const PAYMENT_TO_OPPOSITE_RECEIVER_PENDING = 'payment_to_opposite_receiver_pending';
    const PAYMENT_TO_OPPOSITE_RECEIVER_COMPLETE = 'payment_to_opposite_receiver_complete';
    const PAYMENT_TO_OPPOSITE_RECEIVER_CONFIRMED = 'payment_to_opposite_receiver_confirmed';

    const TRANSACTION_COMPLETED = 'transaction_completed';
    const TRANSACTION_CANCELLED = 'transaction_cancelled';

    // Payment statuses:
    const PAYMENT_NOT_REQUIRED = 'not_required';
    const PAYMENT_ON_HOLD = 'on_hold';
    const PAYMENT_RELEASED = 'released';
    const PAYMENT_FEES_CAPTURED = 'fees_captured';
    const PAYMENT_CAPTURED = 'captured';

    protected $guarded = [];
    protected $with = ['paymentIntent', 'receiver'];

    public function newUniqueId(): string
    {
        return (string)substr(Uuid::uuid4(), -12);
    }

    public function user(): BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function receiver(): BelongsTo
    {
        return $this->BelongsTo(Receiver::class);
    }

    public function paymentIntent(): BelongsTo
    {
        return $this->BelongsTo(PaymentIntent::class);
    }

    public function oppositeTransaction(): HasOne
    {
        return $this->hasOne(Transaction::class, 'opposite_transaction_id');
    }

    // attributes:
    public function getCreatedAtAttribute($created_at)
    {
        $date = new Carbon($created_at);
        return $date->diffForHumans();
    }

    public function getUpdatedAtAttribute($updated_at)
    {
        $date = new Carbon($updated_at);
        return $date->diffForHumans();
    }

    public function getPaymentToReceiverCompletedAtAttribute($completedAt)
    {
        if(!$completedAt) return null;
        $date = new Carbon($completedAt);
        return $date->diffForHumans();
    }

    public function getPaymentToReceiverConfirmedAtAttribute($confirmedAt)
    {
        if(!$confirmedAt) return null;
        $date = new Carbon($confirmedAt);
        return $date->diffForHumans();
    }

    public function getPaymentToOppositeReceiverConfirmedAtAttribute($confirmedAt)
    {
        if(!$confirmedAt) return null;
        $date = new Carbon($confirmedAt);
        return $date->diffForHumans();
    }

    public function getTransactionCompletedAtAttribute($completedAt)
    {
        if(!$completedAt) return null;
        $date = new Carbon($completedAt);
        return $date->diffForHumans();
    }


    public function getTransactionCancelledAtAttribute($cancelledAt)
    {
        if(!$cancelledAt) return null;
        $date = new Carbon($cancelledAt);
        return $date->diffForHumans();
    }

    public function post(): HasOne
    {
        return $this->hasOne(Post::class);
    }


    // TODO: get public transaction method.
}
