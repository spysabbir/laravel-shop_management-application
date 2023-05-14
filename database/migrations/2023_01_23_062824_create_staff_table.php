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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->string('profile_photo')->default('default_profile_photo.png');
            $table->string('staff_name');
            $table->string('staff_position');
            $table->string('staff_email');
            $table->string('staff_phone_number');
            $table->string('staff_gender');
            $table->string('staff_nid_no')->nullable();
            $table->date('staff_date_of_birth')->nullable();
            $table->text('staff_address');
            $table->float('staff_salary');
            $table->string('status')->default('Active');
            $table->integer('created_by');
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('staff');
    }
};
