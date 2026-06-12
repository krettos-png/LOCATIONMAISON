<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maison;
use App\Models\Photo;
use App\Models\Categorie;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;





class MaisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
{
    $maisons = Maison::all(); // ou Maison::with('photos')->get();







    

    

    // Récupère la liste des quartiers uniques
    $quartiers = Maison::distinct()->pluck('adresse');
    $villes = Maison::distinct()->pluck('ville');
    $categories = Maison::distinct()->pluck('categorie_id');
    $categoriess = categorie::all();
    
    return view('welcome', compact('maisons', 'quartiers', 'villes', 'categories', 'categoriess')); // transmet la variable à la vue
}


// public function byCategory($id)
// {
//     // On récupère uniquement les maisons dont la catégorie correspond à l'ID
//     $maisons = Maison::where('categorie_id', $id)->get();

//     // On garde les listes pour les menus de recherche si besoin
//     $quartiers = Maison::distinct()->pluck('adresse');
//     $villes = Maison::distinct()->pluck('ville');
//     $categories = Maison::distinct()->pluck('categorie_id');
//     $categoriess = categorie::all();

//     // On retourne la même vue 'welcome' mais avec les données filtrées
//     return view('cat-maison', compact('maisons', 'quartiers', 'villes', 'categories', 'categoriess'));
// }






public function byCategory($id)
{
    // On récupère les maisons de la catégorie ET qui ne sont PAS louées
    //$maisons = Maison::all()
    $maisons = Maison::where('categorie_id', $id)
                    // ->where('est_loue', true)
                     ->get();
;
                     $maisonsss = Maison::where('categorie_id', $id)
                     ->where('est_loue', false)
                     ->get()
                     ->groupBy('ville');

    // Le reste de ton code ne change pas
    $quartiers = Maison::distinct()->pluck('adresse');
    $villes = Maison::distinct()->pluck('ville');
    $categories = Maison::distinct()->pluck('categorie_id');
    $categoriess = categorie::all();

    $Rcategory = Categorie::find($id);

    return view('cat-maison', compact('Rcategory', 'maisons', 'maisonsss', 'quartiers', 'villes', 'categories', 'categoriess'));
}







// public function byCategory($id)
// {
//     // 1. On récupère les maisons disponibles de cette catégorie
//     $maisons = Maison::where('categorie_id', $id)
//                      ->where('est_loue', false)
//                      ->get();

//     // 2. Initialisation dynamique de la barre de recherche dès le premier chargement :
//     // On ne prend QUE les villes et quartiers où il y a des maisons disponibles DANS CETTE CATÉGORIE
//     $villes = Maison::where('categorie_id', $id)
//                     ->where('est_loue', false)
//                     ->distinct()
//                     ->whereNotNull('ville')
//                     ->pluck('ville');

//     $quartiers = Maison::where('categorie_id', $id)
//                        ->where('est_loue', false)
//                        ->distinct()
//                        ->whereNotNull('adresse')
//                        ->pluck('adresse');

//     // Pour que le premier menu affiche toutes les catégories possibles
//     $categoriess = Categorie::all(); 

//     // On passe l'ID de la catégorie actuelle à la vue pour le JavaScript
//     $current_category_id = $id;

//     return view('cat-maison', compact('maisons', 'quartiers', 'villes', 'categoriess', 'current_category_id'));
// }



public function search(Request $request)
{
    // 1. On commence par exclure d'office les maisons louées
    $query = Maison::where('est_loue', false);

    // 2. Filtre par Ville si sélectionnée
    if ($request->filled('ville')) {
        $query->where('ville', $request->ville);
    }

    // 3. Filtre par Quartier (adresse) si sélectionné
    if ($request->filled('quartier')) {
        $query->where('adresse', $request->quartier);
    }

    // 4. Filtre par Catégorie si sélectionnée
    if ($request->filled('categorie_id')) {
        $query->where('categorie_id', $request->categorie_id);
    }

    // 5. On récupère les résultats filtrés
    $maisons = $query->get();

    // 6. On recharge les données pour alimenter les sélecteurs
    $quartiers = Maison::where('est_loue', false)->distinct()->pluck('adresse');
    $villes = Maison::where('est_loue', false)->distinct()->pluck('ville');
    $categoriess = Categorie::all(); 

    // CHANGER ICI : On récupère l'ID de la catégorie recherchée pour la renvoyer à la vue
    $current_category_id = $request->categorie_id;

    // On ajoute 'current_category_id' dans le compact()
    return view('cat-maison', compact('maisons', 'quartiers', 'villes', 'categoriess', 'current_category_id'));
}







