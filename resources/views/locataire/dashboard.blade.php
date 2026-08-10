<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace Locataire</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-custom { border-radius: 12px; border: none; }
        .btn-pay-advance { background-color: #27ae60; color: white; border: none; font-weight: 600; }
        .btn-pay-advance:hover { background-color: #219653; color: white; }
        
        .contrat-option {
            border: 2px solid #e5e7eb;
            transition: all 0.2s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        .contrat-option:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }
        .contrat-option.active {
            border-color: #2563eb;
            background-color: #eff6ff;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
        }

        /* Options d'opérateurs Mobile Money */
        .operator-card {
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .operator-card:hover, .operator-card.selected {
            border-color: #0d6efd;
            background-color: #f0f7ff;
        }
        .operator-card input[type="radio"] {
            display: none;
        }

        /* En-tête sombre harmonisé pour les modals */
        .modal-header-dark {
            background-color: #343a40 !important;
            color: #ffffff !important;
        }
        .modal-header-dark .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        /* Animation pour la disparition fluide des alertes */
        .alert-dismissible-custom {
            transition: opacity 0.5s ease-out, transform 0.5s ease-out, margin 0.5s ease-out;
        }

        /* STYLES RESPONSIFS APPAREILS MOBILES */
        @media (max-width: 767.98px) {
            .mobile-card-row {
                background-color: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 12px 15px;
                margin-bottom: 10px;
            }
            .table-responsive table thead {
                display: none;
            }
            .table-responsive table tbody tr {
                display: flex;
                flex-direction: column;
                background: #fff;
                border: 1px solid #e2e8f0;
                border-radius: 10px;
                padding: 12px;
                margin-bottom: 12px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.02);
            }
            .table-responsive table td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none !important;
                padding: 6px 0 !important;
            }
            .table-responsive table td::before {
                content: attr(data-label);
                font-weight: 600;
                font-size: 0.85rem;
                color: #64748b;
            }
            .table-responsive table td form,
            .table-responsive table td button,
            .table-responsive table td a {
                width: 100%;
            }

            /* Adaptation mobile homogène des fenêtres modales (Plein écran fluide) */
            .modal-dialog.modal-fullscreen-md-down {
                margin: 0;
                width: 100%;
                max-width: 100%;
                height: 100%;
            }
            .modal-dialog.modal-fullscreen-md-down .modal-content {
                height: 100%;
                border-radius: 0 !important;
                border: none;
            }
            .modal-dialog.modal-fullscreen-md-down .modal-body {
                overflow-y: auto;
            }
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-3 my-md-5">
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
        <h1 class="h3 fw-bold m-0">Bonjour, {{ Auth::user()->prenom ?? Auth::user()->name }} 👋</h1>

        @auth
        @php $role = Auth::user()->role; @endphp
        @if($role === 'admin' || $role === 'dev')
            <a href="{{ route('ttt') }}" class="btn btn-outline-secondary btn-sm">
                 <i class="fa-solid fa-arrow-left me-1"></i> <span class="d-none d-sm-inline">Retour</span>
            </a>
        @else
            <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
                 <i class="fa-solid fa-arrow-left me-1"></i> <span class="d-none d-sm-inline">Retour au site</span>
            </a>
        @endif
        @endauth
    </div>

    {{-- ALERTES ET NOTIFICATIONS AUTO-DISPARAISSANTES --}}
    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 mb-4 alert-dismissible-custom">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
        </div>
    @endif
    @if(session('info'))
        <div class="alert alert-info shadow-sm border-0 mb-4 alert-dismissible-custom">
            <i class="fa-solid fa-circle-info me-2"></i>{{ session('info') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger shadow-sm border-0 mb-4 alert-dismissible-custom">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>{{ session('error') }}
        </div>
    @endif

    {{-- 1. VÉRIFICATION DU NOMBRE DE CONTRATS DISPONIBLES --}}
    @if(!isset($contrats) || $contrats->isEmpty())
        <div class="card p-4 p-md-5 text-center shadow-sm card-custom bg-white">
            <i class="fa-solid fa-triangle-exclamation text-warning fa-2x mb-3"></i>
            <h4 class="text-muted">Aucun contrat actif trouvé pour votre compte.</h4>
            <p class="text-muted small mb-0">Veuillez contacter votre propriétaire pour qu'il associe votre compte (ID: {{ Auth::user()->id }}) à votre logement.</p>
        </div>
    @else
        
        {{-- Détermination du contrat sélectionné --}}
        @php
            $contratIdSelectionne = request('contrat_id', $contrats->first()->id);
            $contratActuel = $contrats->firstWhere('id', $contratIdSelectionne) ?? $contrats->first();
            $contratEstTermine = ($contratActuel->statut === 'termine' || $contratActuel->statut === 'interrompu');

            // Extraction et calculs spécifiques aux Avances (Type 0)
            $toutesLesAvances = $contratActuel->paiements->where('type', 0);
            $avancesImpayees = $toutesLesAvances->where('statut', '!=', 'Payé');
            $aDesAvancesImpayees = $avancesImpayees->isNotEmpty();
            $totalMontantAvances = $toutesLesAvances->sum('montant');

            // Extraction et calculs spécifiques aux Mensualités (Type 1)
            $toutesLesMensualites = $contratActuel->paiements->where('type', 1)->sortByDesc('id');
            $mensualitesImpayees = $toutesLesMensualites->where('statut', '!=', 'Payé');
            $aDesMensualitesImpayees = $mensualitesImpayees->isNotEmpty();
            $totalMontantMensualites = $toutesLesMensualites->sum('montant');
        @endphp

        {{-- MULTI-CONTRATS --}}
        @if($contrats->count() > 1)
            <div class="mb-4">
                <h5 class="fw-bold text-secondary mb-3 fs-6"><i class="fa-solid fa-layer-group me-2"></i>Sélectionnez le contrat :</h5>
                <div class="row g-2 g-md-3 row-cols-1 row-cols-md-3">
                    @foreach($contrats as $c)
                        <div class="col">
                            <a href="{{ request()->fullUrlWithQuery(['contrat_id' => $c->id]) }}" 
                               class="card p-3 h-100 card-custom contrat-option {{ $c->id == $contratActuel->id ? 'active' : '' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <span class="badge {{ $c->statut == 'actif' ? 'bg-success' : 'bg-danger' }} mb-2">
                                            Contrat #{{ $c->id }} ({{ $c->statut == 'actif' ? 'Actif' : 'Terminé' }})
                                        </span>
                                        <h6 class="fw-bold mb-1 text-dark">{{ $c->maison->titre }}</h6>
                                        <small class="text-muted d-block"><i class="fa-solid fa-location-dot me-1"></i>{{ Str::limit($c->maison->adresse, 35) }}</small>
                                    </div>
                                    @if($c->id == $contratActuel->id)
                                        <i class="fa-solid fa-circle-check text-primary fs-5"></i>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- CONTENU DU CONTRAT SÉLECTIONNÉ --}}
        <div class="row">
            <!-- DOSSIER LOCATION -->
            <div class="col-md-4 mb-3 mb-md-4">
                <div class="card p-3 p-md-4 shadow-sm h-100 card-custom bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-primary m-0 fs-6"><i class="fa-solid fa-file-contract me-2"></i>Mon Logement</h5>
                        <span class="badge {{ $contratEstTermine ? 'bg-danger' : 'bg-primary' }} small">
                            {{ $contratEstTermine ? 'Clôturé' : 'Réf #' . $contratActuel->id }}
                        </span>
                    </div>
                    <hr class="mt-0">
                    <p class="mb-2"><strong>Bien :</strong> {{ $contratActuel->maison->titre }}</p>
                    <p class="mb-2"><strong>Adresse :</strong> {{ $contratActuel->maison->adresse }}</p>
                    <p class="mb-2"><strong>Loyer :</strong> <span class="text-success fw-bold">{{ number_format($contratActuel->maison->prix, 0, ',', ' ') }} F CFA / mois</span></p>
                    <p class="mb-0 text-muted small">Contrat débuté le : {{ \Carbon\Carbon::parse($contratActuel->date_debut)->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- ZONE DE PAIEMENT LIBRE OU BLOCAGE -->
            <div class="col-md-8 mb-3 mb-md-4">
                
                @if($contratEstTermine)
                    <div class="card p-3 p-md-4 shadow-sm card-custom bg-white mb-3 mb-md-4 border-start border-secondary border-4">
                        <h5 class="fw-bold text-secondary mb-2 fs-6">
                            <i class="fa-solid fa-ban me-2"></i>Contrat clos
                        </h5>
                        <p class="text-muted small mb-0">
                            Ce contrat est archivé ou expiré. Les fonctionnalités de paiements sont désactivées.
                        </p>
                    </div>
                @elseif($aDesAvancesImpayees)
                    <div class="card p-3 p-md-4 shadow-sm card-custom bg-white mb-3 mb-md-4 border-start border-warning border-4">
                        <h5 class="fw-bold text-dark mb-2 fs-6">
                            <i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>Avances et Frais Initiaux Requis
                        </h5>
                        <p class="text-muted small mb-0">
                            Veuillez régler vos avances (Type 0) pour débloquer la totalité de vos options de paiement mensuel.
                        </p>
                    </div>
                @else
                    <div class="card p-3 p-md-4 shadow-sm card-custom bg-white mb-3 mb-md-4">
                        <h5 class="fw-bold text-dark mb-2 fs-6"><i class="fa-solid fa-credit-card text-success me-2"></i>Payer mon loyer à tout moment</h5>
                        <p class="text-muted small mb-3">Sélectionnez le nombre de mois que vous souhaitez régler aujourd'hui.</p>
                        
                        <!-- FORMULAIRE : PAIEMENT PLUSIEURS MOIS -->
                        <form action="{{ route('locataire.payerAvance', $contratActuel->id) }}" method="POST" class="row g-2 g-md-3 align-items-end form-paiement-momo">
                            @csrf
                            <div class="col-12 col-sm-8">
                                <label for="nombre_mois" class="form-label small fw-bold text-muted">Période à régler</label>
                                <select class="form-select" id="nombre_mois" name="nombre_mois" data-prix="{{ $contratActuel->maison->prix }}">
                                    <option value="1" selected>1 Mois de loyer ({{ number_format($contratActuel->maison->prix, 0, ',', ' ') }} F CFA)</option>
                                    <option value="2">2 Mois de loyer ({{ number_format($contratActuel->maison->prix * 2, 0, ',', ' ') }} F CFA)</option>
                                    <option value="3">3 Mois de loyer ({{ number_format($contratActuel->maison->prix * 3, 0, ',', ' ') }} F CFA)</option>
                                    <option value="6">6 Mois de loyer ({{ number_format($contratActuel->maison->prix * 6, 0, ',', ' ') }} F CFA)</option>
                                </select>
                            </div>
                            <div class="col-12 col-sm-4">
                                <button type="submit" class="btn btn-pay-advance w-100 py-2 shadow-sm">
                                    Valider le paiement
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- HISTORIQUE DES FACTURES -->
                <div class="card p-3 p-md-4 shadow-sm card-custom bg-white">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center mb-3 gap-2">
                        <h5 class="fw-bold text-dark m-0 fs-6"><i class="fa-solid fa-history me-2"></i>Historique des paiements</h5>
                        
                        <!-- BOUTON : TOUT PAYER LES AVANCES (TYPE == 0) -->
                        @if($aDesAvancesImpayees && !$contratEstTermine)
                            <!-- FORMULAIRE : TOUT PAYER (AVANCES) -->
                            <form action="{{ route('locataire.payerToutesAvances', $contratActuel->id) }}" method="POST" class="w-100 w-sm-auto form-paiement-momo" data-montant="{{ $avancesImpayees->sum('montant') }}" data-description="Solder la totalité des avances (Type 0)">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm fw-bold py-2 px-3">
                                    <i class="fa-solid fa-check-double me-1"></i> Tout payer (Avances)
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle m-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Période / Désignation</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Action / Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                {{-- 1. LIGNE UNIQUE REGROUPANT TOUTES LES AVANCES (TYPE == 0) --}}
                                @if($toutesLesAvances->isNotEmpty())
                                <tr class="table-warning border-start border-warning border-3">
                                    <td data-label="Désignation" class="fw-bold text-dark">
                                        <i class="fa-solid fa-layer-group text-warning me-1"></i> Avances & Frais Initiaux
                                        <span class="badge bg-dark ms-1">{{ $toutesLesAvances->count() }} éléments</span>
                                    </td>
                                    <td data-label="Montant Total" class="fw-bold text-dark">
                                        {{ number_format($totalMontantAvances, 0, ',', ' ') }} F CFA
                                    </td>
                                    <td data-label="Statut">
                                        @if(!$aDesAvancesImpayees)
                                            <span class="badge bg-success px-2.5 py-1.5">
                                                <i class="fa-solid fa-check me-1"></i> Tout Payé
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2.5 py-1.5">
                                                <i class="fa-solid fa-clock me-1"></i> Incomplet ({{ $avancesImpayees->count() }} dûs)
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="Action">
                                        <button type="button" class="btn btn-outline-dark btn-sm px-3 py-1 shadow-sm w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#modalAvances">
                                            <i class="fa-solid fa-list-check me-1"></i> Voir le détail
                                        </button>
                                    </td>
                                </tr>
                                @endif

                                {{-- 2. LIGNE UNIQUE REGROUPANT TOUTES LES MENSUALITÉS (TYPE == 1) --}}
                                @if($toutesLesMensualites->isNotEmpty())
                                <tr class="table-info border-start border-primary border-3">
                                    <td data-label="Désignation" class="fw-bold text-dark">
                                        <i class="fa-solid fa-calendar-days text-primary me-1"></i> Mensualités & Loyers
                                        <span class="badge bg-primary ms-1">{{ $toutesLesMensualites->count() }} mois</span>
                                    </td>
                                    <td data-label="Montant Total" class="fw-bold text-dark">
                                        {{ number_format($totalMontantMensualites, 0, ',', ' ') }} F CFA
                                    </td>
                                    <td data-label="Statut">
                                        @if(!$aDesMensualitesImpayees)
                                            <span class="badge bg-success px-2.5 py-1.5">
                                                <i class="fa-solid fa-check me-1"></i> Tout Payé
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2.5 py-1.5">
                                                <i class="fa-solid fa-clock me-1"></i> En attente ({{ $mensualitesImpayees->count() }} dûs)
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="Action">
                                        <button type="button" class="btn btn-outline-primary btn-sm px-3 py-1 shadow-sm w-100 w-md-auto" data-bs-toggle="modal" data-bs-target="#modalMensualites">
                                            <i class="fa-solid fa-list-check me-1"></i> Voir le détail
                                        </button>
                                    </td>
                                </tr>
                                @endif

                                @if($toutesLesAvances->isEmpty() && $toutesLesMensualites->isEmpty())
                                <tr>
                                    <td colspan="4" class="text-center text-muted small py-3">Aucun paiement enregistré pour ce contrat.</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- MODAL POUR L'AFFICHAGE ET LE RÈGLEMENT DÉTAILLÉ DES AVANCES (TYPE 0) --}}
        @if($toutesLesAvances->isNotEmpty())
        <div class="modal fade" id="modalAvances" tabindex="-1" aria-labelledby="modalAvancesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
                <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                    <div class="modal-header modal-header-dark py-2">
                        <h6 class="modal-title fw-bold" id="modalAvancesLabel">
                            <i class="fa-solid fa-list-ul text-warning me-2"></i> Détail des Avances et Frais Initiaux
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0 text-start small">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th>Libellé / Frais</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($toutesLesAvances as $avance)
                                    <tr>
                                        <td class="fw-bold text-capitalize py-2">{{ $avance->mois_concerne }}</td>
                                        <td class="fw-bold py-2">{{ number_format($avance->montant, 0, ',', ' ') }} F CFA</td>
                                        <td class="py-2">
                                            @if($avance->statut == 'Payé')
                                                <span class="badge bg-success px-2 py-1"><i class="fa-solid fa-check me-1"></i> Payé</span>
                                            @else
                                                <span class="badge bg-danger px-2 py-1">⚠️ En attente</span>
                                            @endif
                                        </td>
                                        <td class="text-end py-2">
                                            @if($avance->statut != 'Payé')
                                                @if($contratEstTermine)
                                                    <span class="badge bg-secondary">Bloqué</span>
                                                @else
                                                    <!-- FORMULAIRE : PAIEMENT AVANCE INDIVIDUELLE -->
                                                    <form action="{{ route('locataire.payerSeul', $avance->id) }}" method="POST" class="d-inline form-paiement-momo" data-montant="{{ $avance->montant }}" data-description="Avance : {{ $avance->mois_concerne }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm py-0">
                                                            <i class="fa-solid fa-wallet me-1"></i> Régler
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="text-muted small">
                                                    {{ $avance->date_paiement ? \Carbon\Carbon::parse($avance->date_paiement)->format('d/m/Y') : 'Réglé' }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer py-2 bg-light d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
                        
                        @if($aDesAvancesImpayees && !$contratEstTermine)
                            <!-- FORMULAIRE : TOUT PAYER DEPUIS LA MODAL -->
                            <form action="{{ route('locataire.payerToutesAvances', $contratActuel->id) }}" method="POST" class="form-paiement-momo" data-montant="{{ $avancesImpayees->sum('montant') }}" data-description="Solder toutes les avances">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm fw-bold px-3 shadow-sm">
                                    <i class="fa-solid fa-check-double me-1"></i> Tout Payer Maintenant
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- MODAL POUR L'AFFICHAGE ET LE RÈGLEMENT DÉTAILLÉ DES MENSUALITÉS (TYPE 1) --}}
        @if($toutesLesMensualites->isNotEmpty())
        <div class="modal fade" id="modalMensualites" tabindex="-1" aria-labelledby="modalMensualitesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg modal-fullscreen-md-down">
                <div class="modal-content border-0 shadow" style="border-radius: 12px;">
                    <div class="modal-header modal-header-dark py-2">
                        <h6 class="modal-title fw-bold" id="modalMensualitesLabel">
                            <i class="fa-solid fa-list-ul text-info me-2"></i> Détail des Mensualités & Loyers
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body p-3">
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0 text-start small">
                                <thead class="table-light text-secondary">
                                    <tr>
                                        <th>Libellé / Frais</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($toutesLesMensualites as $mensualite)
                                    <tr>
                                        <td class="fw-bold text-capitalize py-2">{{ $mensualite->mois_concerne }}</td>
                                        <td class="fw-bold py-2">{{ number_format($mensualite->montant, 0, ',', ' ') }} F CFA</td>
                                        <td class="py-2">
                                            @if($mensualite->statut == 'Payé')
                                                <span class="badge bg-success px-2 py-1"><i class="fa-solid fa-check me-1"></i> Payé</span>
                                            @else
                                                <span class="badge bg-warning text-dark px-2 py-1">⏱️ En attente</span>
                                            @endif
                                        </td>
                                        <td class="text-end py-2">
                                            @if($mensualite->statut != 'Payé')
                                                @if($contratEstTermine || $aDesAvancesImpayees)
                                                    <span class="badge bg-secondary">Bloqué</span>
                                                @else
                                                    <!-- FORMULAIRE : PAIEMENT MENSUALITÉ INDIVIDUELLE -->
                                                    <form action="{{ route('locataire.payerSeul', $mensualite->id) }}" method="POST" class="d-inline form-paiement-momo" data-montant="{{ $mensualite->montant }}" data-description="Loyer : {{ $mensualite->mois_concerne }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm py-0">
                                                            <i class="fa-solid fa-wallet me-1"></i> Régler
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="text-muted small">
                                                    {{ $mensualite->date_paiement ? \Carbon\Carbon::parse($mensualite->date_paiement)->format('d/m/Y') : ($mensualite->updated_at ? \Carbon\Carbon::parse($mensualite->updated_at)->format('d/m/Y') : 'Réglé') }}
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer py-2 bg-light d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

    @endif
</div>

{{-- MODAL COMMUNE DE SIMULATION DE PAIEMENT MOBILE MONEY (Restauré à l'identique) --}}
<div class="modal fade" id="modalMobileMoney" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-primary text-white border-0" style="border-top-left-radius: 16px; border-top-right-radius: 16px;">
                <h5 class="modal-title fw-bold fs-6">
                    <i class="fa-solid fa-mobile-screen-button me-2"></i>Paiement Mobile Money (Sandbox)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" id="btnCloseMomo"></button>
            </div>
            <div class="modal-body p-4">
                
                {{-- ÉCRAN 1 : FORMULAIRE DE SAISIE --}}
                <div id="momoFormScreen">
                    <div class="alert alert-light border text-center mb-3">
                        <small class="text-muted d-block">Montant à régler</small>
                        <span class="fs-4 fw-bold text-success" id="momoAffichageMontant">0 F CFA</span>
                        <small class="text-muted d-block mt-1" id="momoAffichageDesc"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-secondary">1. Choisissez votre opérateur :</label>
                        <div class="row g-2">
                            <div class="col-6">
                                <label class="operator-card w-100 selected" onclick="selectOperator(this)">
                                    <input type="radio" name="momo_operator" value="MTN MoMo" checked>
                                    <i class="fa-solid fa-bolt text-warning me-1"></i> <strong>MTN MoMo</strong>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="operator-card w-100" onclick="selectOperator(this)">
                                    <input type="radio" name="momo_operator" value="Moov Money">
                                    <i class="fa-solid fa-signal text-primary me-1"></i> <strong>Moov Money</strong>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="operator-card w-100" onclick="selectOperator(this)">
                                    <input type="radio" name="momo_operator" value="T-Money">
                                    <i class="fa-solid fa-water text-info me-1"></i> <strong>T-Money</strong>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="operator-card w-100" onclick="selectOperator(this)">
                                    <input type="radio" name="momo_operator" value="Orange Money">
                                    <i class="fa-solid fa-phone text-warning me-1"></i> <strong>Orange Money</strong>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="momoPhone" class="form-label small fw-bold text-secondary">2. Numéro de téléphone :</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-phone"></i></span>
                            <input type="tel" id="momoPhone" class="form-control" placeholder="ex: 90 00 00 00" value="90000000" required>
                        </div>
                    </div>

                    <button type="button" class="btn btn-success w-100 py-2 fw-bold shadow-sm" id="btnConfirmerPaiementMomo">
                        <i class="fa-solid fa-lock me-2"></i>Payer Maintenant
                    </button>
                </div>

                {{-- ÉCRAN 2 : CHARGEMENT / SIMULATION PUSH USSD --}}
                <div id="momoLoadingScreen" class="text-center py-4" style="display: none;">
                    <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;" role="status">
                        <span class="visually-hidden">Traitement...</span>
                    </div>
                    <h6 class="fw-bold text-dark">Validation sur votre téléphone...</h6>
                    <p class="text-muted small mb-0">Une demande de confirmation a été envoyée au numéro <strong id="momoPhoneDisplay"></strong>.</p>
                    <p class="text-muted small">Veuillez valider le paiement avec votre code secret.</p>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- SCRIPTS BOOTSTRAP OBLIGATOIRES -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- SCRIPT PAIEMENT MOBILE MONEY SIMULÉ + AUTO-DISPARITION ALERTES -->
<script>
    let currentFormToSubmit = null;

    function selectOperator(element) {
        document.querySelectorAll('.operator-card').forEach(el => el.classList.remove('selected'));
        element.classList.add('selected');
        element.querySelector('input[type="radio"]').checked = true;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const momoModalElement = document.getElementById('modalMobileMoney');
        const momoModal = new bootstrap.Modal(momoModalElement);

        // Interception de tous les formulaires avec la classe .form-paiement-momo
        document.querySelectorAll('.form-paiement-momo').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                currentFormToSubmit = this;

                let montant = 0;
                let description = "";

                // Cas 1 : Formulaire de sélection de plusieurs mois
                const selectMois = this.querySelector('#nombre_mois');
                if (selectMois) {
                    const prixUnitaire = parseFloat(selectMois.getAttribute('data-prix')) || 0;
                    const nbrMois = parseInt(selectMois.value) || 1;
                    montant = prixUnitaire * nbrMois;
                    description = `Règlement de ${nbrMois} mois de loyer`;
                } 
                // Cas 2 : Paiement d'une seule ligne ou de la totalité des avances
                else {
                    montant = parseFloat(this.getAttribute('data-montant')) || 0;
                    description = this.getAttribute('data-description') || "Règlement de facture";
                }

                // Mise à jour des informations dans la modale
                document.getElementById('momoAffichageMontant').innerText = new Intl.NumberFormat('fr-FR').format(montant) + ' F CFA';
                document.getElementById('momoAffichageDesc').innerText = description;

                // Réinitialiser les écrans de la modale
                document.getElementById('momoFormScreen').style.display = 'block';
                document.getElementById('momoLoadingScreen').style.display = 'none';
                document.getElementById('btnCloseMomo').style.display = 'block';

                // Si l'une des modales de détails était ouverte, on la ferme d'abord
                const modalAvancesEl = document.getElementById('modalAvances');
                if (modalAvancesEl) {
                    const bsModalAvances = bootstrap.Modal.getInstance(modalAvancesEl);
                    if (bsModalAvances) bsModalAvances.hide();
                }

                const modalMensualitesEl = document.getElementById('modalMensualites');
                if (modalMensualitesEl) {
                    const bsModalMensualites = bootstrap.Modal.getInstance(modalMensualitesEl);
                    if (bsModalMensualites) bsModalMensualites.hide();
                }

                momoModal.show();
            });
        });

        // Bouton "Payer Maintenant" dans la modale
        document.getElementById('btnConfirmerPaiementMomo').addEventListener('click', function () {
            const phone = document.getElementById('momoPhone').value.trim();
            if (!phone) {
                alert('Veuillez entrer un numéro de téléphone.');
                return;
            }

            // 1. Récupération de l'opérateur coché
            const selectedOperatorRadio = document.querySelector('input[name="momo_operator"]:checked');
            const moyenPaiement = selectedOperatorRadio ? selectedOperatorRadio.value : 'Mobile Money';

            // 2. Génération d'un ID de transaction aléatoire (ex: TRX-83920147)
            const randomNum = Math.floor(10000000 + Math.random() * 90000000);
            const transactionId = 'TRX-' + randomNum;

            document.getElementById('momoPhoneDisplay').innerText = phone;
            document.getElementById('momoFormScreen').style.display = 'none';
            document.getElementById('momoLoadingScreen').style.display = 'block';
            document.getElementById('btnCloseMomo').style.display = 'none';

            // Simulation du délai d'attente réseau (3 secondes)
            setTimeout(() => {
                if (currentFormToSubmit) {
                    // Injection de 'moyen_paiement' dans le formulaire
                    let inputMoyen = currentFormToSubmit.querySelector('input[name="moyen_paiement"]');
                    if (!inputMoyen) {
                        inputMoyen = document.createElement('input');
                        inputMoyen.type = 'hidden';
                        inputMoyen.name = 'moyen_paiement';
                        currentFormToSubmit.appendChild(inputMoyen);
                    }
                    inputMoyen.value = moyenPaiement;

                    // Injection de 'transaction_id' dans le formulaire
                    let inputTxn = currentFormToSubmit.querySelector('input[name="transaction_id"]');
                    if (!inputTxn) {
                        inputTxn = document.createElement('input');
                        inputTxn.type = 'hidden';
                        inputTxn.name = 'transaction_id';
                        currentFormToSubmit.appendChild(inputTxn);
                    }
                    inputTxn.value = transactionId;

                    // Soumission réelle du formulaire Laravel d'origine
                    currentFormToSubmit.submit();
                }
            }, 3000);
        });

        // Disparition automatique des messages flash d'alerte (4s)
        const alerts = document.querySelectorAll('.alert-dismissible-custom');
        if (alerts.length > 0) {
            setTimeout(() => {
                alerts.forEach(alert => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    alert.style.marginBottom = '0';
                    alert.style.paddingTop = '0';
                    alert.style.paddingBottom = '0';

                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                });
            }, 4000);
        }
    });
</script>
</body>
</html>