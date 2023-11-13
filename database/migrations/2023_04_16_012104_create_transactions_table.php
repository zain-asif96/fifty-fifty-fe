<?php

use App\Models\Transaction;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('opposite_transaction_id')->index()->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('receiver_id');
            $table->unsignedBigInteger('payment_intent_id');

            $table->string('type')->default(Transaction::TYPE_DIRECT);
            $table->string('status');
            $table->string('payment_status');
            $table->timestamp('payment_to_receiver_completed_at')->nullable();
            $table->timestamp('payment_to_receiver_confirmed_at')->nullable();
            $table->timestamp('payment_to_opposite_receiver_confirmed_at')->nullable();
            $table->timestamp('transaction_completed_at')->nullable();
            $table->timestamp('transaction_canceled_at')->nullable();

            $table->string('hashed_id')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();

            $table->foreign('payment_intent_id')
                ->references('id')
                ->on('payment_intents')
                ->cascadeOnDelete();

            $table->foreign('receiver_id')
                ->references('id')
                ->on('receivers')
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