public function home2()
{
    $maisons = Maison::all(); // ou Maison::with('photos')->get();
    // Récupère la liste des quartiers uniques
    $quartiers = Maison::distinct()->pluck('adresse');
    $villes = Maison::distinct()->pluck('ville');
    $categories = Maison::distinct()->pluck('categorie_id');
    $categoriess = categorie::all();
    


    
    
    return view('Maison', compact('maisons', 'quartiers', 'villes', 'categories', 'categoriess')); // transmet la variable à la vue
}





public function index2($id){
     $maisons = Maison::with(['photos'])->findOrFail($id);
        return view('Maison-info', compact('maisons'));
}



public function indexModifier()


{
    $utilisateur = Auth::user(); // Récupère l'utilisateur connecté


    $maisons = $utilisateur->maisons; // Toutes ses maisons

    return view('/admin.modifier', compact('maisons')); // transmet la variable à la vue

    
}




public function indextable()


{
    $utilisateur = Auth::user(); // Récupère l'utilisateur connecté


    $maisons = $utilisateur->maisons; // Toutes ses maisons

    return view('/admin.table', compact('maisons')); // transmet la variable à la vue

    
}


public function indextableD($id)


{
    $utilisateur = Utilisateur::findOrFail($id); // Récupère l'utilisateur connecté


    $maisons = $utilisateur->maisons; // Toutes ses maisons

    return view('/admin.table', compact('maisons')); // transmet la variable à la vue

    
}



public function toggleLoue($id)
{
    // 1. On cherche la maison, sinon erreur 404 propre
    $maison = Maison::findOrFail($id);
    
    // 2. On inverse l'état (si true devient false, si false devient true)
    $maison->est_loue = !$maison->est_loue; 
    $maison->save();

    // 3. On recharge la page avec le nouveau statut visuel
    return back();
}





public function indexModifierR()


{
    $utilisateur = Auth::user(); // Récupère l'utilisateur connecté


    $maisons = $utilisateur->maisons; // Toutes ses maisons

    return view('/admin.pagemodification', compact('maisons')); // transmet la variable à la vue

    
}



public function indexadmininfo($id){
     $maisons = Maison::with(['photos'])->findOrFail($id);

    

    // 2. Astuce pour éviter qu'un rafraîchissement (F5) en boucle fausse les stats
    //$sessionKey = 'viewed_maison_' . $id;
    // if (!session()->has($sessionKey)) {
        
    //     session()->put($sessionKey, true); // Marque le visiteur comme "ayant déjà vu"
    // }

        $maisons->increment('vues'); // Ajoute +1 en base de données
        return view('admin/infomaison', compact('maisons'));
}



