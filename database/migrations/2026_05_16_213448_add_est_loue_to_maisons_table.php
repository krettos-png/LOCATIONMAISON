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
        // Par défaut, la maison n'est PAS louée (false) lors de sa création
        $table->boolean('est_loue')->default(false)->after('prix'); 
    });
}

public function down(): void
{
    Schema::table('maisons', function (Blueprint $table) {
        $table->dropColumn('est_loue');
    });
}
};

