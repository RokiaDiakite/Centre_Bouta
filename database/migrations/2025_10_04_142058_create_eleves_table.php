<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('eleves', function (Blueprint $table) {
            $table->id();
            $table->string('matricule')->unique();
            $table->string('nom');
            $table->string('prenom');
            $table->string('adresse')->nullable();
            $table->enum('sexe', ['M', 'F']);
            $table->date('date_naissance')->nullable();
            $table->string('lieu_naissance')->nullable();
            $table->string('nom_pere')->nullable();
            $table->string('nom_mere')->nullable();
            $table->foreignId('tuteur_id')
                ->constrained('tuteurs')
                ->onDelete('cascade');
            $table->foreignId('classe_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->enum('statut', ['actif', 'absent', 'abandon'])->default('actif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('eleves');
    }
};
