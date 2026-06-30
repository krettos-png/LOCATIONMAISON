<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\MaisonController;
use App\http\Controllers\AdminController;
use App\http\Controllers\CategorieController;
use App\http\Controllers\VilleController;
use App\Http\Controllers\Auth\ForgotPasswordController;

//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/admin/ajouter', function () {
    return view('admin/ajouter');
})->name('admin.ajouter');

route::get('/admin/d', function (){
    return view('admin/dashbord');
});


route::get('/inscription', function(){
    return view('connection/inscription');
});

route::get('/recherche', function(){
    return view('Recherche/maisonrechercher');
});

route::get('/admin/modifier', function(){
    return view('admin/modifier');
});

route::get('/admin/dev', [AdminController::class, 'dev'])->name('admin.dev');




route::get('/categories/{id}', [MaisonController::class, 'byCategory'])->name('maisons.categorie');


route::get('/', [MaisonController::class, 'home'])->name('home');
route::get('/maison', [MaisonController::class, 'home2'])->name('home2');



Route::get('/admin/home', [AdminController::class, 'home'])->middleware(['auth', 'admin'])->name('admin.home');

Route::get('/admin/home', [AdminController::class, 'home'])->name('jj');

route::post('/ajouter', [MaisonController::class, 'store'])->name('enre');

route::get('/maison/{id}/info', [MaisonController::class, 'index2'])->middleware('auth');



route::get('/maison/{id}/infoA', [MaisonController::class, 'indexadmininfo'])->name('maisons.infoA');

route::post('/enregistrer/store', [AdminController::class, 'store'])->name('enre2');

Route::post('/login', [AdminController::class, 'login'])->name('login');

route::get('/espaceadmin', function(){
    return view('admin/home');
});

Route::get('/logout', function () {
    Auth::logout(); // Déconnecte l'utilisateur
    return redirect('/'); // Redirection après déconnexion
})->name('logout');




route::get('/admin/modifier', [MaisonController::class, 'indexModifier'])->name('hhh');

route::get('/admin/table', [MaisonController::class, 'indextable'])->name('ttt');

route::get('/dev/{id}', [MaisonController::class, 'indextableD'])->name('tttD');



Route::patch('/maison/{id}/toggle-loue', [MaisonController::class, 'toggleLoue'])->name('maisons.toggleLoue');

route::get('/admin/modifier2', [MaisonController::class, 'indexModifier'])->name('hhh');

route::get('/admin/pagemodification', [MaisonController::class, 'indexModifierR'])->name('RRR');


route::get('maison/{id}/info3', [AdminController::class, 'show'])->name('maisons.show');

route::get('maison/{id}/sup', [MaisonController::class, 'destroy'])->name('maisonsSecon.sup');

route::put('/admin/{id}/tt', [MaisonController::class, 'update'])->name('maisons.update');

route::delete('/maisons/{id}', [AdminController::class, 'destroy'])->name('maisons.sup');

Route::get('/maisons/recherche', [MaisonController::class, 'recherche'])->name('maisons.recherche');

Route::get('/maisons/rechercheA', [MaisonController::class, 'rechercheA'])->name('maisons.rechercheA');






// Afficher le formulaire (ou la vue) pour demander la réinitialisation
Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Envoyer le mail
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/rechercher-maison', [MaisonController::class, 'search']);

Route::get('/maison/{id}/demander-visite', [MaisonController::class, 'demanderVisite'])->name('maisons.visite');



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




// Tu peux placer ces routes dans ton groupe de middleware d'administration si tu en as un
Route::get('/admin/villes', [VilleController::class, 'index'])->name('villes.index');
Route::post('/admin/villes', [VilleController::class, 'store'])->name('villes.store');
Route::put('/admin/villes/{id}', [VilleController::class, 'update'])->name('villes.update');
Route::delete('/admin/villes/{id}', [VilleController::class, 'destroy'])->name('villes.destroy');


Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Route pour valider (PATCH est idéal pour une mise à jour partielle)
    Route::patch('/maisons/{id}/valider', [AdminController::class, 'valider'])->name('admin.maisons.valider');
    
    // Route pour rejeter (DELETE car on supprime l'annonce non conforme)
    Route::delete('/maisons/{id}/rejeter', [AdminController::class, 'rejeter'])->name('admin.maisons.rejeter');
});