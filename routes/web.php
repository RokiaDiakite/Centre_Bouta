<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Controllers généraux / Home
use App\Http\Controllers\HomeController;

// Controllers Admin
use App\Http\Controllers\Admin\{
    DashboardController,
    UserController,
    NoteController,
    EleveController,
    ClasseController,
    MatiereController,
    MaitreController,
    TuteurController,
    ProfileController,
    BulletinController,
    EvaluationController,
    InscriptionController,
    AnneeScolaireController,
    FraisScolaireController,
    DepenseController,
    EmploisDuTempsController,
    PaiementMaitreController
};

// Controllers Maitre
use App\Http\Controllers\Maitre\{
    DashboardController as ControllersMaitreDashboardController,
    EmploisDuTempsController as MaitreEmploisDuTempsController,
    MaitreDashboardController,
    PaiementMaitreController as MaitrePaiementMaitreController,
    ProfileController as MaitreProfileController,
    LoginController as MaitreLoginController
};

// Controllers Tuteur
use App\Http\Controllers\Tuteur\{
    TuteurDashboardController,
    LoginController as TuteurLoginController,
    DashboardController as ControllersTuteurDashboardController,
    EmploisDuTempsController as ControllersTuteurEmploisDuTempsController,
    FraisScolaireController as ControllersTuteurFraisScolaireController,
    ProfileController as ControllersTuteurProfileController,
    BulletinController  as ControllersTuteurBulletinController
};

