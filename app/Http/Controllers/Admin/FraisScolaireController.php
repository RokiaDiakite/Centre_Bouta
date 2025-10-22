<?php

namespace App\Http\Controllers\Admin;

use App\Models\Classe;
use App\Models\Eleve;
use App\Models\FraisScolaire;
use App\Models\AnneeScolaire;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class FraisScolaireController extends Controller
{
    public function index(Request $request)
    {
        $anneeId = $request->get('annee_scolaire_id');

        $query = FraisScolaire::with(['eleve', 'classe', 'anneeScolaire']);

        if ($anneeId) {
            $query->where('annee_scolaire_id', $anneeId);
        }

        $frais = $query->get();

        $annees = AnneeScolaire::orderBy('libelle', 'desc')->get();

        return view('admin.frais_scolaires.index', compact('frais', 'anneeId', 'annees'));
    }

    public function create()
    {
        $classes = Classe::orderBy('nom', 'asc')->get();
        $annees  = AnneeScolaire::orderBy('libelle', 'desc')->get();

        // Aucun élève ici, ils seront chargés via AJAX
        return view('admin.frais_scolaires.create', compact('classes', 'annees'));
    }

    /**
     * Retourne la liste des élèves d'une classe donnée
     */
    public function getEleves(Request $request): JsonResponse
    {
        $classe_id = $request->query('classe_id');

        if (!$classe_id) {
            return response()->json([]);
        }

        // Tous les élèves inscrits dans cette classe
        $eleves = Eleve::where('classe_id', $classe_id)
            ->orderBy('nom')
            ->get(['id', 'matricule', 'nom', 'prenom']);

        return response()->json($eleves);
    }




    /**
     * Retourne le montant du frais d’une classe
     */
    public function getFraisClasse($classe_id): JsonResponse
    {
        $classe = Classe::find($classe_id);

        return response()->json([
            'frais' => $classe ? $classe->frais : 0, // <-- si le champ s'appelle `frais`
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'eleve_id' => 'required|exists:eleves,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'montant_paye' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_de_paiement' => 'required|in:chèque,espèce,orange money,wave,moov money',
            'numero_recu' => 'required|string|max:255',
            'fichier_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'camera_image' => 'nullable|string',
        ]);

        $classe = Classe::findOrFail($request->classe_id);

        if ($request->montant_paye > $classe->frais) {
            return back()->withErrors(['montant_paye' => 'Le montant payé ne peut pas dépasser le montant total (' . $classe->frais . ' FCFA).']);
        }

        $data = $request->only([
            'classe_id',
            'eleve_id',
            'annee_scolaire_id',
            'montant_paye',
            'date_paiement',
            'mode_de_paiement',
            'numero_recu'
        ]);

        $data['montant_total'] = $classe->frais;
        $data['reliquat'] = $classe->frais - $request->montant_paye;

        // Gestion du fichier ou de la capture
        if ($request->hasFile('fichier_pdf')) {
            $data['fichier_pdf'] = $request->file('fichier_pdf')->store('frais_pdfs', 'public');
        } elseif ($request->camera_image) {
            $imageData = str_replace('data:image/png;base64,', '', $request->camera_image);
            $imageData = str_replace(' ', '+', $imageData);
            $fileName = 'frais_pdfs/' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, base64_decode($imageData));
            $data['fichier_pdf'] = $fileName;
        }

        FraisScolaire::create($data);

        return redirect()->route('frais.index')->with('success', 'Frais scolaire ajouté avec succès.');
    }

    public function edit(FraisScolaire $frais)
    {
        $classes = Classe::all();
        $eleves = Eleve::where('classe_id', $frais->classe_id)->get();
        $annees = AnneeScolaire::orderBy('libelle', 'desc')->get();

        return view('admin.frais_scolaires.edit', compact('frais', 'classes', 'eleves', 'annees'));
    }

    public function update(Request $request, FraisScolaire $frais)
    {
        $request->validate([
            'classe_id' => 'required|exists:classes,id',
            'eleve_id' => 'required|exists:eleves,id',
            'annee_scolaire_id' => 'required|exists:annee_scolaires,id',
            'montant_paye' => 'required|numeric|min:0',
            'date_paiement' => 'required|date',
            'mode_de_paiement' => 'required|in:chèque,espèce,orange money,wave,moov money',
            'numero_recu' => 'required|string|max:255',
            'fichier_pdf' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'camera_image' => 'nullable|string',
        ]);

        $classe = Classe::findOrFail($request->classe_id);

        if ($request->montant_paye > $classe->frais) {
            return back()->withErrors(['montant_paye' => 'Le montant payé ne peut pas dépasser le montant total (' . $classe->frais . ' FCFA).']);
        }

        $data = $request->only([
            'classe_id',
            'eleve_id',
            'annee_scolaire_id',
            'montant_paye',
            'date_paiement',
            'mode_de_paiement',
            'numero_recu'
        ]);

        $data['montant_total'] = $classe->frais;
        $data['reliquat'] = $classe->frais - $request->montant_paye;

        if ($request->hasFile('fichier_pdf')) {
            if ($frais->fichier_pdf) Storage::disk('public')->delete($frais->fichier_pdf);
            $data['fichier_pdf'] = $request->file('fichier_pdf')->store('frais_pdfs', 'public');
        } elseif ($request->camera_image) {
            if ($frais->fichier_pdf) Storage::disk('public')->delete($frais->fichier_pdf);
            $imageData = str_replace('data:image/png;base64,', '', $request->camera_image);
            $imageData = str_replace(' ', '+', $imageData);
            $fileName = 'frais_pdfs/' . uniqid() . '.png';
            Storage::disk('public')->put($fileName, base64_decode($imageData));
            $data['fichier_pdf'] = $fileName;
        }

        $frais->update($data);

        return redirect()->route('frais.index')->with('success', 'Frais scolaire mis à jour avec succès.');
    }

    public function destroy(FraisScolaire $frais)
    {
        if ($frais->fichier_pdf) {
            Storage::disk('public')->delete($frais->fichier_pdf);
        }
        $frais->delete();

        return redirect()->route('frais.index')->with('success', 'Frais scolaire supprimé avec succès.');
    }

    public function getPaiements(Request $request): JsonResponse
    {
        $eleve_id = $request->query('eleve_id');
        $annee_id = $request->query('annee_id');

        $paiements = FraisScolaire::where('eleve_id', $eleve_id)
            ->where('annee_scolaire_id', $annee_id)
            ->get();

        $totalPaye = $paiements->sum('montant_paye');
        $classe = Classe::find(optional($paiements->first())->classe_id);
        $totalAttendu = $classe ? $classe->frais : 1; // éviter division par 0
        $pourcentage = min(100, ($totalPaye / $totalAttendu) * 100);

        return response()->json([
            'paiements' => $paiements,
            'totalPaye' => $totalPaye,
            'totalAttendu' => $totalAttendu,
            'pourcentage' => $pourcentage,
        ]);
    }
    public function show(Request $request)
    {
        $annees = AnneeScolaire::orderBy('libelle', 'desc')->get();
        $classes = Classe::orderBy('nom', 'asc')->get();

        $anneeId = $request->get('annee_scolaire_id');
        $classeId = $request->get('classe_id');
        $eleveId = $request->get('eleve_id');

        $eleves = collect();
        $paiements = collect();

        if ($classeId) {
            $eleves = Eleve::where('classe_id', $classeId)->orderBy('nom')->get();
        }

        if ($anneeId && $classeId && $eleveId) {
            $paiements = FraisScolaire::with(['classe', 'anneeScolaire', 'eleve'])
                ->where('annee_scolaire_id', $anneeId)
                ->where('classe_id', $classeId)
                ->where('eleve_id', $eleveId)
                ->orderBy('date_paiement', 'desc')
                ->get();
        }

        return view('admin.frais_scolaires.show', compact(
            'annees',
            'classes',
            'eleves',
            'paiements',
            'anneeId',
            'classeId',
            'eleveId'
        ));
    }
}
