<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('paiements_maitres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maitre_id')->constrained('maitres')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade');
            $table->decimal('montant', 10, 2);
            $table->string('mois');
            $table->date('date_paiement');
            $table->string('mode_paiement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paiement_maitres');
    }
};
