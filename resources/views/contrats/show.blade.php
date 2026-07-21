<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrat de Bail #{{ $contrat->id }}</title>
    <!-- Inclusion de Bootstrap pour un design moderne -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

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

        /* ---------------------------------------------------- */
        /* STYLES RESPONSIVE SPECIFIQUES MOBILES (ÉCRANS < 768px) */
        /* ---------------------------------------------------- */
        @media (max-width: 767.98px) {
            body {
                font-size: 14px;
            }
            .container {
                padding-left: 10px;
                padding-right: 10px;
            }
            
            /* Transformation du tableau de suivi en cartes mobiles */
            .table-mobile-responsive thead {
                display: none; /* Cacher les en-têtes du tableau classique */
            }
            .table-mobile-responsive tbody tr {
                display: flex;
                flex-direction: column;
                background-color: #ffffff;
                border: 1px solid #e2e8f0 !important;
                border-radius: 8px;
                padding: 12px;
                margin-bottom: 12px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            }
            .table-mobile-responsive tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none !important;
                padding: 5px 0 !important;
                text-align: right;
            }
            .table-mobile-responsive tbody td::before {
                content: attr(data-label);
                font-weight: 600;
                font-size: 0.85rem;
                color: #64748b;
                text-align: left;
                padding-right: 10px;
            }
            .table-mobile-responsive tbody td.text-center {
                text-align: right !important;
            }
            .table-mobile-responsive tbody td form,
            .table-mobile-responsive tbody td a,
            .table-mobile-responsive tbody td button {
                width: 100%;
            }
        }

        /* ---------------------------------------------------- */
        /* RÈGLES STRICTES D'IMPRESSION A4 COMPACTE             */
        /* ---------------------------------------------------- */
        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            #printable-contract-wrapper, .collapse {
                display: block !important;
                visibility: visible !important;
                height: auto !important;
            }

            .contract-locked, .d-print-none {
                display: none !important;
            }

            body { 
                background: #ffffff !important; 
                color: #000000 !important; 
                font-size: 11px !important;
            }

            .card { 
                border: none !important; 
                box-shadow: none !important; 
                padding: 0 !important; 
                margin: 0 !important;
            }

            h4 { font-size: 16px !important; }
            h6 { font-size: 12px !important; }

            .table-sm th, .table-sm td {
                padding: 2px 5px !important;
                font-size: 10px !important;
            }

            #printable-contract {
                margin-top: 0 !important;
                padding-top: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-light">

@php
    // La facture/contrat globale est bloquée UNIQUEMENT si une avance (type == 0) est en attente
    $aDesImpayesInitiaux = $contrat->paiements->where('type', 0)->where('statut', '!=', 'Payé')->isNotEmpty();
@endphp

