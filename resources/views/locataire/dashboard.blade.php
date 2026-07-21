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
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-3 my-md-5">
    <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
        <h1 class="h3 fw-bold m-0">Bonjour, {{ Auth::user()->prenom ?? Auth::user()->name }} 👋</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> <span class="d-none d-sm-inline">Retour au site</span>
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 mb-4">{{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info shadow-sm border-0 mb-4">{{ session('info') }}</div>
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

            // Filtrage des mensualités (Type 1)
            $mensualitesLoyer = $contratActuel->paiements->where('type', '!=', 0)->sortByDesc('id');
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
                        
                        <form action="{{ route('locataire.payerAvance', $contratActuel->id) }}" method="POST" class="row g-2 g-md-3 align-items-end">
                            @csrf
                            <div class="col-12 col-sm-8">
                                <label for="nombre_mois" class="form-label small fw-bold text-muted">Période à régler</label>
                                <select class="form-select" id="nombre_mois" name="nombre_mois">
                                    <option value="1" selected>1 Mois de loyer</option>
                                    <option value="2">2 Mois de loyer</option>
                                    <option value="3">3 Mois de loyer</option>
                                    <option value="6">6 Mois de loyer (1 Semestre)</option>
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
                            <form action="{{ route('locataire.payerToutesAvances', $contratActuel->id) }}" method="POST" class="w-100 w-sm-auto">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm fw-bold py-2 px-3" onclick="return confirm('Solder la totalité des avances (Type 0) ?');">
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

                                {{-- 2. LISTE DES MENSUALITÉS CLASSIQUES (TYPE 1) --}}
                                @forelse($mensualitesLoyer as $paiement)
                                <tr>
                                    <td data-label="Désignation" class="fw-bold text-capitalize text-secondary">
                                        {{ $paiement->mois_concerne }}
                                    </td>
                                    <td data-label="Montant" class="fw-bold">
                                        {{ number_format($paiement->montant, 0, ',', ' ') }} F CFA
                                    </td>
                                    <td data-label="Statut">
                                        @if($paiement->statut == 'Payé')
                                            <span class="badge bg-success px-2.5 py-1.5">
                                                <i class="fa-solid fa-check me-1"></i> Payé
                                            </span>
                                        @else
                                            <span class="badge bg-warning text-dark px-2.5 py-1.5">
                                                <i class="fa-solid fa-clock me-1"></i> En attente
                                            </span>
                                        @endif
                                    </td>
                                    <td data-label="Action / Date">
                                        @if($paiement->statut != 'Payé')
                                            @if($contratEstTermine)
                                                <button type="button" class="btn btn-secondary btn-sm px-3 py-1 shadow-sm w-100 w-md-auto" disabled>
                                                    <i class="fa-solid fa-lock me-1"></i> Bloqué
                                                </button>
                                            @else
                                                <form action="{{ route('locataire.payerSeul', $paiement->id) }}" method="POST" class="d-inline w-100">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm px-3 py-1 shadow-sm w-100 w-md-auto">
                                                        <i class="fa-solid fa-wallet me-1"></i> Régler
                                                    </button>
                                                </form>
                                            @endif
                                        @else
                                            <span class="text-muted small">
                                                {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : \Carbon\Carbon::parse($paiement->updated_at)->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                    @if($toutesLesAvances->isEmpty())
                                    <tr>
                                        <td colspan="4" class="text-center text-muted small py-3">Aucun paiement enregistré pour ce contrat.</td>
                                    </tr>
                                    @endif
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

        {{-- MODAL POUR L'AFFICHAGE ET LE RÈGLEMENT DÉTAILLÉ DES AVANCES (TYPE 0) --}}
        @if($toutesLesAvances->isNotEmpty())
        <div class="modal fade" id="modalAvances" tabindex="-1" aria-labelledby="modalAvancesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
                    <div class="modal-header bg-dark text-white">
                        <h5 class="modal-title fw-bold fs-6" id="modalAvancesLabel">
                            <i class="fa-solid fa-list-check text-warning me-2"></i>Détail des Avances et Frais Initiaux
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-3 p-md-4">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
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
                                        <td class="fw-bold text-capitalize">{{ $avance->mois_concerne }}</td>
                                        <td class="fw-bold">{{ number_format($avance->montant, 0, ',', ' ') }} F CFA</td>
                                        <td>
                                            @if($avance->statut == 'Payé')
                                                <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> Payé</span>
                                            @else
                                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> En attente</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            @if($avance->statut != 'Payé')
                                                @if($contratEstTermine)
                                                    <span class="badge bg-secondary">Bloqué</span>
                                                @else
                                                    <form action="{{ route('locataire.payerSeul', $avance->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-primary btn-sm px-3 shadow-sm">
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
                    <div class="modal-footer bg-light d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Fermer</button>
                        
                        @if($aDesAvancesImpayees && !$contratEstTermine)
                            <form action="{{ route('locataire.payerToutesAvances', $contratActuel->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm fw-bold px-3 shadow-sm" onclick="return confirm('Solder la totalité des avances ?');">
                                    <i class="fa-solid fa-check-double me-1"></i> Tout Payer Maintenant
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endif

    @endif
</div>

<!-- SCRIPTS BOOTSTRAP OBLIGATOIRES POUR L'OUVERTURE DU MODAL -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>