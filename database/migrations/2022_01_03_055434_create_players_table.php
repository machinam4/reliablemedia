<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->id();
            $table->string("TransactionType")->nullable();
            $table->string("TransID")->nullable();
            $table->dateTime("TransTime")->nullable();
            $table->integer("TransAmount")->nullable();
            $table->string("BusinessShortCode")->nullable();
            $table->string("BillRefNumber")->nullable();
            $table->string("InvoiceNumber")->nullable();
            $table->integer("OrgAccountBalance")->nullable();
            $table->string("ThirdPartyTransID")->nullable();
            $table->string("MSISDN")->nullable();
            $table->string("FirstName")->nullable();
            $table->string("MiddleName")->nullable();
            $table->string("LastName")->nullable();
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
        Schema::dropIfExists('players');
    }
}