<div class="container my-3 my-md-4">
    
    <!-- BARRE D'ACTIONS (Optimisée Flex-Wrap pour Mobile) -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3 d-print-none">
        <a href="{{ route('ttt') }}" class="btn btn-secondary shadow-sm w-100 w-sm-auto">
            <i class="fa-solid fa-arrow-left me-1"></i> Retour
        </a>
        
        <div class="d-flex flex-column flex-sm-row gap-2 w-100 w-sm-auto">
            <!-- Bouton Afficher / Cacher -->
            <button class="btn btn-outline-dark shadow-sm w-100 w-sm-auto" type="button" data-bs-toggle="collapse" data-bs-target="#printable-contract-wrapper">
                <i class="fa-solid fa-eye me-1"></i> Afficher / Cacher le contrat
            </button>

            @if($aDesImpayesInitiaux)
                <button class="btn btn-danger shadow-sm disabled w-100 w-sm-auto" title="Toutes les avances (type 0) doivent être réglées pour imprimer.">
                    <i class="fa-solid fa-lock me-1"></i> Contrat bloqué
                </button>
            @else
                <button onclick="window.print();" class="btn btn-primary shadow-sm w-100 w-sm-auto">
                    <i class="fa-solid fa-print me-1"></i> Imprimer le contrat
                </button>
            @endif
        </div>
    </div>

    @if($aDesImpayesInitiaux)
        <div class="alert alert-danger d-flex align-items-center shadow-sm border-0 mb-3 d-print-none py-2" role="alert">
            <i class="fa-solid fa-triangle-exclamation fs-5 me-2 me-md-3 flex-shrink-0"></i>
            <div class="small">
                <strong>Attention :</strong> Ce contrat ne peut pas être imprimé officiellement car le locataire possède encore des frais d'avance (type 0) <strong>En attente</strong> de règlement.
            </div>
        </div>
    @endif

    <!-- CONTENEUR COLLAPSIBLE POUR CACHER LA FACTURE DU CONTRAT -->
    <div class="collapse" id="printable-contract-wrapper">
        <div class="card p-3 p-md-4 shadow-sm border-0 mb-4 {{ $aDesImpayesInitiaux ? 'contract-locked' : '' }}" id="printable-contract">
            
            @if($aDesImpayesInitiaux)
                <div class="alert alert-light text-center border-dashed border-danger text-danger fw-bold py-1 mb-3 d-print-none small">
                    <i class="fa-solid fa-ban me-2"></i> DOCUMENT NON VALIDE — EN ATTENTE DE RÈGLEMENT DES AVANCES
                </div>
            @endif

            <div class="text-center mb-3">
                <h4 class="fw-bold text-uppercase mb-1 tracking-wide">Contrat de Bail d'Habitation</h4>
                <p class="text-muted small mb-0">Référence du bail : <span class="badge bg-dark">#CT-{{ $contrat->id }}</span></p>
            </div>

            <!-- Les parties contractantes (Responsive: 1 col sur mobile, 2 col sur desktop) -->
            <div class="row g-2 mb-3">
                <!-- BAILLEUR -->
                <div class="col-12 col-sm-6">
                    <h6 class="fw-bold text-primary border-bottom pb-1 mb-2">Bailleur (Propriétaire)</h6>
                    <p class="mb-0 small">
                        <strong>Nom :</strong> 
                        {{ $contrat->maison->utilisateur->prenom ?? '' }} 
                        {{ $contrat->maison->utilisateur->name ?? $contrat->maison->utilisateur->nom ?? 'Gestionnaire' }}
                    </p>
                    <p class="text-muted small mb-0"><strong>Email :</strong> {{ $contrat->maison->utilisateur->email ?? 'contact@plateforme.com' }}</p>
                </div>
                
                <!-- PRENEUR -->
                <div class="col-12 col-sm-6 text-sm-end mt-2 mt-sm-0">
                    <h6 class="fw-bold text-primary border-bottom pb-1 mb-2 text-sm-end">Preneur (Locataire)</h6>
                    <p class="mb-0 small">
                        <strong>Nom :</strong> 
                        {{ $contrat->locataire->prenom ?? '' }} 
                        {{ $contrat->locataire->name ?? $contrat->locataire->nom ?? 'Inconnu' }}
                    </p>
                    <p class="text-muted small mb-0"><strong>Email :</strong> {{ $contrat->locataire->email ?? 'Non renseigné' }}</p>
                </div>
            </div>

            <hr class="my-2">

            <!-- Conditions et description du bien -->
            <h6 class="fw-bold text-dark mb-2">1. Désignation du bien & Conditions</h6>
            <div class="bg-light p-2 rounded mb-3 small">
                <p class="mb-1">Logement sous la référence unique <strong>#{{ $contrat->maison->id }}</strong>.</p>
                <p class="mb-0"><strong>Prise d'effet :</strong> {{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }} | <strong>Loyer mensuel :</strong> <span class="text-success fw-bold">{{ number_format($contrat->maison->prix, 0, ',', ' ') }} F CFA</span></p>
            </div>

            <!-- FRAIS INITIAUX ET AVANCES (Type 0) -->
            <h6 class="fw-bold text-dark mb-2">2. Détail des Frais Initiaux et Cautions (Avance)</h6>
            <div class="table-responsive mb-3">
                <table class="table table-sm table-bordered align-middle mb-0 text-center small">
                    <thead class="table-light">
                        <tr>
                            <th class="py-1">Désignation / Période</th>
                            <th class="py-1">Montant Exigé</th>
                            <th class="py-1">État du versement</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contrat->paiements->where('type', 0) as $p)
                            <tr>
                                <td class="text-capitalize fw-semibold py-1">{{ $p->mois_concerne }}</td>
                                <td class="fw-bold py-1">{{ number_format($p->montant, 0, ',', ' ') }} F CFA</td>
                                <td class="py-1">
                                    @if($p->statut == 'Payé')
                                        <span class="text-success fw-bold">✓ Réglé</span>
                                    @else
                                        <span class="text-danger fw-bold">⚠️ En attente</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-1">Aucune avance associée.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <h6 class="fw-bold text-dark mb-1">3. Engagements</h6>
            <p class="text-muted x-small mb-3">Le présent contrat est régi par les lois en vigueur. Le locataire s'engage à s'acquitter de ses mensualités à terme échu. Le bail ne prend effet qu'après acquittement des avances.</p>

            <!-- Signatures -->
            <div class="mt-3 pt-2">
                <div class="row text-center">
                    <div class="col-6">
                        <p class="fw-bold mb-0 small">Signature du Bailleur</p>
                        <span class="text-muted x-small">(Mention "Lu et approuvé")</span>
                        <div class="mt-2 mx-auto border-bottom border-secondary border-dashed" style="width: 70%; height: 40px;"></div>
                    </div>
                    <div class="col-6">
                        <p class="fw-bold mb-0 small">Signature du Locataire</p>
                        <span class="text-muted x-small">(Mention "Lu et approuvé")</span>
                        <div class="mt-2 mx-auto border-bottom border-secondary border-dashed" style="width: 70%; height: 40px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- TABLEAU DE SUIVI DES LOYERS (Pleine fluidité mobile) -->
    <div class="card p-3 p-md-4 shadow-sm border-0 d-print-none">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold text-dark mb-0 fs-6 fs-md-5">Suivi Numérique des Échéances</h5>
            <span class="badge bg-secondary">Historique</span>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-mobile-responsive">
                <thead class="table-dark">
                    <tr>
                        <th>Période / Désignation</th>
                        <th>Type</th>
                        <th>Montant Requis</th>
                        <th>Statut</th>
                        <th>Date d'Enregistrement</th>
                        <th class="text-center">Action / Impression</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contrat->paiements as $paiement)
                    <tr>
                        <td data-label="Période" class="fw-bold text-capitalize text-primary">{{ $paiement->mois_concerne }}</td>
                        <td data-label="Type">
                            @if($paiement->type == 0)
                                <span class="badge bg-warning text-dark">Avance</span>
                            @else
                                <span class="badge bg-info text-dark">Loyer</span>
                            @endif
                        </td>
                        <td data-label="Montant" class="fw-bold">{{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</td>
                        <td data-label="Statut">
                            @if($paiement->statut == 'Payé')
                                <span class="badge bg-success px-2.5 py-1">✓ {{ $paiement->statut }}</span>
                            @else
                                <span class="badge bg-warning text-dark px-2.5 py-1">⏱️ {{ $paiement->statut }}</span>
                            @endif
                        </td>
                        <td data-label="Date">
                            <small class="text-secondary">
                                {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y H:i') : 'En attente' }}
                            </small>
                        </td>
                        <td data-label="Action" class="text-center">
                            @if($paiement->type == 1)
                                @if($paiement->statut == 'Payé')
                                    <a class="btn btn-sm btn-outline-primary shadow-sm" href="{{ route('paiement.imprimerFacture', $paiement->id) }}" target="_blank">
                                        <i class="fa-solid fa-print me-1"></i> Imprimer
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-outline-secondary disabled">
                                        <i class="fa-solid fa-print me-1"></i> Imprimer (Attente)
                                    </button>
                                @endif
                            @else
                                <span class="text-muted small d-none d-md-inline">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">Aucun paiement programmé pour ce contrat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function imprimerFactureMois(paiementId) {
        window.open('/paiement/' + paiementId + '/imprimer-facture', '_blank');
    }
</script>

</body>
</html>