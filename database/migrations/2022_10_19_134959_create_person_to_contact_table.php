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
        Schema::create('person_to_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('firstnamePerson', 100);
            $table->string('lastnamePerson', 100);
            $table->string('addressPerson', 100)->nullable();
            $table->string('phonePerson', 12);
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
        Schema::dropIfExists('person_to_contacts');
    }
};