public function demanderVisite($id)
{
    // 1. On trouve la maison
    $maison = Maison::findOrFail($id);

    // 2. On incrémente le compteur de visites demandées
    $maison->increment('visites_demandees');

    // 3. On prépare exactement le même lien WhatsApp que tu avais sur ta page
    $texteBrut = "Bonjour, je suis très intéressé par l'annonce suivante :\n\n"
               . "🏠 *Bien :* " . $maison->titre . "\n"
               . "💰 *Loyer :* " . number_format($maison->prix, 0, ',', ' ') . " FCFA / mois\n"
               . "📍 *Zone :* " . $maison->ville . " (" . $maison->adresse . ")\n"
               . "📸 *Image :* " . asset('storage/' . $maison->image);

    $lienWhatsApp = "https://wa.me/22891304000?text=" . urlencode($texteBrut);

   // $lienWhatsApp = "https://wa.me/228" . $maison->telephone . "?text=" . urlencode($texteBrut);


    // 4. On redirige instantanément l'utilisateur vers WhatsApp
    return redirect()->away($lienWhatsApp);
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
//     public function store(Request $request)
// {
//     $request->validate([
//         'categorie_id' => 'required|exists:categories,id',
//         'titre' => 'required',
//         'description' => 'required',
//         'prix' => 'required|numeric|max:999999999', // Attention : 'max' en minuscules
//         'ville' => 'required',
//         'adresse' => 'required',
//         'image' => 'nullable|image|max:2048',
//         'latitude' => 'required|numeric|between:-90,90',
//         'longitude' => 'required|numeric|between:-180,180',
//         'images_secondaires.*' => 'nullable|image|max:2048'
//     ]);

//     $utilisateur = Auth::user();

//     // Enregistrer la maison
//     $maison = new Maison();
//     $maison->utilisateur_id = $utilisateur->id;
//     $maison->categorie_id = $request->categorie_id;
//     $maison->titre = $request->titre;
//     $maison->description = $request->description;
//     $maison->prix = $request->prix;
//     $maison->ville = $request->ville;
//     $maison->adresse = $request->adresse;
//     $maison->latitude = $request->latitude;
//     $maison->longitude = $request->longitude;

//     // Gestion de l'image principale directement dans le dossier public
//     if ($request->hasFile('image')) {
//         $file = $request->file('image');
//         $filename = time() . '_' . $file->getClientOriginalName();
//         // Déplace le fichier vers public/maisons/principales/
//         $file->move(public_path('maisons/principales'), $filename);
//         // On stocke le chemin relatif en base de données pour garder vos affichages intacts
//         $maison->image = 'maisons/principales/' . $filename;
//     }

//     $maison->save();

//     // Gestion des photos secondaires directement dans le dossier public
//     if ($request->hasFile('images_secondaires')) {
//         foreach ($request->file('images_secondaires') as $photo) {
//             $filenameSecondaire = time() . '_' . $photo->getClientOriginalName();
//             // Déplace le fichier vers public/maisons/secondaires/
//             $photo->move(public_path('maisons/secondaires'), $filenameSecondaire);
            
//             $chemin = 'maisons/secondaires/' . $filenameSecondaire;
//             $maison->photos()->create(['chemin' => $chemin]);
//         }
//     }

//     // Note : Les variables générées ici n'étaient pas utilisées à cause de la redirection
//     // $maisons = Maison::all(); 
//     // $quartiers = Maison::distinct()->pluck('adresse');
//     // $villes = Maison::distinct()->pluck('ville');
//     // $categories = Maison::distinct()->pluck('categorie_id');

//     return redirect('/admin/table');
// }




public function store(Request $request)
{
    // 1. Validation de toutes les entrées (Champs obligatoires + Cautions optionnelles)
    $request->validate([
        'categorie_id'        => 'nullable|exists:categories,id', // Devient nullable d'après ta structure
        'titre'               => 'required|string|max:255',
        'description'         => 'required|string|max:255',
        'prix'                => 'required|numeric|max:999999999',
        'ville'               => 'nullable|string|max:255',       // Nullable d'après ta structure
        'adresse'             => 'required|string|max:255',
        'image'               => 'nullable|image|max:2048',
        'latitude'            => 'nullable|numeric|between:-90,90',  // Nullable d'après ta structure
        'longitude'           => 'nullable|numeric|between:-180,180', // Nullable d'après ta structure
        'images_secondaires.*'=> 'nullable|image|max:2048',
        
        // Validation des nouveaux champs financiers (optionnels)
        'caution_mois'        => 'nullable|integer|min:0',
        'prepaiement_mois'    => 'nullable|integer|min:0',
        'frais_visite'        => 'nullable|integer|min:0',
        'commission'          => 'nullable|integer|min:0',
        'caution_elec'        => 'nullable|integer|min:0',
        'caution_eau'         => 'nullable|integer|min:0',
        'caution_elec_eau'    => 'nullable|integer|min:0',
    ]);

    $utilisateur = Auth::user();

    // 2. Initialisation du modèle
    $maison = new Maison();
    $maison->utilisateur_id = $utilisateur->id;
    $maison->categorie_id   = $request->categorie_id;
    $maison->titre          = $request->titre;
    $maison->description    = $request->description;
    $maison->prix           = $request->prix;
    $maison->ville          = $request->ville;
    $maison->adresse        = $request->adresse;
    $maison->latitude       = $request->latitude;
    $maison->longitude      = $request->longitude;

    // 3. Gestion automatique des cases à cocher (booléens / tinyint)
    // En HTML, si une checkbox n'est pas cochée, elle n'est pas envoyée dans $request.
    // On force la valeur à 1 si cochée, sinon 0.
    $maison->immeuble_etage      = $request->has('immeuble_etage') ? 1 : 0;
    $maison->meuble              = $request->has('meuble') ? 1 : 0;
    $maison->climatise           = $request->has('climatise') ? 1 : 0;
    $maison->sanitaire           = $request->has('sanitaire') ? 1 : 0;
    $maison->adapte_pmr          = $request->has('adapte_pmr') ? 1 : 0;
    $maison->compteur_elec_perso = $request->has('compteur_elec_perso') ? 1 : 0;
    $maison->compteur_eau_perso  = $request->has('compteur_eau_perso') ? 1 : 0;

    // Valeurs par défaut pour une nouvelle insertion
    $maison->est_loue          = 0;
    $maison->vues              = 0;
    $maison->visites_demandees = 0;

    // 4. Assignation des cautions et frais optionnels
    $maison->caution_mois     = $request->caution_mois;
    $maison->prepaiement_mois = $request->prepaiement_mois;
    $maison->frais_visite     = $request->frais_visite;
    $maison->commission       = $request->commission;
    $maison->caution_elec     = $request->caution_elec;
    $maison->caution_eau      = $request->caution_eau;
    $maison->caution_elec_eau = $request->caution_elec_eau;

    // 5. Gestion de l'image principale (Ta méthode dans le dossier public)
    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('maisons/principales'), $filename);
        $maison->image = 'maisons/principales/' . $filename;
    }

    // Sauvegarde initiale pour générer l'ID de la maison nécessaire aux photos secondaires
    $maison->save();

    // 6. Gestion des photos secondaires (Ta méthode dans le dossier public)
    if ($request->hasFile('images_secondaires')) {
        foreach ($request->file('images_secondaires') as $photo) {
            $filenameSecondaire = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('maisons/secondaires'), $filenameSecondaire);
            
            $chemin = 'maisons/secondaires/' . $filenameSecondaire;
            $maison->photos()->create(['chemin' => $chemin]);
        }
    }

    return redirect('/admin/table')->with('success', 'La maison a été ajoutée avec succès.');
}
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    //public function update(Request $request, string $id)
    //{
        //
    //}
