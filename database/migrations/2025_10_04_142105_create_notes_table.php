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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained('classes')->onDelete('cascade');
            $table->foreignId('eleve_id')->constrained('eleves')->onDelete('cascade');
            $table->foreignId('matiere_id')->constrained('matieres')->onDelete('cascade');
            $table->foreignId('evaluation_id')->constrained('evaluations')->onDelete('cascade');
            $table->decimal('coefficient', 5, 2)->default(1);
            $table->foreignId('annee_scolaire_id')->constrained('annee_scolaires')->onDelete('cascade');
            $table->decimal('note_devoir', 5, 2)->nullable();
            $table->decimal('note_evaluation', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
