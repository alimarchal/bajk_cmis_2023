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
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('Ac_Number')->nullable();
            $table->string('Product')->nullable();
            $table->string('O_S')->nullable();
            $table->string('Amount_of_Inst')->nullable();
            $table->string('Date')->nullable();
            $table->string('Days_Passed_Overdue')->nullable();
            $table->string('Principal_Amount')->nullable();
            $table->string('Markup_')->nullable();
            $table->string('Penalty_Charges')->nullable();
            $table->string('Total')->nullable();
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
        Schema::dropIfExists('tests');
    }
};
