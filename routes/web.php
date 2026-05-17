<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\MaisonController;
use App\http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;

//Route::get('/', function () {
   // return view('welcome');
//});

Route::get('/admin/ajouter', function () {
    return view('admin/ajouter');
});

route::get('/admin/d', function (){
    return view('admin/dashbord');
});

route::get('/login', function(){
    return view('connection/login');
});

route::get('/inscription', function(){
    return view('connection/inscription');
});

route::get('/recherche', function(){
    return view('Recherche/maisonrechercher');
});




route::get('/categories/{id}', [MaisonController::class, 'byCategory'])->name('maisons.byCategory');


route::get('/', [MaisonController::class, 'home'])->name('home');
route::get('/maison', [MaisonController::class, 'home2'])->name('home2');



Route::get('/admin/home', [AdminController::class, 'home'])->middleware(['auth', 'admin'])->name('admin.home');

Route::get('/admin/home', [AdminController::class, 'home'])->name('jj');

route::post('/ajouter', [MaisonController::class, 'store'])->name('enre');

route::get('/maison/{id}/info', [MaisonController::class, 'index2'])->middleware('auth');



route::get('/maison/{id}/infoA', [MaisonController::class, 'indexadmininfo']);

route::post('/enregistrer/store', [AdminController::class, 'store']);

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

Route::patch('/maison/{id}/toggle-loue', [MaisonController::class, 'toggleLoue']);

route::get('/admin/modifier2', [MaisonController::class, 'indexModifier'])->name('hhh');

route::get('/admin/pagemodification', [MaisonController::class, 'indexModifierR'])->name('RRR');


route::get('maison/{id}/info3', [AdminController::class, 'show'])->name('maisons.show');

route::get('maison/{id}/sup', [MaisonController::class, 'destroy']);

route::put('/admin/{id}/tt', [MaisonController::class, 'update']);

route::delete('/maisons/{id}', [AdminController::class, 'destroy'])->name('maisons.sup');

Route::get('/maisons/recherche', [MaisonController::class, 'recherche'])->name('maisons.recherche');

Route::get('/maisons/rechercheA', [MaisonController::class, 'rechercheA'])->name('maisons.rechercheA');






// Afficher le formulaire (ou la vue) pour demander la réinitialisation
Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Envoyer le mail
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/rechercher-maison', [MaisonController::class, 'search']);

Route::get('/maison/{id}/demander-visite', [MaisonController::class, 'demanderVisite'])->name('maisons.visite');