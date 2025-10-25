@extends("layouts.admin")

@section("content")
<div class="container mt-4">
    <h3 class="mb-4">Passation des élèves vers une classe supérieure</h3>

    {{-- 🔍 Filtres --}}
    <form id="filtreForm" class="row g-3 mb-4">
        <div class="col-md-4">
            <label for="annee" class="form-label">Année scolaire</label>
            <select name="annee" id="annee" class="form-select">
                <option value="">-- Sélectionnez une année --</option>
                @foreach($annees as $annee)
                <option value="{{ $annee->id }}">{{ $annee->libelle }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="classe" class="form-label">Classe</label>
            <select name="classe" id="classe" class="form-select">
                <option value="">-- Sélectionnez une classe --</option>
                @foreach($classes as $classe)
                <option value="{{ $classe->id }}">{{ $classe->nom }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button type="button" id="btnFiltrer" class="btn btn-primary w-100">Filtrer</button>
        </div>
    </form>

    {{-- 🧾 Tableau des élèves --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="tableEleves">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom & Prénom</th>
                        <th>Matricule</th>
                        <th>Classe actuelle</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

{{-- ⚙️ Script --}}
<script>
    document.getElementById('btnFiltrer').addEventListener('click', function() {
        const annee = document.getElementById('annee').value;
        const classe = document.getElementById('classe').value;

        if (!annee || !classe) {
            alert("Veuillez sélectionner l'année scolaire et la classe.");
            return;
        }

        fetch(`/admin/passation/eleves?annee=${annee}&classe=${classe}`)
            .then(response => response.json())
            .then(data => {
                const tbody = document.querySelector('#tableEleves tbody');
                tbody.innerHTML = '';

                if (!data || data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="5" class="text-center">Aucun élève trouvé</td></tr>';
                    return;
                }

                data.forEach((eleve, index) => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${eleve.nom} ${eleve.prenom}</td>
                    <td>${eleve.matricule}</td>
                    <td>${eleve.classe_nom}</td>
                    <td>
                        <button class="btn btn-success btn-sm" onclick="fairePasser(${eleve.id})">
                            Faire passer
                        </button>
                    </td>
                `;
                    tbody.appendChild(tr);
                });
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('❌ Erreur lors du chargement. Vérifie ta console (F12).');
            });
    });

    function fairePasser(idEleve) {
        if (!confirm("Voulez-vous vraiment faire passer cet élève ?")) return;

        fetch(`/admin/passation/faire-passer/${idEleve}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                document.getElementById('btnFiltrer').click(); // rafraîchir la liste
            })
            .catch(error => console.error('Erreur:', error));
    }
</script>
@endsection