<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('first_name_normalised')->virtualAs("regexp_replace(first_name, '[^A-Za-z0-9]', '')")->index();
            $table->string('last_name');
            $table->string('last_name_normalised')->virtualAs("regexp_replace(last_name, '[^A-Za-z0-9]', '')")->index();
            $table->string('company');
            $table->string('company_normalised')->virtualAs("regexp_replace(company, '[^A-Za-z0-9]', '')")->index();
            $table->string('position');
            $table->string('email')->nullable();
            $table->date('date_of_birth')->nullable();
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
        Schema::dropIfExists('contacts');
    }
}
