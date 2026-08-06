<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maison;
use App\Models\Contrat;
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
                    ->where('statut_moderation', 'publiee')
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






public function toggleLoue(Request $request, $id)
{
    $maison = Maison::findOrFail($id);
    
    // --- SCÉNARIO : FERMETURE DU CONTRAT ET LIBÉRATION (BOUTON RENDRE DISPONIBLE) ---
    if ($maison->est_loue) {
        
        // Validation stricte du motif provenant du modal
        $request->validate([
            'motif_depart' => 'required|string'
        ]);

        // 1. Recherche du contrat actif associé
        $contratActif = \App\Models\Contrat::where('maison_id', $maison->id)
                                            ->where('statut', 'actif')
                                            ->first();

        if ($contratActif) {
            // Mettre fin au contrat proprement
            $contratActif->update([
                'statut' => 'termine',
                'motif' => $request->motif_depart,
                
                // Si tu as créé ou veux créer ces colonnes optionnelles plus tard :
                
                'date_fin'  => \Carbon\Carbon::now()
            ]);
        }

        // 2. Libérer la maison
        $maison->update(['est_loue' => 0]);

        return back()->with('success', 'Le contrat en cours a été archivé. La maison est à présent listée comme disponible.');
    }

    // --- SCÉNARIO : LE PROPRIÉTAIRE VEUT LOUER LA MAISON (Ton code switch d'origine) ---
    $source = $request->input('tenant_source', 'aucun');
    
    switch ($source) {
        case 'site':
            return redirect()->route('contrats.create', ['maison_id' => $maison->id])
                             ->with('info', 'Veuillez renseigner les éléments pour générer le contrat officiel.');

        case 'hors_site':
            $maison->update(['est_loue' => 0]);
            return back()->with('success', 'Invitation WhatsApp envoyée.');

        case 'aucun':
        default:
            $maison->update(['est_loue' => 1]);
            return back()->with('success', 'La maison a bien été marquée comme louée.');
    }
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















}
