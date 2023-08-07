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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches');

//            $table->string('region', 10)->nullable();
//            $table->string("zone", 15)->nullable();
//            $table->string("district", 25)->nullable();
//            $table->string("branch", 30)->nullable();

            $table->string('name')->nullable();
            $table->string('son_daughter_wife', 20)->nullable();
            $table->string('gender', 6)->nullable();
            $table->string('business_department_profession', 50)->nullable();
            $table->string('designation', 40)->nullable();
            $table->string('pp_number', 15)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('office_business_address')->nullable();
            $table->text('present_address', 5)->nullable();
            $table->text('permanent_address', 5)->nullable();
            $table->string('customer_cnic', 15)->nullable();
            $table->string('customer_contact_number', 20)->nullable();
            // this must include branch code....
            $table->string('account_cd_saving', 20)->nullable();
            $table->string('manual_account', 20)->nullable();
            // Facility detail
//            $table->string('type_of_facility_approved')->nullable();
//            $table->string('nature_of_facility_availed')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();;
            $table->foreign('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('product_type_id')->nullable();;
            $table->foreign('product_type_id')->references('id')->on('product_types');

            $table->string('renewal_enhancement_fresh_sanction')->nullable();
            $table->string('amount_sanctioned',14,2)->default(0.00);

            $table->decimal('amount_enhanced',14,2)->default(0.00);
            $table->date('sanction_date')->nullable();
            $table->integer('tenure_of_loan_in_months')->nullable();
            //monthly_quarterly_lump_sump
            $table->string('installment_type')->nullable();
            $table->decimal('emi_amount')->default(0.00);

            $table->string('no_of_installments')->nullable();
            $table->date('dac_issuance_date')->nullable();
            $table->date('disbursement_date')->nullable();
            $table->date('loan_due_date')->nullable();
            $table->decimal('amount_disbursed',14,2)->default(0.00);

            $table->date('expiry_date_as_per_dac')->nullable();
            $table->boolean('kibor_or_fixed')->default(0);
            $table->decimal('kibor_rate',10,2)->default(0.00);
            $table->decimal('bank_spread_rate',10,2)->default(0.00);
            $table->decimal('mark_up_rate',10,2)->default(0.00);
            $table->string('secure_unsecure_loan')->nullable();
            $table->string('branch_manager_name_while_sanctioning')->default(0.00);
            // installment
            $table->decimal('principle_amount',14,2)->default(0.00);

            $table->date('last_installment_date')->nullable();
            /*
                1 => Regular
                2 => Irregular
                3 => OAEM
                4 => Substandard
                5 => Doubtful
                6 => Loss
             */
            $table->enum('customer_status',[1,2,3,4,5,6])->default(1);
            $table->boolean('status')->default(1);

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
        Schema::dropIfExists('customers');
    }
};
