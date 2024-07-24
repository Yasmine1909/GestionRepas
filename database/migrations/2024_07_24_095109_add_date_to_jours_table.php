<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDateToJoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jours', function (Blueprint $table) {
            $table->date('date')->after('semaine_id'); // Ajouter la colonne 'date' après la colonne 'semaine_id'
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jours', function (Blueprint $table) {
            $table->dropColumn('date'); // Supprimer la colonne 'date'
        });
    }
}
