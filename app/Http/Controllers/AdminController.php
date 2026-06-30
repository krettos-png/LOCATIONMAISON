<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Maison;
use App\Models\Utilisateur;
use App\Models\Categorie;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     * 
     */

    public function home()
{



    $maisons = Maison::all(); // ou Maison::with('photos')->get();
    // Récupère la liste des quartiers uniques
    $quartiers = Maison::distinct()->pluck('adresse');
    $villes = Maison::distinct()->pluck('ville');
    $categories = Maison::distinct()->pluck('categorie_id');
    $categoriess = Categorie::all();

    return view('/admin/maisonadmin', compact('maisons', 'quartiers', 'villes', 'categories', 'categoriess')); // transmet la variable à la vue
}




    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'nom' => 'required',
        //     'prenom' => 'required',
        //     'contact' => 'required',
        //     'email' => 'required|email|unique:utilisateurs,email',
        //     'password' => 'required|min:6|confirmed',
        //     'role' => 'required|in:oui,non',
        // ]);

        $validator = Validator::make($request->all(), [
            'nom' => 'required',
            'prenom' => 'required',
            'contact' => 'required',
            'email' => 'required|email|unique:utilisateurs,email',
                'password' => 'required|min:6|confirmed',
                'role' => 'required|in:oui,non',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator, 'register') // Spécifie le bag d'erreurs pour le formulaire d'inscription
                ->withInput();
        }

        $role = $request->role === 'oui' ? 'admin' : 'client'; // 👈 logique du rôle
    
        // Enregistrer l'utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->name = $request->nom;
        $utilisateur->prenom = $request->prenom;
        $utilisateur->contact = $request->contact;
        $utilisateur->email = $request->email;
        $utilisateur->password = Hash::make($request->password); // HASH DU MOT DE PASSE
        $utilisateur->role=$role;
        $utilisateur->save();

   
        return redirect("/")->with('registre_ok', true); // Redirige vers la page d'accueil avec un message de succès

    }

    /**
     * Display the specified resource.
     */
    //public function show(string $id)
    //{
        //
    //}


    public function show(string $id)
        {
            $maisons = Maison::with('photos')->findOrFail($id);
            return view('admin.pagemodification', compact('maisons'));
        }




    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $utilisateur = Utilisateur::where('email', $request->email)->first();

    //     if (!$utilisateur || !Hash::check($request->password, $utilisateur->password)) {
    //         return back()->withErrors(['email' => 'Identifiants incorrects veuillez reessayer']);
    //     }

    //     Auth::login($utilisateur);

    //     // Redirection selon le rôle
    //     // if ($utilisateur->role === 'admin') {
    //     //     return redirect()->route('jj');
    //     // } else {
    //          return redirect()->route('home');
            
    //     // }
    //     return view('login');
    // }




