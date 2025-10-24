<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Eleve, Classe, Matiere, Note, AnneeScolaire, Evaluation};
use Illuminate\Http\Request;

class BulletinController extends Controller
{
    /**
     * Page de sélection du bulletin
     */
    public function select()
    {
        $classes = Classe::all();
        $eleves = Eleve::all();
        $annees = AnneeScolaire::all();
        $evaluations = Evaluation::all();

        return view('admin.bulletins.select', compact('classes', 'eleves', 'annees', 'evaluations'));
    }

    /**
     * Afficher le bulletin à l'écran pour impression
     */
    public function show(Request $request)
    {
        $classe = Classe::findOrFail($request->classe);
        $eleve = Eleve::findOrFail($request->eleve);
        $annee = AnneeScolaire::findOrFail($request->annee);
        $evaluation = Evaluation::findOrFail($request->evaluation);

        // Récupérer uniquement les matières de la classe via pivot et trier par coefficient desc
        $matieres = $classe->matieres()->orderByDesc('coefficient')->get();

        // Récupérer les notes de l'élève
        $notes = Note::where('eleve_id', $eleve->id)
            ->where('classe_id', $classe->id)
            ->where('evaluation_id', $evaluation->id)
            ->where('annee_scolaire_id', $annee->id)
            ->get()
            ->keyBy('matiere_id');

        // Calcul des moyennes et appréciations
        $totalPondere = 0;
        $sommeCoef = 0;
        $appreciationsMatiere = [];

        foreach ($matieres as $matiere) {
            $note = $notes[$matiere->id] ?? null;
            $coef = $matiere->coefficient ?? 1;
            $devoir = floatval($note->note_devoir ?? 0);
            $evalNote = floatval($note->note_evaluation ?? 0);
            $moyenneMatiere = ($devoir + 2 * $evalNote) / 3;

            $totalPondere += $moyenneMatiere * $coef;
            $sommeCoef += $coef;

            // Appréciation par matière
            if ($moyenneMatiere >= 16) $appreciationsMatiere[$matiere->id] = 'Excellent';
            elseif ($moyenneMatiere >= 14) $appreciationsMatiere[$matiere->id] = 'Très bien';
            elseif ($moyenneMatiere >= 12) $appreciationsMatiere[$matiere->id] = 'Bien';
            elseif ($moyenneMatiere >= 10) $appreciationsMatiere[$matiere->id] = 'Passable';
            else $appreciationsMatiere[$matiere->id] = 'Insuffisant';
        }

        $moyenneGenerale = $sommeCoef ? $totalPondere / $sommeCoef : 0;

        // Moyennes de tous les élèves pour le rang
        $elevesClasse = Eleve::whereHas('notes', function ($q) use ($classe, $annee, $evaluation) {
            $q->where('classe_id', $classe->id)
                ->where('annee_scolaire_id', $annee->id)
                ->where('evaluation_id', $evaluation->id);
        })->get();

        $moyennesClasse = [];
        foreach ($elevesClasse as $el) {
            $notesEl = Note::where('eleve_id', $el->id)
                ->where('classe_id', $classe->id)
                ->where('evaluation_id', $evaluation->id)
                ->where('annee_scolaire_id', $annee->id)
                ->get()
                ->keyBy('matiere_id');

            $totalEl = 0;
            $coefEl = 0;
            foreach ($matieres as $matiere) {
                $note = $notesEl[$matiere->id] ?? null;
                $coef = $matiere->coefficient ?? 1;
                $devoir = floatval($note->note_devoir ?? 0);
                $evalNote = floatval($note->note_evaluation ?? 0);
                $moy = ($devoir + 2 * $evalNote) / 3;
                $totalEl += $moy * $coef;
                $coefEl += $coef;
            }
            $moyennesClasse[$el->id] = $coefEl ? $totalEl / $coefEl : 0;
        }

        if (count($moyennesClasse) == 0) $moyennesClasse = [0];
        arsort($moyennesClasse);

        $rang = array_search($eleve->id, array_keys($moyennesClasse)) + 1;
        $moyenneMax = max($moyennesClasse);
        $moyenneMin = min($moyennesClasse);
        $effectifClasse = count($elevesClasse);

        // Appréciation générale
        $appreciation = match (true) {
            $moyenneGenerale < 10 => "Insuffisant",
            $moyenneGenerale < 12 => "Passable",
            $moyenneGenerale < 14 => "Assez bien",
            $moyenneGenerale < 16 => "Bien",
            default => "Très bien",
        };

        // Proverbes aléatoires
        $proverbes = [
            "L’éducation est l’arme la plus puissante pour changer le monde. – Nelson Mandela",
            "L’avenir appartient à ceux qui se lèvent tôt et travaillent dur.",
            "La réussite appartient à ceux qui persévèrent.",
            "Ne rêve pas ta vie, vis tes rêves.",
            "Le savoir est le seul bien qu’on ne peut pas nous enlever.",
            "Celui qui ouvre une porte d’école ferme une prison.",
            "Chaque jour est une chance de s’améliorer.",
            "Petit à petit, l’oiseau fait son nid.",
            "Il n’y a pas de raccourci vers n’importe où qui en vaille la peine.",
            "Apprends comme si tu devais vivre pour toujours.",
            "L’éducation est l’arme la plus puissante pour changer le monde. – Nelson Mandela",
            "Celui qui ouvre une porte d’école ferme une prison. – Victor Hugo",
            "Apprends comme si tu devais vivre pour toujours. – Mahatma Gandhi",
            "Le savoir est le commencement de la richesse. – Socrate",
            "L’avenir appartient à ceux qui se lèvent tôt et étudient. – Proverbe africain",
            "L’éducation est le passeport pour l’avenir, car demain appartient à ceux qui s’y préparent aujourd’hui. – Malcolm X",
            "Un enfant qui lit sera un adulte qui pense. – Proverbe chinois",
            "Ne jugez pas chaque jour à la récolte que vous faites, mais aux graines que vous semez. – Robert Louis Stevenson",
            "L’éducation est la clé qui ouvre toutes les portes. – Proverbe japonais",
            "Éduquer l’esprit sans éduquer le cœur n’est pas éducation. – Aristote",
            "Chaque jour est une nouvelle chance d’apprendre quelque chose. – Proverbe inconnu",
            "Celui qui ne lit pas n’a aucun avantage sur celui qui ne sait pas lire. – Mark Twain",
            "L’apprentissage est un trésor qui suivra son propriétaire partout. – Proverbe chinois",
            "Ne laissez jamais l’école interrompre votre éducation. – Mark Twain",
            "On ne naît pas intelligent, on le devient en apprenant. – Proverbe africain",
            "Savoir, c’est pouvoir. – Francis Bacon",
            "Le chemin de la réussite est pavé d’études et de persévérance. – Proverbe inconnu",
            "Apprendre est un trésor qui suit son maître partout. – Proverbe chinois",
            "La lecture est pour l’esprit ce que l’exercice est pour le corps. – Joseph Addison",
            "Chaque grande réussite commence par une petite leçon. – Proverbe inconnu",
            "Éduquer un enfant, c’est changer le monde. – Proverbe africain",
            "L’éducation commence à la naissance et ne finit jamais. – Proverbe indien",
            "La connaissance s’acquiert par l’étude, la sagesse par l’observation. – Proverbe chinois",
            "Le succès n’est pas la clé du bonheur. Le bonheur est la clé du succès. – Albert Schweitzer",
            "L’enseignant ouvre la porte, mais c’est l’élève qui doit entrer. – Proverbe chinois",
            "Plus on apprend, plus on réalise combien on ne sait pas. – Proverbe persan",
            "Investir dans l’éducation rapporte toujours les meilleurs intérêts. – Benjamin Franklin",
            "Celui qui veut apprendre trouvera toujours le temps. – Proverbe arabe",
            "La curiosité est le moteur de l’intelligence. – Proverbe latin",
            "L’éducation est le meilleur héritage qu’on puisse laisser à ses enfants. – Proverbe africain"
        ];
        $proverbe = $proverbes[array_rand($proverbes)];

        return view('admin.bulletins.show', compact(
            'eleve',
            'classe',
            'annee',
            'evaluation',
            'matieres',
            'notes',
            'appreciationsMatiere',
            'rang',
            'effectifClasse',
            'moyenneMax',
            'moyenneMin',
            'moyenneGenerale',
            'appreciation',
            'proverbe'
        ));
    }
    public function printAll(Request $request)
    {
        $anneeId = $request->input('annee');
        $evaluationId = $request->input('evaluation');
        $classeId = $request->input('classe');

        $annee = AnneeScolaire::find($anneeId);
        $evaluation = Evaluation::find($evaluationId);
        $classe = Classe::findOrFail($classeId);

        $eleves = $classe->eleves; // ✅ relation directe
        $matieres = $classe->matieres; // ✅ relation via pivot

        $notes = [];
        foreach ($eleves as $eleve) {
            $notesEleve = Note::where('eleve_id', $eleve->id)
                ->where('evaluation_id', $evaluationId)
                ->get()
                ->keyBy('matiere_id');
            $notes[$eleve->id] = $notesEleve;
        }

        $proverbes = [
            "Le savoir est une arme puissante.",
            "Rien n’est impossible à un cœur vaillant.",
            "L’éducation est la clé de l’avenir.",
            "Celui qui apprend grandit chaque jour."
        ];

        return view('admin.bulletins.print-all', compact(
            'annee',
            'evaluation',
            'classe',
            'eleves',
            'matieres',
            'notes',
            'proverbes'
        ));
    }

    public function printAllForm()
    {
        $classes = Classe::all();
        $annees = AnneeScolaire::all();
        $evaluations = Evaluation::all();

        return view('admin.bulletins.print-all-form', compact('classes', 'annees', 'evaluations'));
    }
    public function getElevesParClasse(Request $request)
    {
        $classeId = $request->input('classe');
        $anneeId = $request->input('annee');

        if (!$classeId || !$anneeId) {
            return response()->json([]);
        }

        // Si les élèves ont une colonne `classe_id`, on récupère simplement ceux de la classe
        $eleves = \App\Models\Eleve::where('classe_id', $classeId)
            ->orderBy('nom')
            ->get(['id', 'nom', 'prenom']);

        return response()->json($eleves);
    }
}
