<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->string('payment_type');
            $table->string('payment_year');
            $table->string('payment_month');
            $table->float('payment_amount');
            $table->text('payment_note')->nullable();
            $table->integer('payment_by');
            $table->dateTime('payment_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff_payments');
    }
};
