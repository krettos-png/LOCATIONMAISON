<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Contrats & Paiements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    
    <!-- EN-TÊTE -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold text-dark mb-1">Suivi des Contrats & Loyers</h1>
            <p class="text-muted mb-0">Vue d'ensemble de la gestion locative et des états financiers.</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary shadow-sm">← Retour à l'accueil</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <!-- CARTES DE STATISTIQUES FINANCIÈRES -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="card border-0 shadow-sm p-4 bg-white text-dark h-100">
                <span class="text-muted small text-uppercase fw-bold">Baux Générés</span>
                <h3 class="fw-bold mt-2 mb-0 text-primary">{{ $totalContrats }}</h3>
                <small class="text-muted">{{ $contratsActifs }} contrats actifs actuellement</small>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 shadow-sm p-4 bg-success text-white h-100">
                <span class="text-white-50 small text-uppercase fw-bold">Revenus Encaissés</span>
                <h3 class="fw-bold mt-2 mb-0">{{ number_format($revenusPercus, 0, ',', ' ') }} F CFA</h3>
                <small class="text-white-50">Total des loyers réglés avec succès</small>
            </div>
        </div>
        <div class="col-md-5 mb-3">
            <div class="card border-0 shadow-sm p-4 bg-warning text-dark h-100">
                <span class="text-muted small text-uppercase fw-bold">Loyers en Attente / Impayés</span>
                <h3 class="fw-bold mt-2 mb-0 text-danger">{{ number_format($loyersEnAttente, 0, ',', ' ') }} F CFA</h3>
                <small class="text-muted">Sommes en attente de versement par les locataires</small>
            </div>
        </div>
    </div>

    <!-- LISTE DES CONTRATS -->
    <div class="card border-0 shadow-sm p-4">
        <h4 class="fw-bold text-dark mb-4">Registre des Locations</h4>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Réf Contractuelle</th>
                        <th>Bien Loué</th>
                        <th>Locataire (Preneur)</th>
                        <th>Loyer Mensuel</th>
                        <th>Dernier État de Paiement</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contrats as $contrat)
                    <tr>
                        <!-- Référence -->
                        <td>
                            <span class="fw-bold text-secondary">#CT-{{ $contrat->id }}</span>
                            @if($contrat->statut == 'actif')
                                <span class="badge bg-success-subtle text-success px-2 py-1 small ms-1">Actif</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-2 py-1 small ms-1">Terminé</span>
                            @endif
                        </td>
                        
                        <!-- Bien loué -->
                        <td>
                            <div class="fw-bold">{{ $contrat->maison->titre ?? 'Logement Supprimé' }}</div>
                            <small class="text-muted">Réf maison: #{{ $contrat->maison_id }}</small>
                        </td>
                        
                        <!-- Locataire -->
                        <td>
                            @if($contrat->locataire)
                                <div class="fw-bold">{{ $contrat->locataire->prenom }} {{ $contrat->locataire->nom ?? $contrat->locataire->name }}</div>
                                <small class="text-muted">{{ $contrat->locataire->email }}</small>
                            @else
                                <span class="text-danger small">Locataire introuvable (ID: {{ $contrat->utilisateur_id }})</span>
                            @endif
                        </td>
                        
                        <!-- Loyer -->
                        <td class="fw-bold text-success">
                            {{ number_format($contrat->maison->prix ?? 0, 0, ',', ' ') }} F CFA
                        </td>
                        
                        <!-- État du dernier paiement généré -->
                        <td>
                            @php 
                                $dernierPaiement = $contrat->paiements->last(); 
                            @endphp
                            
                            @if($dernierPaiement)
                                @if($dernierPaiement->statut == 'Payé')
                                    <span class="badge bg-success text-capitalize px-2 py-2">
                                        ✓ {{ $dernierPaiement->mois_concerne }} Payé
                                    </span>
                                @else
                                    <span class="badge bg-danger text-capitalize px-2 py-2">
                                        ⏱️ {{ $dernierPaiement->mois_concerne }} En attente
                                    </span>
                                @endif
                            @else
                                <span class="text-muted small">Aucun loyer planifié</span>
                            @endif
                        </td>
                        
                        <!-- Lien vers la fiche du contrat (Impression / Suivi détaillé) -->
                        <td>
                            <a href="{{ route('contrats.show', $contrat->id) }}" class="btn btn-sm btn-primary shadow-sm px-3">
                                🔍 Consulter & Imprimer
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-5">
                            <h5>Aucun contrat de location n'a été enregistré pour le moment.</h5>
                            <p class="small mb-0">Les contrats apparaîtront ici dès qu'une maison sera marquée comme louée sur le site.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

</body>
</html>