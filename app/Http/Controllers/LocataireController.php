<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;

class LocataireController extends Controller
{
    // Afficher le tableau de bord du locataire (son contrat et ses factures)
    // public function index()
    // {
    //     // On récupère le contrat ACTIF du locataire connecté avec ses paiements et les détails de la maison
    //     $contrat = Contrat::with(['maison', 'paiements'])
    //         ->where('utilisateur_id', Auth::id())
    //         ->where('statut', 'actif')
    //         ->first();

    //     return view('locataire.dashboard', compact('contrat'));
    // }

public function index()
{
    // 1. Récupérer l'utilisateur connecté
    $locataire = Auth::user();

    // 2. Récupérer TOUS les contrats reliés à cet utilisateur avec leurs relations
    // (Pense à remplacer "Contrat" par le nom exact de ton modèle s'il est différent, ex: App\Models\Contrat)
    $contrats = \App\Models\Contrat::with(['maison', 'paiements'])
        ->where('utilisateur_id', $locataire->id)
        ->get();

    // 3. Envoyer la collection de contrats à la vue
    return view('locataire.dashboard', compact('contrats'));
}

public function monEspace()
{
    // Récupère tous les contrats du locataire avec les relations chargées
    $contrats = Auth::user()->contrats()->with(['maison', 'paiements'])->get();

    return view('locataire.espace', compact('contrats'));
}

