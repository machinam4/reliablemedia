<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRadiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('radios', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('shortcode'); //This is the account number for the paybill or None for till
            $table->string('store')->unique(); //this is paybill number or till store number
            $table->string('mpesa_shortcode')->nullable(); //this identifies the till number icase of till
            $table->string('mpesa_type')->nullable(); //identifies if is paybill ot till (["paybill", "till"])
            $table->string('created_by');
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
        Schema::dropIfExists('radios');
    }
}
