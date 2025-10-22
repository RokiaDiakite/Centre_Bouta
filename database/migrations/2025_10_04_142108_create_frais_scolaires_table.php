<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frais_scolaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade');
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade');
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->decimal('montant_total', 10, 2)->default(0);
            $table->decimal('montant_paye', 10, 2)->default(0);
            $table->decimal('reliquat', 10, 2)->default(0);
            $table->date('date_paiement')->nullable();
            $table->string('mode_de_paiement')->nullable();
            $table->string('fichier_pdf')->nullable();
            $table->string('numero_recu')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frais_scolaires');
    }
};
