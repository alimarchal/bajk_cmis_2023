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
        Schema::create('mark_up_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->date('date')->nullable();
            $table->decimal('markup_receivable_4600',14,2)->nullable();
            $table->decimal('markup_recovered_till_date',14,2)->nullable();
            $table->decimal('markup_recovered_ac_5008',14,2)->nullable();
            $table->decimal('markup_recovered_ac_2405',14,2)->nullable();

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
        Schema::dropIfExists('mark_up_details');
    }
};
