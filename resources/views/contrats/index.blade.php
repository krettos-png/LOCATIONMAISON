<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Contrats & Paiements</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .card-custom {
            border-radius: 12px;
        }
        
        /* Image de la maison dans le tableau */
        .house-thumb {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }
        
        .house-thumb-placeholder {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            flex-shrink: 0;
        }

        /* ---------------------------------------------------- */
        /* STYLES MOBILES (ÉCRANS < 768px)                      */
        /* ---------------------------------------------------- */
        @media (max-width: 767.98px) {
            body {
                font-size: 14px;
            }

            .container {
                padding-left: 12px;
                padding-right: 12px;
            }

            /* Transformation du tableau classique en cartes dynamiques sur Mobile */
            .table-mobile-responsive thead {
                display: none; /* Cacher l'en-tête */
            }

            .table-mobile-responsive tbody tr {
                display: flex;
                flex-direction: column;
                background-color: #ffffff;
                border: 1px solid #e2e8f0;
                border-radius: 12px;
                padding: 14px;
                margin-bottom: 14px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.04);
            }

            .table-mobile-responsive tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border: none !important;
                padding: 6px 0 !important;
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

            /* Exceptions d'alignement pour le contenu complexe */
            .table-mobile-responsive tbody td[data-label="Bien Loué"],
            .table-mobile-responsive tbody td[data-label="Locataire (Preneur)"] {
                flex-direction: row;
            }

            .table-mobile-responsive tbody td form,
            .table-mobile-responsive tbody td a,
            .table-mobile-responsive tbody td button {
                width: 100%;
                margin-top: 6px;
            }
        }
    </style>
</head>
<body class="bg-light">

<div class="container my-3 my-md-5">
    
    <!-- EN-TÊTE RESPONSIVE -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1 fs-3 fs-md-2">Suivi des Contrats & Loyers</h1>
            <p class="text-muted mb-0 small">Vue d'ensemble de la gestion locative et des états financiers.</p>
        </div>
        <a href="{{ route('ttt') }}" class="btn btn-outline-secondary shadow-sm btn-sm py-2 px-3 align-self-start align-self-sm-center">
            <i class="fa-solid fa-arrow-left me-1"></i> Accueil
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm border-0 mb-4">{{ session('success') }}</div>
    @endif

    <!-- CARTES DE STATISTIQUES FINANCIÈRES -->
    <div class="row g-3 mb-4 mb-md-5">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="card border-0 shadow-sm p-3 p-md-4 bg-white text-dark h-100 card-custom">
                <span class="text-muted small text-uppercase fw-bold">Baux Générés</span>
                <h3 class="fw-bold mt-2 mb-0 text-primary">{{ $totalContrats }}</h3>
                <small class="text-muted">{{ $contratsActifs }} contrats actifs</small>
            </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card border-0 shadow-sm p-3 p-md-4 bg-success text-white h-100 card-custom">
                <span class="text-white-50 small text-uppercase fw-bold">Revenus Encaissés</span>
                <h3 class="fw-bold mt-2 mb-0">{{ number_format($revenusPercus, 0, ',', ' ') }} F CFA</h3>
                <small class="text-white-50">Total des loyers réglés</small>
            </div>
        </div>
        <div class="col-12 col-md-5">
            <div class="card border-0 shadow-sm p-3 p-md-4 bg-warning text-dark h-100 card-custom">
                <span class="text-muted small text-uppercase fw-bold">Loyers en Attente / Impayés</span>
                <h3 class="fw-bold mt-2 mb-0 text-danger">{{ number_format($loyersEnAttente, 0, ',', ' ') }} F CFA</h3>
                <small class="text-muted">Sommes en attente de versement</small>
            </div>
        </div>
    </div>

    <!-- LISTE DES CONTRATS -->
    <div class="card border-0 shadow-sm p-3 p-md-4 card-custom bg-white">
        <h4 class="fw-bold text-dark mb-3 mb-md-4 fs-5 fs-md-4">Registre des Locations</h4>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 table-mobile-responsive">
                <thead class="table-dark">
                    <tr>
                        <th>Réf Contractuelle</th>
                        <th>Bien Loué</th>
                        <th>Locataire (Preneur)</th>
                        <th>Loyer Mensuel</th>
                        <th>Dernier État de Paiement</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contrats as $contrat)
                    <tr>
                        <!-- Référence -->
                        <td data-label="Référence">
                            <span class="fw-bold text-secondary">#CT-{{ $contrat->id }}</span>
                            @if($contrat->statut == 'actif')
                                <span class="badge bg-success-subtle text-success px-2 py-1 small ms-1">Actif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1 small ms-1">Terminé</span>
                            @endif
                        </td>
                        
                        <!-- Bien loué (avec Image) -->
                        <td data-label="Bien Loué">
                            <div class="d-flex align-items-center gap-2 text-start">
                                
                                <div>
                                    <div class="fw-bold text-dark">{{ $contrat->maison->titre ?? 'Logement Supprimé' }}</div>
                                    <small class="text-muted">Réf maison: #{{ $contrat->maison_id }}</small>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Locataire -->
                        <td data-label="Locataire">
                            <div class="text-start text-md-start">
                                @if($contrat->locataire)
                                    <div class="fw-bold">{{ $contrat->locataire->prenom }} {{ $contrat->locataire->nom ?? $contrat->locataire->name }}</div>
                                    <small class="text-muted">{{ $contrat->locataire->email }}</small>
                                @else
                                    <span class="text-danger small">Locataire introuvable (ID: {{ $contrat->utilisateur_id }})</span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Loyer -->
                        <td data-label="Loyer Mensuel" class="fw-bold text-success">
                            {{ number_format($contrat->maison->prix ?? 0, 0, ',', ' ') }} F CFA
                        </td>
                        
                        <!-- État du dernier paiement généré -->
                        <td data-label="Dernier État">
                            @php 
                                $dernierPaiement = $contrat->paiements->last(); 
                            @endphp
                            
                            @if($dernierPaiement)
                                @if($dernierPaiement->statut == 'Payé')
                                    <span class="badge bg-success text-capitalize px-2 py-1.5">
                                        ✓ {{ $dernierPaiement->mois_concerne }} Payé
                                    </span>
                                @else
                                    <span class="badge bg-danger text-capitalize px-2 py-1.5">
                                        ⏱️ {{ $dernierPaiement->mois_concerne }} En attente
                                    </span>
                                @endif
                            @else
                                <span class="text-muted small">Aucun loyer planifié</span>
                            @endif
                        </td>
                        
                        <!-- Lien vers la fiche du contrat -->
                        <td data-label="Action" class="text-end">
                            <a href="{{ route('contrats.show', $contrat->id) }}" class="btn btn-sm btn-primary shadow-sm px-3 w-100 w-md-auto">
                                <i class="fa-solid fa-magnifying-glass me-1"></i> Consulter
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <i class="fa-solid fa-folder-open fa-2x mb-3 text-secondary"></i>
                            <h5>Aucun contrat de location n'a été enregistré.</h5>
                            <p class="small mb-0">Les contrats apparaîtront ici dès qu'une maison sera louée.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>