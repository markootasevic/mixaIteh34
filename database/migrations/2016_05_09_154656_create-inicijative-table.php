<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInicijativeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inicijative', function (Blueprint $table) {
            $table->increments('id');
            $table->string('imePrezime');
            $table->string('nazivPrivrednogSubjekta')->nullable();
            $table->string('adresa');
            $table->string('email');
            $table->string('nazivProcedure');
            $table->string('nazivZakona');
            $table->string('nazivClana')->nullable();
            $table->string('primedbe');
            $table->string('predlogIzmene');
            $table->string('prilog')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('inicijative', function (Blueprint $table) {
            Schema::drop('inicijative');
        });
    }
}
