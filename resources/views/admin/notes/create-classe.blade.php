@extends('layouts.admin')

@section('title', 'Ajouter des Notes - Par Classe')

@section('content')
<div class="container mt-4">

    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4 d-flex justify-content-between align-items-center">
            <h4 class="mb-0 text-white">📝 Ajout des Notes - Par Classe</h4>
            <a href="{{ route('note.index') }}" class="btn btn-warning btn-sm fw-bold px-3">⬅️ Retour</a>
        </div>

        <div class="card-body">
            <form action="{{ route('note.store') }}" method="POST">
                @csrf

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label>Année scolaire</label>
                        <select name="annee_id" id="annee_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($annees as $a)
                            <option value="{{ $a->id }}">{{ $a->libelle }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Classe</label>
                        <select name="classe_id" id="classe_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($classes as $c)
                            <option value="{{ $c->id }}">{{ $c->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Matière</label>
                        <select name="matiere_id" id="matiere_id" class="form-select" required>
                            <option value="">-- Sélectionner --</option>
                            @foreach($matieres as $m)
                            <option value="{{ $m->id }}" data-coefficient="{{ $m->coefficient ?? 1 }}">{{ $m->nom }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-3">
                        <label>Évaluation</label>
                        <select name="evaluation_id" id="evaluation_id" class="form-select" required>
                            @foreach($evaluations as $e)
                            <option value="{{ $e->id }}">{{ $e->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div id="table-container" class="table-responsive" style="display:none;">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Élève</th>
                                <th>Note de Devoir (CC)</th>
                                <th>Note d’Évaluation</th>
                            </tr>
                        </thead>
                        <tbody id="eleve-table-body">
                            <tr>
                                <td colspan="3" class="text-muted">Sélectionnez une classe pour charger les élèves...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary px-5 py-2 rounded-3">💾 Enregistrer les Notes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const classeSelect = document.getElementById('classe_id');
        const matiereSelect = document.getElementById('matiere_id');
        const tableContainer = document.getElementById('table-container');
        const tableBody = document.getElementById('eleve-table-body');

        classeSelect.addEventListener('change', function() {
            const classeId = this.value;
            const matiereId = matiereSelect.value;
            const coefficient = matiereSelect.selectedOptions[0]?.dataset.coefficient || 1;

            if (!classeId || !matiereId) {
                tableContainer.style.display = 'none';
                return;
            }

            tableBody.innerHTML = '<tr><td colspan="3" class="text-muted">Chargement...</td></tr>';
            tableContainer.style.display = 'block';

            fetch(`/admin/notes/eleves/${classeId}`)
                .then(res => res.json())
                .then(data => {
                    if (data.length === 0) {
                        tableBody.innerHTML = '<tr><td colspan="3" class="text-danger">Aucun élève trouvé pour cette classe.</td></tr>';
                        return;
                    }

                    let rows = '';
                    data.forEach(eleve => {
                        rows += `
                    <tr>
                        <td class="text-start"><strong>${eleve.nom} ${eleve.prenom}</strong></td>
                        <td>
                            <input type="number" step="0.01" min="0" max="20"
                                name="notes[${eleve.id}][${matiereId}][cc]"
                                class="form-control text-center" placeholder="Ex: 15,50">
                        </td>
                        <td>
                            <input type="number" step="0.01" min="0" max="20"
                                name="notes[${eleve.id}][${matiereId}][evaluation]"
                                class="form-control text-center" placeholder="Ex: 14,75">
                        </td>
                        <input type="hidden" name="notes[${eleve.id}][${matiereId}][coefficient]" value="${coefficient}">
                    </tr>`;
                    });
                    tableBody.innerHTML = rows;
                });
        });

        matiereSelect.addEventListener('change', function() {
            // Recharger la table pour appliquer le nouveau coefficient
            classeSelect.dispatchEvent(new Event('change'));
        });
    });
</script>
@endsection