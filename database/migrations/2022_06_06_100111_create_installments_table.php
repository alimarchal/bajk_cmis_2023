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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->date('date')->nullable();
            $table->decimal('principal_amount', 14, 2)->default(0.00);
            $table->decimal('mark_up_amount', 14, 2)->default(0.00);
            $table->decimal('penalty_charges', 14, 2)->default(0.00);
            $table->decimal('insurance_charges', 14, 2)->default(0.00);
            $table->decimal('principal_outstanding', 14, 2)->default(0.00);
            $table->decimal('total_principal_markup_penalty', 14, 2)->default(0.00);

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
        Schema::dropIfExists('installments');
    }
};
