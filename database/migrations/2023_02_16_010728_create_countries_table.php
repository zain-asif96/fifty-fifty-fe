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
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('currency_id');

            $table->string('code')->unique();
            $table->string('code_iso_2')->unique()->nullable();
            $table->string('label');

            $table->char('can_send', 1)->nullable();
            $table->char('can_receive', 1)->nullable();

            $table->string('tel_code')->nullable();
            $table->string('continent')->nullable();
            $table->string('area')->nullable();
            $table->string('population')->nullable();


            $table->foreign('currency_id')
                ->references('id')
                ->on('currencies');

            $table->index('code');
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
        Schema::dropIfExists('countries');
    }
};
