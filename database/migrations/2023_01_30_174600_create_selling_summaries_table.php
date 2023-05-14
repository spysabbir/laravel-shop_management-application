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
        Schema::create('selling_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('selling_invoice_no');
            $table->date('selling_date');
            $table->integer('customer_id');
            $table->float('sub_total');
            $table->float('discount')->nullable();
            $table->float('grand_total');
            $table->string('payment_status');
            $table->float('payment_amount');
            $table->integer('selling_agent_id');
            $table->integer('branch_id');
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
        Schema::dropIfExists('selling_summaries');
    }
};
