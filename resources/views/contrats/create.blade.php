<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Génération de Contrat - MaisonLoc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f4f7fb; font-family: 'Segoe UI', sans-serif; padding-top: 80px; }
        .contract-card { background: white; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: none; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand"><i class="fa-solid fa-file-signature me-2"></i>MaisonLoc — Espace Contrat</span>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row g-4">
            <!-- Récapitulatif du Bien (Gauche) -->
            <div class="col-md-4">
                <div class="card contract-card p-3">
                    <img src="{{ asset($maison->image) }}" class="card-img-top rounded mb-3" alt="{{ $maison->titre }}" style="height: 180px; object-fit: cover;">
                    <h5 class="fw-bold">{{ $maison->titre }}</h5>
                    <p class="text-muted small mb-2"><i class="fa-solid fa-location-dot me-1"></i> {{ $maison->adresse }}</p>
                    <h4 class="text-danger fw-bold">{{ number_format($maison->prix, 0, ',', ' ') }} <span class="fs-6 text-muted">FCFA/mois</span></h4>
                </div>
            </div>

            <!-- Formulaire Contrat & Paiement (Droite) -->
            <div class="col-md-8">
                <div class="card contract-card p-4">
                    <h3 class="fw-bold mb-4"><i class="fa-solid fa-file-invoice text-primary me-2"></i>Initialisation du bail</h3>
                    
                    <!-- Formulaire à lier plus tard à ta route de stockage de contrat -->
                    <form action="{{ route('contrats.store') }}" method="POST">
                        @csrf
                        
                        <!-- ID masqué du locataire trouvé sur le site -->
                        <input type="hidden" name="tenant_id" id="tenant_id">
                        //id maison cache
                        <input type="hidden" name="maison_id" value="{{ $maison->id }}">

                        <div class="row g-3">
                            <!-- Étape 1 : Recherche par adresse e-mail -->
                            <div class="col-md-12">
                                <label class="form-label fw-bold small">Adresse e-mail du locataire inscrit sur le site</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fa-solid fa-envelope text-muted"></i></span>
                                    <input type="email" class="form-control" id="tenant_email" name="tenant_email" required placeholder="Ex: locataire@email.com">
                                    <button class="btn btn-dark px-3" type="button" id="btn-verifier-email">
                                        <i class="fa-solid fa-magnifying-glass me-1"></i> Vérifier
                                    </button>
                                </div>
                                <!-- Message de retour (Succès ou Erreur) -->
                                <div id="email-feedback" class="form-text mt-2"></div>
                            </div>

                            <!-- Étape 2 : Champs d'informations bails -->
                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold small">Nom complet du Locataire</label>
                                <input type="text" class="form-control bg-light" id="tenant_name" name="tenant_name" required readonly placeholder="Recherchez d'abord par e-mail">
                            </div>

                            <div class="col-md-6 mt-3">
                                <label class="form-label fw-bold small">Date de prise d'effet</label>
                                <input type="date" class="form-control" name="start_date" required>
                            </div>
                            
                            <hr class="my-4">
                            
                            <h5><i class="fa-solid fa-credit-card text-success me-2"></i>Options d'intégration</h5>
                            <div class="p-3 bg-light rounded border mb-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="generate_pdf" checked disabled>
                                    <label class="form-check-label small" for="generate_pdf">
                                        Générer automatiquement le contrat au format PDF
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="activate_payment" checked disabled>
                                    <label class="form-check-label small" for="activate_payment">
                                        Activer le paiement des loyers en ligne pour ce locataire (Mobile Money / Stripe)
                                    </label>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('home') }}" class="btn btn-light">Plus tard</a>
                                <button type="submit" class="btn btn-primary px-4" id="btn-submit-contrat" disabled>
                                    <i class="fa-solid fa-floppy-disk me-1"></i> Générer le contrat
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT AJAX POUR LA VERIFICATION D'EMAIL -->
    <script>
    document.getElementById('btn-verifier-email').addEventListener('click', function() {
        const email = document.getElementById('tenant_email').value.trim();
        const feedback = document.getElementById('email-feedback');
        const nameInput = document.getElementById('tenant_name');
        const tenantIdInput = document.getElementById('tenant_id');
        const submitBtn = document.getElementById('btn-submit-contrat');

        if (!email) {
            feedback.innerHTML = '<span class="text-danger"><i class="fa-solid fa-circle-exclamation me-1"></i> Veuillez saisir une adresse e-mail.</span>';
            return;
        }

        // Message de chargement pendant la requête
        feedback.innerHTML = '<span class="text-muted"><i class="fa-solid fa-spinner fa-spin me-1"></i> Recherche dans la base de données...</span>';

        // Requête AJAX vers notre route d'API Laravel
        fetch(`${window.location.origin}/location/public/api/users/recherche-email?email=${encodeURIComponent(email)}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Si l'utilisateur existe
                    feedback.innerHTML = `<span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> Compte validé : <strong>${data.name}</strong></span>`;
                    nameInput.value = data.name;
                    tenantIdInput.value = data.user_id; // Stockage de l'ID secret
                    submitBtn.removeAttribute('disabled'); // Déblocage du bouton de soumission
                } else {
                    // Si l'utilisateur n'existe pas
                    feedback.innerHTML = `<span class="text-danger"><i class="fa-solid fa-circle-xmark me-1"></i> ${data.message}</span>`;
                    nameInput.value = '';
                    tenantIdInput.value = '';
                    submitBtn.setAttribute('disabled', 'disabled'); // Verrouillage du bouton
                }
            })
            .catch(error => {
                console.error('Erreur technique:', error);
                feedback.innerHTML = '<span class="text-danger"><i class="fa-solid fa-triangle-exclamation me-1"></i> Erreur lors de la communication avec le serveur.</span>';
            });
    });
    </script>
</body>
</html>