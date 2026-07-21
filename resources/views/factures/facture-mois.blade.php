<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture_{{ $paiement->mois_concerne }}_Contrat#{{ $paiement->contrat_id }}</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            font-size: 13px;
        }
        .invoice-card {
            max-width: 700px;
            margin: 20px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }
        .border-dashed {
            border-style: dashed !important;
        }
        
        /* IMPRESSION STRICTE POUR UNE SEULE PAGE */
        @media print {
            @page {
                size: A4 portrait;
                margin: 15mm;
            }
            body {
                background: #ffffff !important;
                font-size: 12px !important;
            }
            .invoice-card {
                box-shadow: none !important;
                padding: 0 !important;
                margin: 0 !important;
                max-width: 100% !important;
            }
            .d-print-none {
                display: none !important;
            }
        }
    </style>
</head>
<body>

<!-- BARRE D'ACTION HORS IMPRESSION -->
<div class="text-center my-3 d-print-none">
    <button onclick="window.print();" class="btn btn-primary btn-sm shadow-sm">
        <i class="fa-solid fa-print me-1"></i> Imprimer cette facture
    </button>
    <button onclick="window.close();" class="btn btn-secondary btn-sm shadow-sm ms-2">
        <i class="fa-solid fa-xmark me-1"></i> Fermer
    </button>
</div>

<div class="invoice-card">
    
    <!-- EN-TÊTE -->
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-3">
        <div>
            <h4 class="fw-bold text-uppercase mb-0 text-primary">QUITTANCE DE LOYER</h4>
            <small class="text-muted">Reçu de paiement mensuel</small>
        </div>
        <div class="text-end">
            <span class="badge bg-dark fs-6">N° {{ $paiement->reference_paiement ?? 'FAC-'.$paiement->id }}</span>
            <p class="mb-0 text-muted small mt-1">Date : {{ \Carbon\Carbon::parse($paiement->date_paiement)->format('d/m/Y') }}</p>
        </div>
    </div>

    <!-- PARTIES CONTRACTANTES -->
    <div class="row mb-3">
        <div class="col-6">
            <h6 class="fw-bold border-bottom pb-1 text-secondary">BAILLEUR / PROPRIÉTAIRE</h6>
            <p class="mb-1"><strong>Nom :</strong> 
                {{ $paiement->contrat->maison->utilisateur->prenom ?? '' }} 
                {{ $paiement->contrat->maison->utilisateur->name ?? $paiement->contrat->maison->utilisateur->nom ?? 'Gestionnaire' }}
            </p>
            <p class="mb-0 text-muted small"><strong>Email :</strong> {{ $paiement->contrat->maison->utilisateur->email ?? 'N/A' }}</p>
        </div>
        <div class="col-6 text-end">
            <h6 class="fw-bold border-bottom pb-1 text-secondary">LOCATAIRE</h6>
            <p class="mb-1"><strong>Nom :</strong> 
                {{ $paiement->contrat->locataire->prenom ?? '' }} 
                {{ $paiement->contrat->locataire->name ?? $paiement->contrat->locataire->nom ?? 'Locataire' }}
            </p>
            <p class="mb-0 text-muted small"><strong>Email :</strong> {{ $paiement->contrat->locataire->email ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- DÉTAILS DU BIEN -->
    <div class="bg-light p-2 rounded mb-3">
        <div class="row">
            <div class="col-6">
                <strong>Contrat de bail :</strong> #CT-{{ $paiement->contrat_id }}
            </div>
            <div class="col-6 text-end">
                <strong>Bien loué :</strong> Logement #{{ $paiement->contrat->maison->id }}
            </div>
        </div>
    </div>

    <!-- TABLEAU DU DÉTAIL DU PAIEMENT -->
    <table class="table table-bordered align-middle mb-3">
        <thead class="table-light">
            <tr>
                <th>Désignation / Période</th>
                <th>Mode de Paiement</th>
                <th class="text-end">Montant Réglé</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="fw-bold text-capitalize">
                    Loyer du mois : {{ $paiement->mois_concerne }}
                </td>
                <td>{{ $paiement->moyen_paiement ?? 'Espèces / Virement' }}</td>
                <td class="text-end fw-bold text-success fs-6">
                    {{ number_format($paiement->montant, 0, ',', ' ') }} F CFA
                </td>
            </tr>
        </tbody>
    </table>

    <!-- CERTIFICATION DE PAIEMENT -->
    <div class="alert alert-success d-flex align-items-center p-2 mb-3">
        <i class="fa-solid fa-circle-check fs-5 me-2"></i>
        <div class="small">
            Le bailleur reconnaît avoir reçu la somme mentionnée ci-dessus au titre du loyer pour le mois de <strong>{{ $paiement->mois_concerne }}</strong>.
        </div>
    </div>

    <!-- SIGNATURES -->
    <div class="row text-center mt-4 pt-2">
        <div class="col-6">
            <p class="fw-bold mb-0 small">Pour le Bailleur</p>
            <div class="mt-2 mx-auto border-bottom border-secondary border-dashed" style="width: 70%; height: 40px;"></div>
        </div>
        <div class="col-6">
            <p class="fw-bold mb-0 small">Pour le Locataire</p>
            <div class="mt-2 mx-auto border-bottom border-secondary border-dashed" style="width: 70%; height: 40px;"></div>
        </div>
    </div>

</div>

<!-- SCRIPT DE DÉCLENCHEMENT D'IMPRESSION AUTOMATIQUE -->
<script>
    window.onload = function() {
        // Lance la boîte de dialogue d'impression dès l'ouverture de l'onglet
        window.print();
    };
</script>

</body>
</html>