<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemainesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semaines', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->unique('date_debut');
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
        Schema::dropIfExists('semaines');
        Schema::table('semaines', function (Blueprint $table) {
            $table->dropUnique(['date_debut']);
        });
    }
}
