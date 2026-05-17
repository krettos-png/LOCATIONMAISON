<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
   {
       Schema::table('maisons', function (Blueprint $table) {
           $table->unsignedBigInteger('vues')->default(0)->after('prix'); 
           // Cela crée la colonne 'vues', commence à 0, et la place après le prix
       });
   }

    /**
     * Reverse the migrations.
     */
    public function down(): void
   {
       Schema::table('maisons', function (Blueprint $table) {
           $table->dropColumn('vues');
       });
   }
};
