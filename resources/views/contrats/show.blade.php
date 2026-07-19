<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat de Bail #{{ $contrat->id }}</title>
    <!-- Inclusion de Bootstrap pour un design moderne et scannable -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-light">

@php
    // Vérification s'il reste des paiements initiaux en attente
    $aDesImpayesInitiaux = $contrat->paiements->where('statut', '!=', 'Payé')->isNotEmpty();
@endphp

<div class="container my-5">
    
    <!-- BARRE D'ACTIONS (Masquée à l'impression) -->
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <a href="{{ route('home') }}" class="btn btn-secondary shadow-sm">← Retour à l'accueil</a>
        
        @if($aDesImpayesInitiaux)
            <button class="btn btn-danger shadow-sm disabled" title="Tous les frais initiaux doivent être payés pour imprimer.">
                <i class="fa-solid fa-lock me-2"></i> Impression bloquée (Frais en attente)
            </button>
        @else
            <button onclick="window.print();" class="btn btn-primary shadow-sm">
                <i class="fa-solid fa-print me-2"></i> 🖨️ Imprimer le contrat
            </button>
        @endif
    </div>

    @if($aDesImpayesInitiaux)
        <div class="alert alert-danger d-flex align-items-center shadow-sm border-0 mb-4 d-print-none" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-4 me-3"></i>
            <div>
                <strong>Attention :</strong> Ce contrat ne peut pas être imprimé ni signé officiellement car le locataire possède encore des frais initiaux, cautions ou loyers <strong>En attente</strong> de règlement.
            </div>
        </div>
    @endif

    <!-- CORPS DU CONTRAT (Format Impression) -->
    <!-- Ajout de la classe conditionnelle 'is-locked' si les frais ne sont pas payés -->
    <div class="card p-5 shadow-sm border-0 mb-4 {{ $aDesImpayesInitiaux ? 'contract-locked' : '' }}" id="printable-contract">
        
        @if($aDesImpayesInitiaux)
            <!-- Filigrane visuel uniquement sur l'écran si le contrat est bloqué -->
            <div class="alert alert-light text-center border-dashed border-danger text-danger fw-bold py-2 mb-4 d-print-none">
                <i class="fa-solid fa-ban me-2"></i> DOCUMENT NON VALIDE — EN ATTENTE DE RÈGLEMENT INITIAL
            </div>
        @endif

        <div class="text-center mb-5">
            <h2 class="fw-bold text-uppercase tracking-wide">Contrat de Bail d'Habitation</h2>
            <p class="text-muted">Référence du bail : <span class="badge bg-dark">#CT-{{ $contrat->id }}</span></p>
        </div>

        <!-- Les parties contractantes -->
        <div class="row mb-4">
            <!-- BAILLEUR -->
            <div class="col-6">
                <h5 class="fw-bold text-primary border-bottom pb-2">Bailleur (Propriétaire)</h5>
                <p class="mb-1">
                    <strong>Nom :</strong> 
                    {{ $contrat->maison->utilisateur->prenom ?? '' }} 
                    {{ $contrat->maison->utilisateur->name ?? $contrat->maison->utilisateur->nom ?? 'Gestionnaire Plateforme' }}
                </p>
                <p class="text-muted small"><strong>Email :</strong> {{ $contrat->maison->utilisateur->email ?? 'contact@plateforme.com' }}</p>
            </div>
            
            <!-- PRENEUR -->
            <div class="col-6 text-end">
                <h5 class="fw-bold text-primary border-bottom pb-2 text-end">Preneur (Locataire)</h5>
                <p class="mb-1">
                    <strong>Nom :</strong> 
                    {{ $contrat->locataire->prenom ?? '' }} 
                    {{ $contrat->locataire->name ?? $contrat->locataire->nom ?? 'Inconnu' }}
                </p>
                <p class="text-muted small"><strong>Email :</strong> {{ $contrat->locataire->email ?? 'Non renseigné' }}</p>
            </div>
        </div>

        <hr class="my-4">

        <!-- Conditions et description du bien -->
        <h4 class="fw-bold text-dark mb-3">1. Désignation du bien & Conditions</h4>
        <div class="bg-light p-3 rounded mb-4">
            <p class="mb-2">Le bailleur donne en location au preneur le logement répertorié sous la référence unique <strong>#{{ $contrat->maison->id }}</strong>.</p>
            <p class="mb-2"><strong>Date de prise d'effet (début du bail) :</strong> {{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }}</p>
            <p class="mb-0"><strong>Montant du loyer mensuel :</strong> <span class="text-success fw-bold">{{ number_format($contrat->maison->prix, 0, ',', ' ') }} F CFA</span></p>
        </div>

        <!-- NOUVELLE SECTION DÉTAILLÉE : CAUTIONS & FRAIS INITIALEMENT EXIGÉS -->
        <h4 class="fw-bold text-dark mb-3">2. Détail des Frais Initiaux et Cautions</h4>
        <div class="table-responsive mb-4">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Désignation du Frais / Période</th>
                        <th>Montant Exigé</th>
                        <th>État du versement</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contrat->paiements as $p)
                        <tr>
                            <td class="text-capitalize fw-semibold">{{ $p->mois_concerne }}</td>
                            <td class="fw-bold">{{ number_format($p->montant, 0, ',', ' ') }} F CFA</td>
                            <td>
                                @if($p->statut == 'Payé')
                                    <span class="text-success fw-bold">✓ Réglé</span>
                                @else
                                    <span class="text-danger fw-bold">⚠️ En attente</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <h4 class="fw-bold text-dark mb-3">3. Engagements</h4>
        <p class="text-muted small">Le présent contrat est régi par les lois en vigueur. Le locataire s'engage à maintenir les lieux en bon état de propreté et à s'acquitter de ses mensualités à terme échu. Le bail ne prend juridiquement effet qu'après acquittement total des frais initiaux énumérés à l'article 2.</p>

        <!-- Zone de signature -->
        <div class="mt-5 pt-4">
            <div class="row text-center">
                <div class="col-6">
                    <p class="fw-bold mb-1">Signature du Bailleur</p>
                    <span class="text-muted x-small">(Précédée de la mention "Lu et approuvé")</span>
                    <div class="mt-3 mx-auto border-bottom border-secondary border-dashed" style="width: 70%; height: 80px;"></div>
                </div>
                <div class="col-6">
                    <p class="fw-bold mb-1">Signature du Locataire</p>
                    <span class="text-muted x-small">(Précédée de la mention "Lu et approuvé")</span>
                    <div class="mt-3 mx-auto border-bottom border-secondary border-dashed" style="width: 70%; height: 80px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLEAU DE SUIVI DES LOYERS DANS L'ESPACE NUMÉRIQUE (Masqué à l'impression) -->
    <div class="card p-4 shadow-sm border-0 d-print-none">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold text-dark mb-0">Suivi Numérique des Échéances & Paiements</h4>
            <span class="badge bg-secondary">Historique financier en temps réel</span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Période / Type</th>
                        <th>Montant Requis</th>
                        <th>Statut</th>
                        <th>Mode de Paiement</th>
                        <th>Date d'Enregistrement</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contrat->paiements as $paiement)
                    <tr>
                        <td class="fw-bold text-capitalize text-primary">{{ $paiement->mois_concerne }}</td>
                        <td class="fw-bold">{{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</td>
                        <td>
                            @if($paiement->statut == 'Payé')
                                <span class="badge bg-success px-3 py-2">✓ {{ $paiement->statut }}</span>
                            @else
                                <span class="badge bg-warning text-dark px-3 py-2">⏱️ {{ $paiement->statut }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="text-muted">{{ $paiement->moyen_paiement ?? '—' }}</span>
                        </td>
                        <td>
                            <small class="text-secondary">
                                {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y H:i') : 'En attente' }}
                            </small>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">Aucun paiement programmé pour ce contrat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- STYLES CSS DÉDIÉS AUX RÈGLES D'IMPRESSION ET SÉCURITÉ -->
<style>
.border-dashed {
    border-style: dashed !important;
}
.x-small {
    font-size: 0.75rem;
}
.contract-locked {
    opacity: 0.65;
    pointer-events: none;
    position: relative;
}

@media print {
    /* Sécurité stricte : si impayés, on masque complètement le corps du contrat à l'impression */
    .contract-locked {
        display: none !important;
    }
    
    body { 
        background: #ffffff !important; 
        color: #000000 !important; 
    }
    .d-print-none { 
        display: none !important; 
    }
    .card { 
        border: none !important; 
        box-shadow: none !important; 
        padding: 0 !important; 
        margin: 0 !important;
    }
    #printable-contract {
        margin-top: 0 !important;
        padding-top: 0 !important;
    }
}
</style>

</body>
</html>