// public function update(Request $request, $id)
// {
//     // 1. Trouver la maison
//     $maison = Maison::findOrFail($id);

//     // 2. Validation
//     $request->validate([
//         'titre' => 'required',
//         'description' => 'required',
//         'prix' => 'required|numeric|MAX:999999999',
//         'ville' => 'required',
//         'adresse' => 'required',
//         'image' => 'nullable|image|max:2048',
//         'images_secondaires.*' => 'nullable|image|max:2048'
//     ]);

//     // 3. Préparer les données de base
//     $data = $request->only(['titre', 'description', 'prix', 'ville', 'adresse', 'latitude', 'longitude']);

//     // 4. Gestion de l'image principale (remplacement)
//     if ($request->hasFile('image')) {
//         // Optionnel : Storage::disk('public')->delete($maison->image); 
//         $data['image'] = $request->file('image')->store('maisons/principales', 'public');
//     }

//     // 5. Mise à jour des champs de la maison
//     $maison->update($data);

//     // 6. Gestion des photos secondaires (Remplacement total)
//     if ($request->hasFile('images_secondaires')) {
//         // a. Supprimer les anciennes relations en base de données
//         $maison->photos()->delete();

//         // b. Ajouter les nouvelles photos
//         foreach ($request->file('images_secondaires') as $photo) {
//             $chemin = $photo->store('maisons/secondaires', 'public');
//             $maison->photos()->create(['chemin' => $chemin]);
//         }
//     }

//     // 7. Redirection avec les données à jour
//     $maisons = Maison::all(); 
//     return redirect('/admin/table');


//     //return view('admin.maisonadmin', compact('maisons'))->with('success', 'Mise à jour réussie');


// }









