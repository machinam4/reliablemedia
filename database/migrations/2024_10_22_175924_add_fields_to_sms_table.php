<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToSmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('s_m_s', function (Blueprint $table) {
            $table->string('category')->nullable();
            $table->text('message')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            // If needed, add a foreign key constraint for 'updated_by'
            // $table->foreign('updated_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('s_m_s', function (Blueprint $table) {
            $table->dropColumn(['category', 'message', 'updated_by']);
        });
    }
}
