<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            // Définit CURRENT_TIMESTAMP et ON UPDATE CURRENT_TIMESTAMP
            $table->timestamp('date_concerne')->useCurrent()->useCurrentOnUpdate()->change();
            
            // Si la colonne 'type' posait aussi problème avec sa valeur par défaut 0 :
            // $table->integer('type')->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('paiements', function (Blueprint $table) {
            $table->timestamp('date_concerne')->nullable(false)->change();
        });
    }
};