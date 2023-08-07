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
        Schema::create('over_due_installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->date('date')->nullable();
            $table->decimal('no_of_installment',14,2)->nullable();
            $table->decimal('days_passed_overdue',14,2)->nullable();
            $table->decimal('principal_amount',14,2)->nullable();
            $table->decimal('mark_up_amount',14,2)->nullable();
            $table->decimal('penalty_charges',14,2)->nullable();
            $table->decimal('insurance_charges',14,2)->nullable();
            $table->decimal('total_principal_markup_penalty',14,2)->nullable();
            $table->string('category_of_default')->nullable();


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
        Schema::dropIfExists('over_due_installments');
    }
};
