<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('payment_intents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('receiver_id')->nullable();

            $table->string('stripe_payment_intent_id')->nullable();
            $table->string('status')->nullable();
            $table->decimal('amount', 16, 2);
            $table->decimal('amount_in_receiver_currency', 16, 2)->default(0);
            $table->string('currency');
            $table->text('payment_proof')->nullable();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
    public function down(): void
    {
        Schema::dropIfExists('payment_intents');
    }
};