    // Simuler ou initialiser le paiement d'une échéance
    public function payerFacture($id)
    {
        $paiement = Paiement::findOrFail($id);
        
        // Sécurité : Vérifier que ce paiement appartient bien au locataire connecté
        if ($paiement->contrat->utilisateur_id !== Auth::id()) {
            abort(403, 'Action non autorisée.');
        }

        // Ici, tu intégreras plus tard l'API Stripe ou Mobile Money (T-Money/Flooz)
        // Pour l'instant, on simule une réussite du paiement :
        $paiement->update([
            'statut' => 'Payé',
            'type' => '1', // ou 'Loyer', 'Caution', selon le contexte
            'moyen_paiement' => 'Mobile Money', // ou 'Stripe'
            'transaction_id' => 'TXN-' . strtoupper(uniqid()),
            'date_paiement' => now()
        ]);

        return back()->with('success', 'Votre loyer pour ' . $paiement->mois_concerne . ' a bien été payé !');
    }

//     public function storeAvance(Request $request, $id)
// {
//     // Valider le nombre de mois reçus du formulaire
//     $request->validate([
//         'nombre_mois' => 'required|integer|min:1|max:12',
//     ]);

//     $contrat = Contrat::with('maison', 'paiements')->findOrFail($id);
//     $loyerMensuel = $contrat->maison->prix;
//     $nombreMois = (int) $request->nombre_mois;

//     // Déterminer le point de départ des mois
//     $dernierPaiement = $contrat->paiements()->orderBy('id', 'desc')->first();

//     if ($dernierPaiement) {
//         // Si un paiement existe déjà, on se base sur la date de création de celui-ci + 1 mois
//         $dateDepart = Carbon::parse($dernierPaiement->created_at)->addMonth();
//     } else {
//         $dateDepart = Carbon::now();
//     }

//     // Créer un enregistrement de paiement pour chaque mois sélectionné
//     for ($i = 0; $i < $nombreMois; $i++) {
//         $moisFutur = $dateDepart->copy()->addMonths($i);
//         $nomMoisFormate = $moisFutur->locale('fr')->isoFormat('MMMM YYYY');

//         Paiement::create([
//             'contrat_id'         => $contrat->id,
//             'montant'            => $loyerMensuel,
//             'type' => '1', // ou 'Loyer', 'Caution', selon le contexte
//             'mois_concerne'      => ucfirst($nomMoisFormate),
//             'statut'             => 'Payé', // Devient directement payé pour ta simulation locale
//             'reference_paiement' => 'PAY-' . strtoupper(Str::random(8)),
//             'date_paiement'      => Carbon::now(),
//         ]);
//     }

//     return redirect()->back()->with('success', "Votre paiement de {$nombreMois} mois a été traité avec succès !");
// }




public function storeAvance(Request $request, $id)
{
    $request->validate([
        'nombre_mois' => 'required|integer|min:1|max:12',
    ]);

    $contrat = Contrat::with('maison', 'paiements')->findOrFail($id);
    $loyerMensuel = $contrat->maison->prix;
    $nombreMois = (int) $request->nombre_mois;

    // Récupérer le tout dernier paiement enregistré
    $dernierPaiement = $contrat->paiements()->orderBy('id', 'desc')->first();

    if ($dernierPaiement && !empty($dernierPaiement->mois_concerne)) {
        // Option A : Si tu as une colonne 'date_mois_concerne' (Recommandé)
        // $dateDepart = Carbon::parse($dernierPaiement->date_mois_concerne)->addMonth();

        // Option B : Si tu dois parser la chaîne "Août 2026"
        try {
            // On convertit la chaîne française en objet Carbon puis on ajoute 1 mois
            $dateDepart = Carbon::createFromLocaleFormat('F Y', 'fr', $dernierPaiement->mois_concerne)->addMonth();
        } catch (\Exception $e) {
            // Fallback au cas où le parsing de la chaîne échoue
            $dateDepart = Carbon::now();
        }
    } else {
        // Aucun paiement préalable : on démarre au mois en cours
        $dateDepart = Carbon::now();
    }

    // Créer un enregistrement pour chaque mois d'avance
    for ($i = 0; $i < $nombreMois; $i++) {
        $moisFutur = $dateDepart->copy()->addMonths($i);
        $nomMoisFormate = $moisFutur->locale('fr')->isoFormat('MMMM YYYY');

        Paiement::create([
            'contrat_id'         => $contrat->id,
            'montant'            => $loyerMensuel,
            'type'               => '1', 
            'mois_concerne'      => ucfirst($nomMoisFormate),
            'statut'             => 'Payé',
            'reference_paiement' => 'PAY-' . strtoupper(Str::random(8)),
            'date_paiement'      => Carbon::now(),
        ]);
    }

    return redirect()->back()->with('success', "Votre avance de {$nombreMois} mois a été enregistrée avec succès !");
}


public function payerFactureSeule($id)
{
    // 1. Trouver le paiement concerné (qu'il s'agisse d'un mois de loyer, d'une caution ou de frais)
    $paiement = Paiement::findOrFail($id);

    // 2. Vérifier s'il n'est pas déjà payé pour éviter les doublons
    if ($paiement->statut === 'Payé') {
        return redirect()->back()->with('error', 'Cette facture a déjà été réglée.');
    }

    // 3. Mettre à jour les informations de paiement
    $paiement->update([
        'statut' => 'Payé',
        //'type' => '1', // ou 'Loyer', 'Caution', selon le contexte
        'date_paiement' => Carbon::now(),
        // Si ta table n'a pas encore de référence pour cette ligne existante, on en génère une
        'reference_paiement' => $paiement->reference_paiement ?? 'PAY-' . strtoupper(Str::random(8)),
    ]);

    return redirect()->back()->with('success', "Le règlement pour \"{$paiement->mois_concerne}\" a été validé !");
}


/**
 * Règle uniquement tous les paiements de type 0 (avances/frais initiaux) non payés du contrat.
 */
public function payerToutesAvances($contrat_id)
{
    $contrat = Contrat::with('paiements')->findOrFail($contrat_id);

    // On sélectionne exclusivement les paiements de TYPE 0 qui ne sont PAS payés
    $avancesNonPayees = $contrat->paiements
        ->where('type', 0)
        ->where('statut', '!=', 'Payé');

    if ($avancesNonPayees->isEmpty()) {
        return redirect()->back()->with('info', 'Toutes vos avances sont déjà réglées.');
    }

    // Mise à jour groupée
    foreach ($avancesNonPayees as $paiement) {
        $paiement->update([
            'statut' => 'Payé',
            'date_paiement' => Carbon::now(),
            'reference_paiement' => $paiement->reference_paiement ?? 'PAY-' . strtoupper(Str::random(8)),
        ]);
    }

    return redirect()->back()->with('success', 'Toutes vos avances (frais initiaux) ont été réglées avec succès !');
}



/**
 * Affiche et imprime la facture pour un mois spécifique (Type 1)
 */
public function imprimerFactureMois($id)
{
    // On charge le paiement avec ses relations
    $paiement = Paiement::with(['contrat.locataire', 'contrat.maison.utilisateur'])->findOrFail($id);

    // Sécurité : Vérifier qu'il s'agit bien d'un loyer mensuel et qu'il est payé
    if ($paiement->statut !== 'Payé') {
        return redirect()->back()->with('error', 'Impossible d\'imprimer une facture pour un paiement non réglé.');
    }

    return view('factures.facture-mois', compact('paiement'));
}


}