<?php

namespace App\Http\Controllers;

use App\Models\Maison;
use App\Models\Contrat;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ContratController extends Controller
{



//     public function index()
// {
//     // On récupère tous les contrats avec la maison, le locataire et l'historique des paiements
//     $contrats = Contrat::with(['maison.utilisateur', 'locataire', 'paiements'])->latest()->get();

//     // Statistiques rapides pour le tableau de bord
//     $totalContrats = $contrats->count();
//     $contratsActifs = $contrats->where('statut', 'actif')->count();
    
//     // Calcul des revenus perçus (statut 'Payé') via le modèle Paiement
//     $revenusPercus = \App\Models\Paiement::where('statut', 'Payé')->sum('montant');
//     // Calcul des impayés/en attente
//     $loyersEnAttente = \App\Models\Paiement::where('statut', 'En attente')->sum('montant');

//     return view('contrats.index', compact('contrats', 'totalContrats', 'contratsActifs', 'revenusPercus', 'loyersEnAttente'));
// }



public function index()
{
    $userId = auth()->id();

    // On récupère les contrats où l'utilisateur est soit le locataire (contrats.utilisateur_id),
    // soit le propriétaire de la maison (maisons.utilisateur_id).
    $contrats = Contrat::with(['maison.utilisateur', 'locataire', 'paiements'])
        ->where(function ($query) use ($userId) {
            $query->where('utilisateur_id', $userId)
                  ->orWhereHas('maison', function ($q) use ($userId) {
                      $q->where('utilisateur_id', $userId);
                  });
        })
        ->latest()
        ->get();

    // Statistiques filtrées sur les contrats de cet utilisateur
    $totalContrats = $contrats->count();
    $contratsActifs = $contrats->where('statut', 'actif')->count();
    
    // IDs des contrats de l'utilisateur pour calculer ses paiements
    $contratIds = $contrats->pluck('id');

    // Calculs restreints aux contrats de l'utilisateur
    $revenusPercus = \App\Models\Paiement::whereIn('contrat_id', $contratIds)
        ->where('statut', 'Payé')
        ->sum('montant');

    $loyersEnAttente = \App\Models\Paiement::whereIn('contrat_id', $contratIds)
        ->where('statut', 'En attente') // Assuming 'En attente' is the correct status for pending payments
        ->sum('montant');

    return view('contrats.index', compact('contrats', 'totalContrats', 'contratsActifs', 'revenusPercus', 'loyersEnAttente'));
}


    public function show($id)
{
    $contrat = Contrat::with(['maison.utilisateur', 'locataire', 'paiements'])->findOrFail($id);
    return view('contrats.show', compact('contrat'));
}



    public function create($maison_id)
    {
        // On récupère la maison pour afficher ses informations sur la page du contrat
        $maison = Maison::findOrFail($maison_id);

        // On renvoie la future vue qu'on va créer à l'étape 3
        return view('contrats.create', compact('maison'));
    }


//     public function rechercherParEmail(Request $request)
// {
//     $request->validate([
//         'email' => 'required|email'
//     ]);


//     //nettoyer les espaces invisibles autour de l'email
//     $email = trim($request->email);

//     // Recherche dans la table 'utilisateurs' grâce au modèle
//     $user = \App\Models\Utilisateur::where('email', $request->email)->first();

//     if ($user) {
//         // On combine le nom et le prénom récupérés de ta table
//         $nomComplet = trim($user->prenom . ' ' . $user->name);

//         return response()->json([
//             'success' => true,
//             'user_id' => $user->id,
//             'name' => $nomComplet // Envoie "Gerard TAGBA" ou "Matthieu TAGBA" au JS
//         ]);
//     }

//     return response()->json([
//         'success' => false,
//         'message' => 'Aucun utilisateur trouvé avec cette adresse e-mail.'
//     ]);
// }









public function rechercherParEmail(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    // Nettoyer les espaces invisibles autour de l'email
    $email = trim($request->email);

    // 1. VÉRIFICATION : L'email recherché est-il celui du propriétaire connecté ?
    if (Auth::check() && strtolower(Auth::user()->email) === strtolower($email)) {
        return response()->json([
            'success' => false,
            'message' => 'Vous avez saisi votre propre adresse e-mail. Vous ne pouvez pas vous sélectionner vous-même.'
        ], 422); // Code HTTP 422 (Unprocessable Entity) ou 400
    }

    // 2. Recherche dans la table 'utilisateurs' grâce au modèle
    $user = \App\Models\Utilisateur::where('email', $email)->first();

    if ($user) {
        // On combine le nom et le prénom récupérés de la table
        $nomComplet = trim($user->prenom . ' ' . $user->name);

        return response()->json([
            'success' => true,
            'user_id' => $user->id,
            'name' => $nomComplet
        ]);
    }

    return response()->json([
        'success' => false,
        'message' => 'Aucun utilisateur trouvé avec cette adresse e-mail.'
    ]);
}











public function store(Request $request)
{
    // ... (Validation de tes données existantes + ajout des validations nécessaires)

    // 1. Création du contrat
    $contrat = Contrat::create([
        'utilisateur_id' => $request->tenant_id,
        'maison_id'      => $request->maison_id,
        'date_debut'     => $request->start_date,
        'statut'         => 'actif'
    ]);

    // 2. Récupérer la maison pour extraire ses tarifs et cautions
    $maison = Maison::find($request->maison_id);
    
    if ($maison) {
        $maison->update(['est_loue' => 1]);

        $dateDepart = \Carbon\Carbon::parse($request->start_date);

        // --- A. GÉNÉRATION DU PREMIER MOIS DE LOYER ---
        Paiement::create([
            'contrat_id'    => $contrat->id,
            'montant'       => $maison->prix,
            'mois_concerne' => ucfirst($dateDepart->translatedFormat('F Y')), // Ex: "Juillet 2026"
            'statut'        => 'En attente'
        ]);

        // --- B. GÉNÉRATION DES MOIS DE CAUTION AVANCE (caution_mois) ---
        $nombreMoisCaution = (int) ($maison->caution_mois ?? 0);
        
        for ($i = 1; $i <= $nombreMoisCaution; $i++) {
            // On calcule les mois suivants couverts par la caution
            $moisCaution = $dateDepart->copy()->addMonths($i);
            
            Paiement::create([
                'contrat_id'    => $contrat->id,
                'montant'       => $maison->prix,
                'mois_concerne' => 'Caution - ' . ucfirst($moisCaution->translatedFormat('F Y')), // Ex: "Caution - Août 2026"
                'statut'        => 'En attente'
            ]);
        }

        // --- C. GÉNÉRATION DES AUTRES FRAIS UNIQUES (Eau, Électricité, Commission, Visite) ---
        
        // Caution Électricité
        if ($maison->caution_elec > 0) {
            Paiement::create([
                'contrat_id'    => $contrat->id,
                'montant'       => $maison->caution_elec,
                'mois_concerne' => 'Caution Électricité',
                'statut'        => 'En attente'
            ]);
        }

        // Caution Eau
        if ($maison->caution_eau > 0) {
            Paiement::create([
                'contrat_id'    => $contrat->id,
                'montant'       => $maison->caution_eau,
                'mois_concerne' => 'Caution Eau',
                'statut'        => 'En attente'
            ]);
        }

        // Commission Agence / Démarcheur
        if ($maison->commission > 0) {
            Paiement::create([
                'contrat_id'    => $contrat->id,
                'montant'       => $maison->commission,
                'mois_concerne' => 'Frais de Commission',
                'statut'        => 'En attente'
            ]);
        }

        // Frais de visite
        if ($maison->frais_visite > 0) {
            Paiement::create([
                'contrat_id'    => $contrat->id,
                'montant'       => $maison->frais_visite,
                'mois_concerne' => 'Frais de Visite',
                'statut'        => 'En attente'
            ]);
        }
    }

    // Redirection vers la page de gestion du contrat
    return redirect()->route('contrats.show', $contrat->id)
        ->with('success', 'Contrat généré avec le premier loyer, les cautions et les frais initiaux en attente !');
}

}