// Controllers Auth
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Page d'accueil
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Utilisateurs
    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('user.index');
        Route::get('users/create', 'create')->name('user.create');
        Route::post('users/store', 'store')->name('user.store');
        Route::get('users/show/{user}', 'show')->name('user.show');
        Route::get('users/edit/{user}', 'edit')->name('user.edit');
        Route::put('users/update/{user}', 'update')->name('user.update');
        Route::delete('users/{user}', 'destroy')->name('user.destroy');
    });

    // Profils
    Route::controller(ProfileController::class)->group(function () {
        Route::get('/admin/profile', 'index')->name('admin.profile.index');

        Route::get('/admin/profile/edit', 'show')->name('admin.profile.show');

        Route::post('/admin/profile', 'update')->name('admin.profile.update');
    });


    //  Année scolaire

    Route::controller(AnneeScolaireController::class)->group(function () {

        Route::get('annees-scolaires', 'index')->name('annee.index');

        Route::get('annees-scolaires/create', 'create')->name('annee.create');

        Route::post('annees-scolaires/store', 'store')->name('annee.store');

        Route::get('annees-scolaires/{id}/edit', 'edit')->name('annee.edit');

        Route::post('annees-scolaires/update', 'update')->name('annee.update');

        Route::post('annees-scolaires/delete/{id}', 'destroy')->name('annee.delete');
    });

    //  Classes

    Route::controller(ClasseController::class)->group(function () {

        Route::get('classes', 'index')->name('classe.index');

        Route::get('classes/create', 'create')->name('classe.create');

        Route::post('classes/store', 'store')->name('classe.store');

        Route::get('classes/{id}/edit', 'edit')->name('classe.edit');

        Route::post('classes/update', 'update')->name('classe.update');

        Route::post('classes/delete/{id}', 'destroy')->name('classe.delete');
    });

    //  Matières

    Route::controller(MatiereController::class)->group(function () {

        Route::get('matieres', 'index')->name('matiere.index');

        Route::get('matieres/create', 'create')->name('matiere.create');

        Route::post('matieres/store', 'store')->name('matiere.store');

        Route::get('matieres/{id}/edit', 'edit')->name('matiere.edit');

        Route::post('matieres/update/{id}', 'update')->name('matiere.update');

        Route::post('matieres/delete/{id}', 'destroy')->name('matiere.delete');
    });

    //  Maîtres

    Route::controller(MaitreController::class)->group(function () {

        Route::get('maitres', 'index')->name('maitre.index');

        Route::get('maitres/create', 'create')->name('maitre.create');

        Route::post('maitres/store', 'store')->name('maitre.store');

        Route::get('maitres/{id}/edit', 'edit')->name('maitre.edit');

        Route::post('maitres/update', 'update')->name('maitre.update');

        Route::post('maitres/delete/{id}', 'destroy')->name('maitre.delete');
    });

    //  Tuteurs

    Route::controller(TuteurController::class)->group(function () {

        Route::get('tuteurs', 'index')->name('tuteur.index');

        Route::get('tuteurs/create', 'create')->name('tuteur.create');

        Route::post('tuteurs/store', 'store')->name('tuteur.store');

        Route::get('tuteurs/{id}/edit', 'edit')->name('tuteur.edit');

        Route::post('tuteurs/update/{id}', 'update')->name('tuteur.update');

        Route::post('tuteurs/delete/{id}', 'destroy')->name('tuteur.delete');
    });

    //  Élèves

    Route::controller(EleveController::class)->group(function () {

        Route::get('eleves', 'index')->name('eleve.index');

        Route::get('eleves/create', 'create')->name('eleve.create');

        Route::post('eleves/store', 'store')->name('eleve.store');

        Route::get('eleves/{id}/edit', 'edit')->name('eleve.edit');
        Route::post('eleves/update/{id}', 'update')->name('eleve.update');

        Route::post('eleves/delete/{id}', 'destroy')->name('eleve.delete');
    });

    //  Évaluations

    Route::controller(EvaluationController::class)->group(function () {

        Route::get('evaluations', 'index')->name('evaluation.index');

        Route::get('evaluations/create', 'create')->name('evaluation.create');

        Route::post('evaluations/store', 'store')->name('evaluation.store');

        Route::get('evaluations/{id}/edit', 'edit')->name('evaluation.edit');

        Route::post('evaluations/update', 'update')->name('evaluation.update');

        Route::post('evaluations/delete/{id}', 'destroy')->name('evaluation.delete');
    });


    // Gestion des notes
    Route::controller(NoteController::class)->group(function () {
        Route::get('/notes', [NoteController::class, 'index'])->name('note.index');
        Route::get('/notes/create', [NoteController::class, 'create'])->name('note.create');
        Route::get('/notes/create/classe', [NoteController::class, 'createClasse'])->name('note.create.classe');
        Route::post('/notes/store', [NoteController::class, 'store'])->name('note.store');
        Route::get('/notes/select/classe', [NoteController::class, 'selectClasse'])->name('note.select.classe');
        Route::get('/notes/select/eleve', [NoteController::class, 'selectEleve'])->name('note.select.eleve');
        Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('note.edit');
        Route::put('/notes/{note}', [NoteController::class, 'update'])->name('note.update');
        Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('note.destroy');
        Route::get('/notes/edit/classe', [NoteController::class, 'editClasse'])->name('note.edit.classe');
        Route::post('/notes/update/classe/{classe}/{annee}', [NoteController::class, 'updateClasse'])
            ->name('note.update.classe');
        Route::post('/admin/notes/store', [NoteController::class, 'store'])->name('note.store');
        Route::get('/admin/notes/eleves/{classe}', [NoteController::class, 'getElevesByClasse'])
            ->name('note.getEleves');
        Route::get('/notes/fiche', [NoteController::class, 'fiche'])->name('note.fiche');
        Route::get('/notes/fiche/print', [NoteController::class, 'fichePrint'])->name('note.fiche.print');
        Route::get('/notes/eleves/{classe_id}', [NoteController::class, 'getElevesByClasse'])->name('notes.getEleves');
        Route::get('/admin/notes/evaluations', [NoteController::class, 'getEvaluations']);
    });



    //  Frais scolaires

    Route::controller(FraisScolaireController::class)->group(function () {

        Route::get('frais-scolaires', 'index')->name('frais.index');

        Route::get('frais-scolaires/create', 'create')->name('frais.create');

        Route::post('frais-scolaires/store', 'store')->name('frais.store');

        Route::get('frais-scolaires/{frais}/edit', 'edit')->name('frais.edit');

        Route::put('frais-scolaires/{frais}', 'update')->name('frais.update');

        Route::get('/frais-scolaire/eleves', 'getEleves')->name('frais.eleve');

        Route::get('/frais-scolaire/get-frais/{classe_id}', 'getFraisClasse')->name('frais.getFrais');

        Route::delete('frais-scolaires/{frais}', 'destroy')->name('frais.delete');

        Route::get('frais-scolaire/statistique-eleve', 'show')->name('frais.statistique-eleve');
        Route::get('/frais-scolaire/paiements', 'getPaiements')->name('frais.paiements');
    });


    //  Paiement des maîtres

    Route::controller(PaiementMaitreController::class)->group(function () {

        Route::get('paiements-maitres', 'index')->name('paiement-maitre.index');

        Route::get('paiements-maitres/create', 'create')->name('paiement-maitre.create');

        Route::post('paiements-maitres/store', 'store')->name('paiement-maitre.store');

        Route::get('paiements-maitres/{id}/edit', 'edit')->name('paiement-maitre.edit');

        Route::post('paiements-maitres/update', 'update')->name('paiement-maitre.update');

        Route::post('paiements-maitres/delete/{id}', 'destroy')->name('paiement-maitre.delete');
    });

    // Dépenses

    Route::controller(DepenseController::class)->group(function () {

        Route::get('depenses', 'index')->name('depense.index');

        Route::get('depenses/create', 'create')->name('depense.create');

        Route::post('depenses/store', 'store')->name('depense.store');

        Route::get('depenses/{id}/edit', 'edit')->name('depense.edit');

        Route::post('depenses/update', 'update')->name('depense.update');

        Route::post('depenses/delete/{id}', 'destroy')->name('depense.delete');
    });


    // Emploi du temps
    Route::controller(EmploisDuTempsController::class)->group(function () {
        Route::get('emplois-du-temps', 'index')->name('emploi.index');
        Route::get('emplois-du-temps/create', 'create')->name('emploi.create');
        Route::post('emplois-du-temps/store', 'store')->name('emploi.store');
        Route::get('emplois-du-temps/{id}/edit', 'edit')->name('emploi.edit');
        Route::put('emplois-du-temps/update/{id}', 'update')->name('emploi.update');
        Route::post('emplois-du-temps/delete/{id}', 'destroy')->name('emploi.delete');
        Route::get('emplois-du-temps/select-classe', 'selectClasse')->name('emploi.select.classe');
        Route::get('emplois-du-temps/select-maitre', 'selectMaitre')->name('emploi.select.maitre');
        Route::get('emplois-du-temps/classe/{id}', 'showByClasse')->name('emploi.classe.show');
        Route::get('emplois-du-temps/maitre/{id}', 'showByMaitre')->name('emploi.maitre.show');
        Route::get('emplois-du-temps/classe/{id}/print', 'printClasse')->name('emploi.classe.print');
        Route::get('emplois-du-temps/maitre/{id}/print', 'printMaitre')->name('emploi.maitre.print');
    });



    // Inscriptions
    Route::controller(InscriptionController::class)->group(function () {
        Route::get('inscriptions', 'index')->name('inscription.index');
        Route::get('inscriptions/create', 'create')->name('inscription.create');
        Route::post('inscriptions/store', 'store')->name('inscription.store');
        Route::get('inscriptions/{id}/edit', 'edit')->name('inscription.edit');
        Route::post('inscriptions/update/{id}', 'update')->name('inscription.update');
        Route::post('inscriptions/delete/{id}', 'destroy')->name('inscription.delete');
    });

    // Bulletins

    Route::controller(BulletinController::class)->group(function () {
        Route::get('bulletins/select', 'select')->name('bulletin.select');
        Route::get('bulletins/show', 'show')->name('bulletin.show');

        Route::get('bulletins/pdf', 'pdf')->name('bulletin.fiche-print');
        Route::get('bulletins/print-all', 'printAll')->name('bulletin.print-all');
        Route::get('bulletins/print-all-form', 'printAllForm')->name('bulletin.print-all-form');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Maîtres
|--------------------------------------------------------------------------
*/
Route::prefix('maitre')->group(function () {
    // Non connectés
    Route::middleware(['maitre.guest'])->group(function () {
        Route::get('/login', [MaitreLoginController::class, 'index'])->name('maitre.login');
        Route::post('/login', [MaitreLoginController::class, 'login'])->name('maitre.login.submit');
    });

    // Connectés
    Route::middleware(['auth:maitre'])->group(function () {
        Route::get('/dashboard', [ControllersMaitreDashboardController::class, 'index'])->name('maitre.dashboard');
        Route::get('emploi-du-temps', [MaitreEmploisDuTempsController::class, 'index'])->name('maitre.emploi.index');
        Route::get('emploi-du-temps/{id}', [MaitreEmploisDuTempsController::class, 'show'])->name('maitre.emploi.show');
        Route::get('emploi-du-temps/print', [MaitreEmploisDuTempsController::class, 'print'])->name('maitre.emploi.print');

        Route::get('/paiement_maitres', [MaitreController::class, 'index'])->name('maitre.paiement');
        Route::post('/logout', [MaitreLoginController::class, 'logout'])->name('maitre.logout');

        Route::get('paiement_maitres', [MaitrePaiementMaitreController::class, 'index'])->name('maitre.paiement.index');
        Route::get('paiement_maitres/{id}', [MaitrePaiementMaitreController::class, 'show'])->name('maitre.paiement.show');


        Route::get('profil', [MaitreProfileController::class, 'index'])->name('maitre.profile.index');
        Route::get('profil/edit', [MaitreProfileController::class, 'edit'])->name('maitre.profile.edit');
        Route::post('profil/update', [MaitreProfileController::class, 'update'])->name('maitre.profile.update');
    });
});

/*
|--------------------------------------------------------------------------
| Routes Tuteurs
|--------------------------------------------------------------------------
*/
Route::prefix('tuteur')->group(function () {
    // Non connectés
    Route::middleware(['tuteur.guest'])->group(function () {
        Route::get('/login', [TuteurLoginController::class, 'index'])->name('tuteur.login');
        Route::post('/login', [TuteurLoginController::class, 'login'])->name('tuteur.login.submit');
    });

    // Connectés
    Route::middleware(['auth:tuteur'])->group(function () {
        Route::post('/logout', [TuteurLoginController::class, 'logout'])->name('tuteur.logout');
        Route::get('/dashboard', [ControllersTuteurDashboardController::class, 'index'])->name('tuteur.dashboard');

        Route::get('/bulletins', [ControllersTuteurBulletinController::class, 'index'])->name('tuteur.bulletin.index');
        Route::get('/bulletins/{eleve}', [ControllersTuteurBulletinController::class, 'show'])->name('tuteur.bulletin.show');
        Route::get('/bulletins/{eleve}/telecharger', [ControllersTuteurBulletinController::class, 'download'])->name('tuteur.bulletin.download');


        Route::get('/emplois', [ControllersTuteurEmploisDuTempsController::class, 'index'])->name('tuteur.emplois.index');
        Route::get('/emplois/{eleve}', [ControllersTuteurEmploisDuTempsController::class, 'show'])->name('tuteur.emplois.show');
        Route::get('/emplois/download/{eleve}', [ControllersTuteurEmploisDuTempsController::class, 'download'])->name('tuteur.emplois.download');




        Route::get('/eleves/frais', [ControllersTuteurFraisScolaireController::class, 'index'])->name('tuteur.frais_scolaire.index');
        Route::get('/eleve/{eleve}/frais', [ControllersTuteurFraisScolaireController::class, 'show'])->name('tuteur.frais_scolaire.show');

        Route::get('profil', [ControllersTuteurProfileController::class, 'index'])->name('tuteur.profile.index');
        Route::get('profil/edit', [ControllersTuteurProfileController::class, 'edit'])->name('tuteur.profile.edit');
        Route::post('profil/update', [ControllersTuteurProfileController::class, 'update'])->name('tuteur.profile.update');
    });
});

/*
|--------------------------------------------------------------------------
| Auth Laravel
|--------------------------------------------------------------------------
*/
Auth::routes();
Route::get('/home', [HomeController::class, 'index'])->name('home');
