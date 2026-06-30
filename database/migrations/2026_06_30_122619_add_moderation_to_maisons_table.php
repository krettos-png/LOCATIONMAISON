<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maisons', function (Blueprint $blueprint) {
            // Par défaut, on met 'en_attente' pour forcer la modération des futures annonces
            // Tu peux mettre 'publiee' si tu veux que tes anciennes maisons restent visibles immédiatement
            $blueprint->string('statut_moderation')->default('en_attente')->after('prix');
        });
    }

    public function down(): void
    {
        Schema::table('maisons', function (Blueprint $blueprint) {
            $blueprint->dropColumn('statut_moderation');
        });
    }
};