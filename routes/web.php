<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\MaisonController;
use App\http\Controllers\AdminController;
use App\http\Controllers\CategorieController;
use App\http\Controllers\VilleController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ContratController;
use App\Http\Controllers\LocataireController;

//Route::get('/', function () {
   // return view('welcome');
//});





route::get('/inscription', function(){
    return view('connection/inscription');
});

route::get('/recherche', function(){
    return view('Recherche/maisonrechercher');
});

route::get('/admin/modifier', function(){
    return view('admin/modifier');
});





Route::middleware(['auth'])->group(function () {

    // Routes réservées exclusivement aux DEV
    Route::middleware(['role:dev'])->group(function () {
        route::get('/admin/dev', [AdminController::class, 'dev'])->name('admin.dev');
        // Autres routes réservées aux DEV
        
        route::get('/dev/{id}', [MaisonController::class, 'indextableD'])->name('tttD');


        
        // Route pour afficher le formulaire
        Route::get('/admin/categories/creer', [CategorieController::class, 'create'])->name('categories.create');

        // Route pour enregistrer les données
        Route::post('/admin/categories/store', [CategorieController::class, 'store'])->name('categories.store');


        // Formulaire d'édition
        Route::get('/admin/categories/{id}/modifier', [CategorieController::class, 'edit'])->name('categories.edit');

        // Traitement de la modification (PUT)
        Route::put('/admin/categories/{id}/update', [CategorieController::class, 'update'])->name('categories.update');

        // Suppression (DELETE)
        Route::delete('/admin/categories/{id}/delete', [CategorieController::class, 'destroy'])->name('categories.destroy');


        // Route pour supprimer un utilisateur et ses biens en cascade
        Route::delete('/admin/utilisateurs/{id}/delete', [AdminController::class, 'destroyUtilisateur'])->name('utilisateurs.supprimer');



        //ROUTE POUR GERER LES VILLES (CRUD)
        // VILLES 
        Route::get('/admin/villes', [VilleController::class, 'index'])->name('villes.index');
        Route::post('/admin/villes', [VilleController::class, 'store'])->name('villes.store');
        Route::put('/admin/villes/{id}', [VilleController::class, 'update'])->name('villes.update');
        Route::delete('/admin/villes/{id}', [VilleController::class, 'destroy'])->name('villes.destroy');


        // Route pour valider LES NOUVELLES DEMANDES DE PUBLICATIONS (PATCH est idéal pour une mise à jour partielle)

        // Route pour valider (PATCH est idéal pour une mise à jour partielle)
        Route::patch('/maisons/{id}/valider', [AdminController::class, 'valider'])->name('admin.maisons.valider');
    
        // Route pour rejeter (DELETE car on supprime l'annonce non conforme)
        Route::delete('/maisons/{id}/rejeter', [AdminController::class, 'rejeter'])->name('admin.maisons.rejeter');








    });














    // Routes accessibles aux ADMIN et DEV ET CLIENT
    Route::middleware(['role:admin,dev,client'])->group(function () {
       
        
       

    Route::get('/mon-espace', [LocataireController::class, 'index'])->name('locataire.dashboard');

    //PAIEMENT
        Route::post('/paiements/{id}/payer', [LocataireController::class, 'payerFacture'])->name('locataire.payer');  
        Route::post('/locataire/contrat/{contrat_id}/payer-toutes-avances', [LocataireController::class, 'payerToutesAvances'])->name('locataire.payerToutesAvances');
        // Route pour payer une facture ou un frais individuel spécifique (loyer, caution, commission...)
        Route::post('/locataire/paiement/{id}/regler', [LocataireController::class, 'payerFactureSeule'])
    ->name('locataire.payerSeul');

    //OUVRE LA CATEGORIE DES MAISONS
    route::get('/categories/{id}', [MaisonController::class, 'byCategory'])->name('maisons.categorie');


    

        

// Route pour basculer le statut "loué" d'une maison
        Route::patch('/maison/{id}/toggle-loue', [MaisonController::class, 'toggleLoue'])->name('maisons.toggleLoue');

        //SE DECONNECTER
        Route::get('/logout', function () {
            Auth::logout(); // Déconnecte l'utilisateur
            return redirect('/'); // Redirection après déconnexion
        })->name('logout');

        
        Route::post('/locataire/contrat/{id}/payer-avance', [LocataireController::class, 'storeAvance'])
            ->name('locataire.payerAvance');





        });
















        

    // Routes accessibles aux ADMIN et DEV uniquement
    Route::middleware(['role:admin,dev'])->group(function () {
        // Route pour afficher le formulaire de création d'une maison
        route::post('/ajouter', [MaisonController::class, 'store'])->name('enre');
       

        //Route pour afficher le formulaire de modification d'une maison
        

        route::get('maison/{id}/info3', [AdminController::class, 'show'])->name('maisons.show');



        //AFFICHER TABLEAU DE BORD POUR LES PROPRIETAIRES
         route::get('/admin/table', [MaisonController::class, 'indextable'])->name('ttt');

         // Route pour afficher LA PAGE D'enregistrement d'une maison
         Route::get('/admin/ajouter', function () {
    return view('admin/ajouter');
})->name('admin.ajouter');



        // Route pour enregistrer une maison
        route::post('/enregistrer/store', [AdminController::class, 'store'])->name('enre2');

        //ROUTE POUR SUPPRIMER UNE MAISON SECONDAIRE
        
        route::get('maison/{id}/sup', [MaisonController::class, 'destroy'])->name('maisonsSecon.sup');

        //ROUTE POUR MODIFIER UNE MAISON
        
        route::put('/admin/{id}/tt', [MaisonController::class, 'update'])->name('maisons.update');

        //ROUTE POUR SUPPRIMER UNE MAISON PRINCIPALE

        
        route::delete('/maisons/{id}', [AdminController::class, 'destroy'])->name('maisons.sup');

        //GERER LES CONTRATS

        Route::get('/contrats/creer/{maison_id}', [ContratController::class, 'create'])->name('contrats.create');

        Route::get('/api/users/recherche-email', [ContratController::class, 'rechercherParEmail'])->name('users.rechercheEmail');

        Route::post('/contrats/stocker', [ContratController::class, 'store'])->name('contrats.store');

        Route::get('/contrats/{id}', [ContratController::class, 'show'])->name('contrats.show');

        Route::get('/gestion-contrats', [ContratController::class, 'index'])->name('contrats.index');



    Route::get('/paiement/{id}/imprimer-facture', [LocataireController::class, 'imprimerFactureMois'])->name('paiement.imprimerFacture');






    });

});





    route::get('/', [MaisonController::class, 'home'])->name('home');
    













route::get('/maison/{id}/infoA', [MaisonController::class, 'indexadmininfo'])->name('maisons.infoA');




//ROUTE POUR LA CONNEXION
Route::post('/login', [AdminController::class, 'login'])->name('login');
//Route::get('/login', [AdminController::class,''])->name('');
Route::get('/login', function () {
    return redirect('/')->with('open_login_modal', true);
})->name('login');




















// Afficher le formulaire (ou la vue) pour demander la réinitialisation
Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Envoyer le mail
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/rechercher-maison', [MaisonController::class, 'search']);

Route::get('/maison/{id}/demander-visite', [MaisonController::class, 'demanderVisite'])->name('maisons.visite');





















