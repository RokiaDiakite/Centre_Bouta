@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <!-- Formulaire de filtrage -->
    <div class="no-print">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
            <h2 class="mb-2">📚 Gestion des Notes</h2>
            <div class="btn-group mb-2">
                <a href="{{ route('note.create') }}" class="btn btn-success btn-sm">➕ Ajouter / Élève</a>
                <a href="{{ route('note.create.classe') }}" class="btn btn-info btn-sm">➕ Ajouter / Classe</a>
            </div>
        </div>
        <form action="{{ route('note.fiche') }}" method="GET" class="row g-2 mb-3">
            <div class="col-md-3">
                <select name="annee_id" class="form-control" required>
                    <option value="">-- Année scolaire --</option>
                    @foreach($annees as $a)
                    <option value="{{ $a->id }}" {{ request('annee_id') == $a->id ? 'selected' : '' }}>{{ $a->libelle }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="classe_id" class="form-control" required>
                    <option value="">-- Classe --</option>
                    @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ request('classe_id') == $c->id ? 'selected' : '' }}>{{ $c->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="matiere_id" class="form-control" required>
                    <option value="">-- Matière --</option>
                    @foreach($matieres as $m)
                    <option value="{{ $m->id }}" {{ request('matiere_id') == $m->id ? 'selected' : '' }}>{{ $m->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="evaluation_id" class="form-control" required>
                    <option value="">-- Évaluation --</option>
                    @foreach($evaluations as $e)
                    <option value="{{ $e->id }}" {{ request('evaluation_id') == $e->id ? 'selected' : '' }}>{{ $e->nom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100">🔍 Rechercher</button>
            </div>
        </form>
    </div>

    <!-- Bouton imprimer -->
    @if(isset($notes) && count($notes) > 0)
    <div class="no-print" style="text-align:center; margin-bottom:10px;">
        <button onclick="window.print()" class="btn btn-primary btn-sm">🖨 Imprimer la fiche</button>
    </div>
    @endif

    <!-- Tableau de notes -->
    @if(isset($notes) && count($notes) > 0)
    <div class="printable">
        <h1 style="text-align:center;">Complexe Scolaire Centre Bouta</h1>
        <h2 style="text-align:center;">Fiche de notes</h2>
        <p style="text-align:center;">
            Année: {{ $annee->libelle }} | Classe: {{ $classe->nom }} | Matière: {{ $matiere->nom }} | Évaluation: {{ $evaluation->nom }}
        </p>

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Élève</th>
                        <th>Note devoir</th>
                        <th>Note évaluation</th>
                        <th>Coefficient</th>
                        <th class="no-print">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notes as $note)
                    <tr>
                        <td>{{ $note->eleve->nom }} {{ $note->eleve->prenom }}</td>
                        <td>{{ $note->note_devoir ?? '-' }}</td>
                        <td>{{ $note->note_evaluation ?? '-' }}</td>
                        <td>{{ $note->matiere->coefficient ?? '-' }}</td>
                        <td class="no-print">
                            <a href="{{ route('note.edit', $note->id) }}" class="btn btn-sm btn-primary">
                                ✏️ Modifier
                            </a>

                            <form action="{{ route('note.destroy', $note->id) }}" method="POST" style="display:inline;"
                                onsubmit="return confirmDelete(event)">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">🗑 Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <p>Aucune note trouvée pour les critères sélectionnés.</p>
    @endif
</div>

<!-- CSS spécifique pour l'impression -->
<style>
    @media print {
        .no-print {
            display: none;
            /* Masque tout ce qui n'est pas le tableau et infos */
        }

        .printable {
            display: block;
            /* Affiche uniquement la partie imprimable */
        }
    }
</style>
<script>
    function confirmDelete(e) {
        if (!confirm('❗️Voulez-vous vraiment supprimer cette note ?')) {
            e.preventDefault();
            return false;
        }
        return true;
    }
</script>


@endsection