public function login(Request $request)
{
    // 1. Validation des entrées
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // 2. Recherche de l'utilisateur
    $utilisateur = Utilisateur::where('email', $request->email)->first();

    // 3. Vérification des identifiants
    if (!$utilisateur || !Hash::check($request->password, $utilisateur->password)) {
        return back()->withErrors([
            'email' => 'Identifiants incorrects, veuillez réessayer.',
        ])->withInput($request->only('email'));
    }

    // --- MODIFICATION ICI ---
    // 4. On récupère la valeur de la checkbox "remember"
    // has('remember') renvoie true si la case est cochée
    $remember = $request->has('remember');

    // 5. Connexion avec le paramètre "Remember Me"
    // Le deuxième argument dit à Laravel de créer le cookie longue durée
    Auth::login($utilisateur, $remember);
    // -------------------------

    // 6. Régénération de la session
    $request->session()->regenerate();

    // 7. Redirection finale
    return redirect()->intended(route('home'));
}





    public function showLoginForm()
{
    if (auth()->check()) {
        return redirect('/home');
    }

    return view('auth.login');
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(string $id)
    //{
        //
    //}



//     public function destroy($id)
// {
//     $maison = Maison::with('photos')->findOrFail($id);

//     // Supprimer les fichiers photo du disque
//     foreach ($maison->photos as $photo) {
//         if (Storage::exists($photo->chemin)) {
//             Storage::delete($photo->chemin);
//         }
//         $photo->delete(); // Supprime la ligne de la BDD
//     }

//     // Supprimer la maison
//     $maison->delete();

//     $utilisateur = Auth::user(); // Récupère l'utilisateur connecté

//     $maisons = $utilisateur->maisons; // Toutes ses maisons

//     return view('admin.table', compact('maisons')); // transmet la variable à la vue


// }



public function destroy($id)
{
    // Récupérer la maison avec ses photos secondaires
    $maison = Maison::with('photos')->findOrFail($id);

    // 1. Supprimer l'image principale du dossier public
    if ($maison->image) {
        $cheminPrincipale = public_path($maison->image);
        if (file_exists($cheminPrincipale)) {
            unlink($cheminPrincipale); // Supprime le fichier physique
        }
    }

    // 2. Supprimer les photos secondaires du dossier public et de la BDD
    foreach ($maison->photos as $photo) {
        $cheminSecondaire = public_path($photo->chemin);
        if (file_exists($cheminSecondaire)) {
            unlink($cheminSecondaire); // Supprime le fichier physique
        }
        $photo->delete(); // Supprime la ligne dans la table 'photos'
    }

    // 3. Supprimer la maison de la BDD
    $maison->delete();

    // 4. Redirection vers la table admin (ce qui actualise proprement la page)
    return redirect()->to('/admin/table')->with('success', 'La maison et ses images ont été supprimées avec succès.');
}




    public function dev()
    {
        // Récupération de l'ensemble des données requises
        $utilisateurs = Utilisateur::all();
        $categories = Categorie::all();
        $maisons = Maison::all();
        $totalUtilisateurs = $utilisateurs->count();
        $totalCategories = $categories->count();
        $totalMaisons = $maisons->count();
        $totalMaisonsLouees = Maison::where('est_loue', true)->count();
        $totalMaisonsDisponibles = Maison::where('est_loue', false)
                                        ->where('statut_moderation', 'publiee')
                                        ->count();
        $totalUtilisateursadmin = Utilisateur::where('role', 'admin')->count();
        $totalUtilisateursclient = Utilisateur::where('role', 'client')->count();
        $totalMaisonsEnAttente = Maison::where('statut_moderation', 'en_attente')->count();

        $villes = DB::table('villes')
                    ->orderBy('region', 'asc')
                    ->orderBy('nom', 'asc')
                    ->get();


        // Retourne la vue admin avec les variables nécessaires
        return view('admin.dev', compact('utilisateurs', 'villes', 'categories', 'maisons', 'totalUtilisateurs', 'totalCategories', 'totalMaisons', 'totalMaisonsLouees', 'totalMaisonsDisponibles', 'totalUtilisateursadmin', 'totalUtilisateursclient', 'totalMaisonsEnAttente'));
    }


    public function destroyUtilisateur($id)
    {
        // 1. Trouver l'utilisateur ciblé
        $utilisateur = Utilisateur::findOrFail($id);

        // Sécurité : Éviter que l'admin connecté se supprime lui-même par accident
        if ($utilisateur->id === auth()->id()) {
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // 2. Lancer la suppression sécurisée
        DB::transaction(function () use ($utilisateur) {
            // Supprime d'abord toutes les maisons liées à cet utilisateur
            $utilisateur->maisons()->delete(); 

            // Supprime ensuite l'utilisateur lui-même
            $utilisateur->delete();
        });

        // 3. Redirection avec un message de confirmation
        return redirect('/admin/dev')->with('success', 'L’utilisateur et toutes ses annonces ont été supprimés avec succès.');
    }


    




public function valider($id)
{
    $maison = Maison::findOrFail($id);
    
    // Ton code actuel pour valider la maison, par exemple :
    $maison->statut_moderation = 'publiee'; // ou selon ta logique
    $maison->save();

    // On recalcule le nombre de maisons en attente pour mettre à jour le compteur
    $totalMaisonsEnAttente = Maison::where('statut_moderation', 'en_attente')->count();

    // C'EST ICI QUE TOUT SE JOUE : On renvoie du JSON pour le script AJAX
    return response()->json([
        'success' => true,
        'message' => "L'annonce \"" . $maison->titre . "\" a été validée avec succès !",
        'totalEnAttente' => $totalMaisonsEnAttente
    ]);
}

public function rejeter($id)
{
    $maison = Maison::findOrFail($id);
    
    // Ton code actuel pour supprimer ou rejeter la maison, par exemple :
    $maison->delete();

    // On recalcule le compteur
    $totalMaisonsEnAttente = Maison::where('statut_moderation', 'en_attente')->count();

    // On renvoie du JSON
    return response()->json([
        'success' => true,
        'message' => "L'annonce a été rejetée et supprimée avec succès.",
        'totalEnAttente' => $totalMaisonsEnAttente
    ]);
}

    



}
