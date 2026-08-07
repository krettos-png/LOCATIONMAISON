<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Contrat;
use App\Models\Paiement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LocataireController extends Controller
{

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




/**
     * Enregistrer et régler une avance de plusieurs mois de loyer
     */
    public function storeAvance(Request $request, $id)
    {
        // 1. Validation des champs reçus
        $request->validate([
            'nombre_mois'    => 'required|integer|min:1|max:12',
            'moyen_paiement' => 'nullable|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
        ]);

        $contrat = Contrat::with('maison', 'paiements')->findOrFail($id);
        $loyerMensuel = $contrat->maison->prix;
        $nombreMois = (int) $request->nombre_mois;

        // Récupération de l'opérateur et de l'ID de transaction (ou génération automatique)
        $moyenPaiement = $request->input('moyen_paiement') ?? 'Mobile Money';
        $transactionIdBase = $request->input('transaction_id') 
            ?? 'TRX-' . rand(10000000, 99999999);

        // Récupérer le dernier paiement enregistré pour poursuivre le calendrier
        $dernierPaiement = $contrat->paiements()->orderBy('id', 'desc')->first();

        if ($dernierPaiement && !empty($dernierPaiement->mois_concerne)) {
            try {
                // Parsing de la chaîne française (ex: "Août 2026") puis passage au mois suivant
                $dateDepart = Carbon::createFromLocaleFormat('F Y', 'fr', $dernierPaiement->mois_concerne)->addMonth();
            } catch (\Exception $e) {
                // Fallback au cas où le parsing échoue
                $dateDepart = Carbon::now();
            }
        } else {
            // Aucun paiement préalable : on démarre au mois en cours
            $dateDepart = Carbon::now();
        }

        DB::beginTransaction();
        try {
            // Créer un enregistrement réglé pour chaque mois d'avance
            for ($i = 0; $i < $nombreMois; $i++) {
                $moisFutur = $dateDepart->copy()->addMonths($i);
                $nomMoisFormate = ucfirst($moisFutur->locale('fr')->translatedFormat('F Y'));

                // Générer un TRX unique par mensualité créée
                $trxUnique = $request->has('transaction_id')
                    ? $transactionIdBase . '-' . ($i + 1)
                    : 'TRX-' . rand(10000000, 99999999);

                Paiement::create([
                    'contrat_id'         => $contrat->id,
                    'montant'            => $loyerMensuel,
                    'type'               => '1', // Type 1 pour mensualité / loyer
                    'mois_concerne'      => $nomMoisFormate,
                    'statut'             => 'Payé',
                    'moyen_paiement'     => $moyenPaiement,
                    'transaction_id'     => $trxUnique,
                    'reference_paiement' => 'PAY-' . strtoupper(Str::random(8)),
                    'date_paiement'      => Carbon::now(),
                ]);
            }

            DB::commit();

            $montantTotal = $loyerMensuel * $nombreMois;

            return redirect()->back()->with(
                'success',
                "Votre avance de {$nombreMois} mois d'un montant total de " . number_format($montantTotal, 0, ',', ' ') . " F CFA a été enregistrée avec succès via {$moyenPaiement} !"
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Une erreur est survenue lors de l'enregistrement de l'avance : " . $e->getMessage());
        }
    }









     /* * Régler une seule facture (mensualité ou avance individuelle)
     */
    public function payerFactureSeule(Request $request, $id)
    {
        // 1. Trouver le paiement concerné
        $paiement = Paiement::findOrFail($id);

        // 2. Vérifier s'il n'est pas déjà payé pour éviter les doublons
        if ($paiement->statut === 'Payé') {
            return redirect()->back()->with('error', 'Cette facture a déjà été réglée.');
        }

        // Récupération de l'opérateur envoyé par le formulaire (ex: MTN MoMo, Moov Money, T-Money, Orange Money)
        $moyenPaiement = $request->input('moyen_paiement', 'Mobile Money');
        
        // Récupération de l'ID de transaction généré par la modale, ou secours automatique
        $transactionId = $request->input('transaction_id') 
            ?? 'TRX-' . rand(10000000, 99999999);

        // 3. Mettre à jour le paiement dans la base de données
        $paiement->update([
            'statut'             => 'Payé',
            'date_paiement'      => Carbon::now(),
            'moyen_paiement'     => $moyenPaiement,
            'transaction_id'     => $transactionId,
            'reference_paiement' => $paiement->reference_paiement ?? 'PAY-' . strtoupper(Str::random(8)),
        ]);

        return redirect()->back()->with('success', "Paiement de " . number_format($paiement->montant, 0, ',', ' ') . " F CFA via {$moyenPaiement} effectué avec succès ! (Transaction : {$transactionId})");
    }










     /* * Régler l'ensemble des avances (frais initiaux - Type 0) pour un contrat donné
     */
    public function payerToutesAvances(Request $request, $contrat_id)
    {
        // 1. Valider la requête transmise par la modale
        $request->validate([
            'moyen_paiement' => 'nullable|string|max:50',
            'transaction_id' => 'nullable|string|max:100',
        ]);

        // 2. Trouver le contrat avec ses paiements
        $contrat = Contrat::with('paiements')->findOrFail($contrat_id);

        // 3. Sélectionner les avances (type 0) non payées
        $avancesNonPayees = $contrat->paiements
            ->where('type', 0)
            ->where('statut', '!=', 'Payé');

        if ($avancesNonPayees->isEmpty()) {
            return redirect()->back()->with('info', 'Toutes vos avances sont déjà réglées.');
        }

        // Récupération de l'opérateur et de l'ID de transaction (ou génération automatique)
        $moyenPaiement = $request->input('moyen_paiement') ?? 'Mobile Money';
        $transactionIdBase = $request->input('transaction_id') 
            ?? 'TRX-' . rand(10000000, 99999999);

        // Calcul du montant total réglé
        $montantTotal = $avancesNonPayees->sum('montant');

        DB::beginTransaction();
        try {
            // 4. Mise à jour de chaque avance
            foreach ($avancesNonPayees as $index => $paiement) {
                // Si plusieurs lignes sont validées d'un coup, on garantit un TRX distinct par ligne si nécessaire
                $trxUnique = $request->has('transaction_id') 
                    ? $transactionIdBase . '-' . ($index + 1)
                    : 'TRX-' . rand(10000000, 99999999);

                $paiement->update([
                    'statut'             => 'Payé',
                    'date_paiement'      => Carbon::now(),
                    'moyen_paiement'     => $moyenPaiement,
                    'transaction_id'     => $trxUnique,
                    'reference_paiement' => $paiement->reference_paiement ?? 'PAY-' . strtoupper(Str::random(8)),
                ]);
            }

            // 5. Mise à jour éventuelle du statut du contrat si toutes les avances requis sont réglées
            if ($contrat->statut === 'En attente') {
                $contrat->update(['statut' => 'Actif']);
            }

            DB::commit();

            return redirect()->back()->with(
                'success',
                "Toutes vos avances d'un montant total de " . number_format($montantTotal, 0, ',', ' ') . " F CFA ont été réglées avec succès via {$moyenPaiement} !"
            );

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', "Une erreur est survenue lors du règlement des avances : " . $e->getMessage());
        }
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