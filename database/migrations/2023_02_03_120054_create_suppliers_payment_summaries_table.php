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
        Schema::create('suppliers_payment_summaries', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id');
            $table->string('purchase_invoice_no');
            $table->float('grand_total');
            $table->string('payment_status');
            $table->string('payment_method')->nullable();
            $table->float('payment_amount');
            $table->integer('payment_agent_id');
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
        Schema::dropIfExists('suppliers_payment_summaries');
    }
};
