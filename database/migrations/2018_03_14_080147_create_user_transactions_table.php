<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('account_number')->nullable(); //BillRefNumber
            $table->integer('amount')->nullable(); //TransAmount
            $table->string('business_short_code')->nullable();//BizShortCode
            $table->string('invoice_no')->nullable();
            $table->string('account_balance')->nullable();// OrgAccountBalance
            $table->string('third_party_id')->nullable();// ThirdPartyTransID
            $table->string('msisdn')->nullable(); // MSISDN/phonenumber

            $table->string('transaction_id', 50)->unique();
            $table->dateTime('transaction_time')->nullable();
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
        Schema::dropIfExists('user_transactions');
    }
}
