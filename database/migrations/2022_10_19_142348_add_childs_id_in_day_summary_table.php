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
        Schema::table('day_summary', function (Blueprint $table) {
            $table->bigInteger('childs_id')->unsigned(); 
            $table->foreign('childs_id')
                ->references('id')
                ->on('day_summary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('day_summary', function (Blueprint $table) {
            //
        });
    }
};
