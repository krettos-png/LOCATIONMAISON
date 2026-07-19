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

    @if(!$contrat)
        <!-- Ce bloc ne s'affichera que si l'ID utilisateur dans la table contrats est totalement faux -->
        <div class="card p-5 text-center shadow-sm card-custom">
            <i class="fa-solid fa-triangle-exclamation text-warning fa-2x mb-3"></i>
            <h4 class="text-muted">Aucun contrat actif trouvé pour votre compte.</h4>
            <p class="text-muted small">Veuillez contacter votre propriétaire pour qu'il associe votre compte (ID: {{ Auth::user()->id }}) à votre logement.</p>
        </div>
    @else
        <div class="row">
            <!-- DOSSIER LOCATION -->
            <div class="col-md-4 mb-4">
                <div class="card p-4 shadow-sm h-100 card-custom bg-white">
                    <h5 class="fw-bold text-primary mb-3"><i class="fa-solid fa-file-contract me-2"></i>Mon Logement</h5>
                    <hr class="mt-0">
                    <p class="mb-2"><strong>Bien :</strong> {{ $contrat->maison->titre }}</p>
                    <p class="mb-2"><strong>Adresse :</strong> {{ $contrat->maison->adresse }}</p>
                    <p class="mb-2"><strong>Loyer :</strong> <span class="text-success fw-bold">{{ number_format($contrat->maison->prix, 0, ',', ' ') }} F CFA / mois</span></p>
                    <p class="mb-0 text-muted small">Contrat débuté le : {{ \Carbon\Carbon::parse($contrat->date_debut)->format('d/m/Y') }}</p>
                </div>
            </div>

            <!-- ZONE DE PAIEMENT LIBRE / ANTICIPÉ -->
            <div class="col-md-8 mb-4">
                
                <!-- BOUTON DE PAIEMENT À LA DEMANDE -->
                <div class="card p-4 shadow-sm card-custom bg-white mb-4">
                    <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-credit-card text-success me-2"></i>Payer mon loyer à tout moment</h5>
                    <p class="text-muted small mb-3">Sélectionnez le nombre de mois que vous souhaitez régler aujourd'hui pour votre contrat actuel.</p>
                    
                    <form action="{{ route('locataire.payerAvance', $contrat->id) }}" method="POST" class="row g-3 align-items-end">
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

                <!-- HISTORIQUE DES FACTURES -->
                <div class="card p-4 shadow-sm card-custom bg-white">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-history me-2"></i>Historique de mes paiements</h5>
                    <div class="table-responsive">
                        <table class="table align-middle m-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Période</th>
                                    <th>Montant</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
    @forelse($contrat->paiements->sortByDesc('id') as $paiement)
    <tr>
        <td class="fw-bold text-capitalize">{{ $paiement->mois_concerne }}</td>
        <td>{{ number_format($paiement->montant, 0, ',', ' ') }} F CFA</td>
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
                <!-- Optionnel : Un bouton rapide pour régler cette facture spécifique si elle est en attente -->
                <form action="{{ route('locataire.payerSeul', $paiement->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm px-2 py-1 shadow-sm">
                        <i class="fa-solid fa-wallet me-1"></i> Régler
                    </button>
                </form>
            @else
                <span class="text-muted small">
                    {{ $paiement->date_paiement ? \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') : \Carbon\Carbon::parse($paiement->updated_at)->format('d/m/Y') }}
                </span>
            @endif
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="text-center text-muted small py-3">Aucun paiement enregistré pour le moment.</td>
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