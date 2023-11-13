<?php

use App\Models\Currency;
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
        Schema::create('currencies', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique();
            $table->decimal('rate', 16, 2);
            $table->decimal('special_rate', 16, 2)->default(1.0);
            $table->string('symbol')->nullable();
            $table->string('name')->nullable();
            $table->string('rate_source')->default(Currency::WORLD_BANK_RATE_SOURCE);

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
        Schema::dropIfExists('currencies');
    }
};