public function update(Request $request, $id)
{
    // 1. Trouver la maison
    $maison = Maison::findOrFail($id);

    // 2. Validation complète (incluant les caractéristiques et conditions financières)
    $request->validate([
        'categorie_id' => 'required|exists:categories,id',
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'prix' => 'required|numeric|max:999999999',
        'ville' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'image' => 'nullable|image|max:2048',
        'images_secondaires.*' => 'nullable|image|max:2048',
        
        // Validation des nouvelles caractéristiques (booléens/switchs)
        'immeuble_etage' => 'nullable|boolean',
        'meuble' => 'nullable|boolean',
        'climatise' => 'nullable|boolean',
        'sanitaire' => 'nullable|boolean',
        'adapte_pmr' => 'nullable|boolean',
        'compteur_elec_perso' => 'nullable|boolean',
        'compteur_eau_perso' => 'nullable|boolean',

        // Validation des conditions financières (optionnels ou numériques)
        'caution_mois' => 'nullable|integer|min:0',
        'prepaiement_mois' => 'nullable|integer|min:0',
        'frais_visite' => 'nullable|numeric|min:0',
        'commission' => 'nullable|numeric|min:0',
        'caution_elec' => 'nullable|numeric|min:0',
        'caution_eau' => 'nullable|numeric|min:0',
        'caution_elec_eau' => 'nullable|numeric|min:0',
    ]);

    // 3. Mise à jour des données textuelles de base
    $maison->categorie_id = $request->categorie_id;
    $maison->titre = $request->titre;
    $maison->description = $request->description;
    $maison->prix = $request->prix;
    $maison->ville = $request->ville;
    $maison->adresse = $request->adresse;
    
    if ($request->has('latitude')) $maison->latitude = $request->latitude;
    if ($request->has('longitude')) $maison->longitude = $request->longitude;

    // 3b. Mise à jour des Caractéristiques (on force à 0 si le switch n'est pas renvoyé)
    $maison->immeuble_etage = $request->has('immeuble_etage') ? 1 : 0;
    $maison->meuble = $request->has('meuble') ? 1 : 0;
    $maison->climatise = $request->has('climatise') ? 1 : 0;
    $maison->sanitaire = $request->has('sanitaire') ? 1 : 0;
    $maison->adapte_pmr = $request->has('adapte_pmr') ? 1 : 0;
    $maison->compteur_elec_perso = $request->has('compteur_elec_perso') ? 1 : 0;
    $maison->compteur_eau_perso = $request->has('compteur_eau_perso') ? 1 : 0;

    // 3c. Mise à jour des Conditions Financières
    $maison->caution_mois = $request->caution_mois;
    $maison->prepaiement_mois = $request->prepaiement_mois;
    $maison->frais_visite = $request->frais_visite;
    $maison->commission = $request->commission;
    $maison->caution_elec = $request->caution_elec;
    $maison->caution_eau = $request->caution_eau;
    $maison->caution_elec_eau = $request->caution_elec_eau;

    // 4. Gestion de l'image principale (avec suppression de l'ancienne)
    if ($request->hasFile('image')) {
        // Supprimer physiquement l'ancienne image principale si elle existe
        if ($maison->image && file_exists(public_path($maison->image))) {
            unlink(public_path($maison->image));
        }

        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('maisons/principales'), $filename);
        
        $maison->image = 'maisons/principales/' . $filename;
    }

    $maison->save();

    // 5. Gestion des photos secondaires (Ajout ou Remplacement selon ta logique actuelle)
    if ($request->hasFile('images_secondaires')) {
        
        // ÉTAPE A : Supprimer PHYSIQUEMENT les anciens fichiers du dossier public
        foreach ($maison->photos as $anciennePhoto) {
            if ($anciennePhoto->chemin && file_exists(public_path($anciennePhoto->chemin))) {
                unlink(public_path($anciennePhoto->chemin));
            }
        }

        // ÉTAPE B : Supprimer les anciennes lignes dans la base de données
        $maison->photos()->delete();

        // ÉTAPE C : Ajouter les nouvelles photos physiques et en base de données
        foreach ($request->file('images_secondaires') as $photo) {
            $filenameSecondaire = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('maisons/secondaires'), $filenameSecondaire);
            
            $chemin = 'maisons/secondaires/' . $filenameSecondaire;
            $maison->photos()->create(['chemin' => $chemin]);
        }
    }

    // 6. Redirection
    return redirect('/admin/table')->with('success', 'La maison a été modifiée avec succès.');
}




















    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{

    $photo = Photo::findOrFail($id);
    //dd($photo->chemin);


    // Vérifier que le fichier existe avant de tenter la suppression
    if (Storage::disk('public')->exists($photo->chemin)) {
        Storage::disk('public')->delete($photo->chemin);
    }

    // Supprimer l'entrée de la base de données
    $photo->delete();

    // Redirection avec un message de succès
    //return redirect()->route('hhh')->with('success', 'Photo supprimée.');
    return redirect()->back()->with('success', 'Photo supprimée.');
}



    public function recherche(Request $request)
    {
        $search = $request->input('search');

        $maisons = Maison::query()
            ->when($search, function ($query, $search) {
                $query->where('titre', 'like', "%{$search}%")
                    ->orWhere('adresse', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orwhere('prix', 'like', "%{$search}%");
            })
            ->get();

        return view('Maison', compact('maisons'));
    }



        public function rechercheA(Request $request)
    {
        $search = $request->input('search');

        $maisons = Maison::query()
            ->when($search, function ($query, $search) {
                $query->where('titre', 'like', "%{$search}%")
                    ->orWhere('adresse', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orwhere('prix', 'like', "%{$search}%");
            })
            ->get();


        

        return view('admin.Maisonadmin', compact('maisons'));
    }









}
