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
        
        /* Styles pour différencier le contrat sélectionné */
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
    </style>
</head>
<body class="bg-light">

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Bonjour, {{ Auth::user()->prenom ?? Auth::user()->name }} 👋</h1>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Retour au site
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 mb-4">{{ session('success') }}</div>
    @endif

    {{-- 1. VÉRIFICATION DU NOMBRE DE CONTRATS DISPONIBLES --}}
    @if(!isset($contrats) || $contrats->isEmpty())
        <div class="card p-5 text-center shadow-sm card-custom bg-white">
            <i class="fa-solid fa-triangle-exclamation text-warning fa-2x mb-3"></i>
            <h4 class="text-muted">Aucun contrat actif trouvé pour votre compte.</h4>
            <p class="text-muted small">Veuillez contacter votre propriétaire pour qu'il associe votre compte (ID: {{ Auth::user()->id }}) à votre logement.</p>
        </div>
    @else
        
        {{-- Détermination du contrat sélectionné --}}
        @php
            $contratIdSelectionne = request('contrat_id', $contrats->first()->id);
            $contratActuel = $contrats->firstWhere('id', $contratIdSelectionne) ?? $contrats->first();
            
            // On définit si le contrat est considéré comme clos / archivé
            $contratEstTermine = ($contratActuel->statut === 'termine' || $contratActuel->statut === 'interrompu');
        @endphp

        {{-- MULTI-CONTRATS : Affichage des différents baux --}}
        @if($contrats->count() > 1)
            <div class="mb-4">
                <h5 class="fw-bold text-secondary mb-3"><i class="fa-solid fa-layer-group me-2"></i>Sélectionnez le contrat à consulter :</h5>
                <div class="row g-3 row-cols-1 row-cols-md-3">
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
        
        {{-- Traitement des impayés et frais --}}
        @php
            $paiementsEnAttente = $contratActuel->paiements->where('statut', '!=', 'Payé');

            $aDesFraisInitiauxImpayes = $paiementsEnAttente->contains(function($paiement) {
                $libelle = strtolower($paiement->mois_concerne ?? '');
                return str_contains($libelle, 'caution') || 
                       str_contains($libelle, 'frais') || 
                       str_contains($libelle, 'commission');
            });
        @endphp

        {{-- CONTENU DU CONTRAT SÉLECTIONNÉ --}}
        <div class="row">
            <!-- DOSSIER LOCATION -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 shadow-sm h-100 card-custom bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="fw-bold text-primary m-0"><i class="fa-solid fa-file-contract me-2"></i>Mon Logement</h5>
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

            <!-- ZONE DE PAIEMENT LIBRE / ANTICIPÉ OU BLOCAGE -->
            <div class="col-md-8 mb-4">
                
                @if($contratEstTermine)
                    <!-- MESSAGE SI LE CONTRAT EST TERMINÉ -->
                    <div class="card p-4 shadow-sm card-custom bg-white mb-4 border-start border-secondary border-4">
                        <h5 class="fw-bold text-secondary mb-2">
                            <i class="fa-solid fa-ban me-2"></i>Contrat clos
                        </h5>
                        <p class="text-muted small mb-0">
                            Ce contrat est archivé ou expiré. Les fonctionnalités de paiements par anticipation sont désactivées.
                        </p>
                    </div>
                @elseif($aDesFraisInitiauxImpayes)
                    <!-- MESSAGE D'AVERTISSEMENT : PAIEMENT LIBRE BLOQUÉ -->
                    <div class="card p-4 shadow-sm card-custom bg-white mb-4 border-start border-danger border-4">
                        <h5 class="fw-bold text-danger mb-2">
                            <i class="fa-solid fa-lock me-2"></i>Paiement anticipé indisponible
                        </h5>
                        <p class="text-muted small mb-0">
                            Vous devez obligatoirement solder vos **frais initiaux, cautions et commissions** dans le tableau d'historique ci-dessous avant de pouvoir effectuer des paiements de loyers à tout moment.
                        </p>
                    </div>
                @else
                    <!-- BOUTON DE PAIEMENT À LA DEMANDE -->
                    <div class="card p-4 shadow-sm card-custom bg-white mb-4">
                        <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-credit-card text-success me-2"></i>Payer mon loyer à tout moment</h5>
                        <p class="text-muted small mb-3">Sélectionnez le nombre de mois que vous souhaitez régler aujourd'hui pour votre contrat à <strong>{{ $contratActuel->maison->titre }}</strong>.</p>
                        
                        <form action="{{ route('locataire.payerAvance', $contratActuel->id) }}" method="POST" class="row g-3 align-items-end">
                            @csrf
                            <div class="col-sm-8">
                                <label for="nombre_mois" class="form-label small fw-bold text-muted">Période à régler</label>
                                <select class="form-select" id="nombre_mois" name="nombre_mois">
                                    <option value="1" selected>1 Mois de loyer</option>
                                    <option value="2">2 Mois de loyer</option>
                                    <option value="3">3 Mois de loyer</option>
                                    <option value="6">6 Mois de loyer (1 Semestre)</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-pay-advance w-100 py-2 shadow-sm">
                                    Valider le paiement
                                </button>
                            </div>
                        </form>
                    </div>
                @endif

                <!-- HISTORIQUE DES FACTURES DU CONTRAT ACTUEL -->
                <div class="card p-4 shadow-sm card-custom bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-history me-2"></i>Historique des paiements (Ce contrat)</h5>
                    <div class="table-responsive">
                        <table class="table align-middle m-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Désignation / Période</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                    <th>Action / Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($contratActuel->paiements->sortByDesc('id') as $paiement)
                                <tr>
                                    <td class="fw-bold text-capitalize text-secondary">{{ $paiement->mois_concerne }}</td>
                                    <td class="fw-bold">{{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</td>
                                    <td>
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
                                    <td>
                                        @if($paiement->statut != 'Payé')
                                            @if($contratEstTermine)
                                                {{-- CONTRAT TERMINÉ : Le bouton Régler est désactivé et grisé --}}
                                                <button type="button" class="btn btn-secondary btn-sm px-3 py-1 shadow-sm" disabled title="Le contrat associé est expiré ou clôturé">
                                                    <i class="fa-solid fa-lock me-1"></i> Bloqué
                                                </button>
                                            @else
                                                {{-- CONTRAT ACTIF : Option de paiement classique --}}
                                                <form action="{{ route('locataire.payerSeul', $paiement->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm px-3 py-1 shadow-sm">
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
                                <tr>
                                    <td colspan="4" class="text-center text-muted small py-3">Aucun paiement enregistré pour ce contrat.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    @endif
</div>

</body>
</html>