<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Propriétaire - MaisonLoc</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-soft: #eff6ff;
            --text-dark: #111827;
            --text-light: #4b5563;
            --text-muted: #9ca3af;
            --bg-light: #f4f7fb;
            --bg-card: #ffffff;
            --border-color: #e5e7eb;
        }

        body.dark-theme {
            --bg-light: #0f172a;
            --bg-card: #1e293b;
            --text-dark: #f8fafc;
            --text-light: #cbd5e1;
            --text-muted: #64748b;
            --primary-soft: #1e293b;
            --border-color: #334155;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg-light);
            color: var(--text-dark);
            transition: background 0.3s ease, color 0.3s ease;
        }

        .navbar { box-shadow: 0 2px 4px rgba(0,0,0,0.1); }

        header {
            margin-top: 56px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 40px 20px 60px 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        header h1 { font-size: 1.8rem; font-weight: 600; margin-bottom: 5px; }
        header p { color: #bdc3c7; font-size: 0.95rem; margin-bottom: 15px; }

        /* Style personnalisé pour le bouton de gestion des contrats */
        .btn-contracts-nav {
            background-color: #27ae60;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 600;
            border-radius: 30px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.3);
            transition: all 0.2s ease;
        }
        .btn-contracts-nav:hover {
            background-color: #219653;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(39, 174, 96, 0.4);
        }

        .stats-container { max-width: 1200px; margin: -25px auto 30px auto; padding: 0 15px; }

        .stat-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 15px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }

        .stat-icon { font-size: 1.8rem; opacity: 0.8; }
        .stat-details h3 { font-size: 1.4rem; font-weight: 700; margin: 0; color: var(--text-dark); }
        .stat-details p { margin: 0; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; }

        .main-container { max-width: 1200px; margin: 0 auto; padding: 0 15px 80px 15px; }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark);
            border-left: 4px solid var(--primary);
            padding-left: 10px;
        }

        .houses { display: grid; grid-template-columns: 1fr; gap: 20px; }

        .card {
            background: var(--bg-card);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.04);
            overflow: hidden;
            border: 1px solid var(--border-color);
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            position: relative;
        }

        .card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .card.house-locked { background: var(--bg-light); border: 1px solid var(--border-color); }
        .card.house-locked .image-container img,
        .card.house-pending .image-container img { filter: grayscale(40%) blur(1px); }

        .image-container { position: relative; width: 100%; height: 180px; overflow: hidden; }
        .card img { width: 100%; height: 100%; object-fit: cover; }

        .status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: bold;
            backdrop-filter: blur(5px);
            z-index: 2;
        }
        .bg-available { background: rgba(39, 174, 96, 0.9); }
        .bg-locked { background: rgba(231, 76, 60, 0.95); }
        .bg-pending { background: rgba(245, 158, 11, 0.95); }

        .card-body-content { padding: 15px; flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .card h2 { margin: 0 0 8px 0; font-size: 1.15rem; font-weight: 600; color: var(--text-dark); line-height: 1.4; }
        .house-locked h2, .house-pending h2 { color: var(--text-muted); }
        .card p.description { margin: 0 0 12px 0; font-size: 0.85rem; color: var(--text-light); line-height: 1.5; }
        .price-tag { font-size: 1.1rem; color: #e74c3c; font-weight: 700; margin-bottom: 0; }
        .price-tag span { font-size: 0.75rem; color: var(--text-muted); font-weight: normal; }

        .card-actions { padding: 0 15px 15px 15px; }

        .btn-modify {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px;
            flex-grow: 1;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-modify:hover { background: var(--primary-hover); color: white; }
        .btn-modify.disabled-lock { background: #bdc3c7 !important; color: #ffffff !important; cursor: not-allowed; pointer-events: none; }

        .btn-view {
            background: var(--primary-soft);
            color: var(--text-light);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-view:hover { background: var(--border-color); color: var(--text-dark); }

        .fab-add {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
            font-size: 1.3rem;
            text-decoration: none;
            z-index: 1000;
        }

        /* Styles spécifiques pour le modal personnalisé */
        .modal-content {
            background-color: var(--bg-card);
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }
        .option-box {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .option-box:hover {
            border-color: var(--primary);
            background-color: var(--primary-soft);
        }
        .form-check-input:checked + .form-check-label .option-box {
            border-color: var(--primary);
            background-color: var(--primary-soft);
        }

        @media (min-width: 576px) { header h1 { font-size: 2rem; } .houses { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); } }
        @media (min-width: 768px) { .stats-container { margin: -20px auto 30px auto; } .stat-details h3 { font-size: 1.6rem; } .houses { grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); } .image-container { height: 200px; } }
    </style>
</head>
<body>

<script>
    (function () {
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-theme');
        }
    })();
</script>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-house-chimney me-2"></i>MaisonLoc</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <!-- AJOUT : Lien direct aussi dans la Navbar pour le confort mobile -->
                    <li class="nav-item me-2">
                        <a class="nav-link text-success fw-bold" href="{{ route('contrats.index') }}">
                            <i class="fa-solid fa-file-signature me-1"></i> Contrats & Paiements
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">
                            <i class="fa-solid fa-arrow-left me-1"></i> Retour
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <h1>Mon Tableau de Bord</h1>
        <p>Gerez vos biens et suivez la modération de vos annonces.</p>
        
        <!-- AJOUT DU BOUTON CENTRAL ICI -->
        <div class="mt-3">
            <a href="{{ route('contrats.index') }}" class="btn-contracts-nav">
                <i class="fa-solid fa-file-signature"></i> Suivi des Contrats & Paiements
            </a>
        </div>
    </header>

    <div class="stats-container">
        <!-- Statistiques existantes -->
        <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-4">
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('statut_moderation', 'publiee')->count() }}</h3>
                        <p>Total Propriétés Publiées</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-building" style="color: #3498db;"></i></div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('statut_moderation', 'en_attente')->count() }}</h3>
                        <p>En attente de validation</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-hourglass-half" style="color: #f59e0b;"></i></div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('est_loue', true)->count() }}</h3>
                        <p>Maisons Louées</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-lock" style="color: #e74c3c;"></i></div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ number_format($maisons->where('statut_moderation', 'publiee')->sum('prix'), 0, ',', ' ') }}</h3>
                        <p>Revenu Mensuel (FCFA)</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-wallet" style="color: #27ae60;"></i></div>
                </div>
            </div>
        </div>
    </div>

    <main class="main-container">
        <h2 class="section-title">Mes Maisons Enregistrées</h2>
        
        <section class="houses">
            @foreach($maisons as $maison)
            @php
                $isPending = ($maison->statut_moderation ?? 'publiee') === 'en_attente';
            @endphp
            <div class="card {{ $maison->est_loue ? 'house-locked' : '' }} {{ $isPending ? 'house-pending' : '' }}">
                
                <div class="image-container">
                    <img src="{{ asset($maison->image) }}" alt="{{ $maison['titre'] }}">
                    @if($isPending)
                        <span class="status-badge bg-pending"><i class="fa-solid fa-hourglass-half me-1"></i> En attente</span>
                    @elseif($maison->est_loue)
                        <span class="status-badge bg-locked"><i class="fa-solid fa-lock me-1"></i> Loué</span>
                    @else
                        <span class="status-badge bg-available"><i class="fa-solid fa-circle-check me-1"></i> Disponible</span>
                    @endif
                </div>
                
                <div class="card-body-content">
                    <div>
                        <h2>{{ Str::limit($maison['titre'], 20, '...') }}</h2>
                        <p class="description">{{ Str::limit($maison['description'], 50, '...') }}</p>
                    </div>
                    <p class="price-tag">
                        <strong>{{ number_format($maison['prix'], 0, ',', ' ') }}</strong> <span>FCFA/mois</span>
                    </p>
                </div>

                <div class="card-actions d-flex flex-column gap-2">
                    <div class="d-flex gap-2 w-100">
                        @if($isPending)
                            <button class="btn-modify disabled-lock flex-grow-1" title="Cette annonce est en cours d'examen par l'admin." type="button">
                                <i class="fa-solid fa-ban"></i> En cours d'examen
                            </button>
                        @elseif($maison->est_loue)
                            <button class="btn-modify disabled-lock flex-grow-1" title="Cette maison est louée et verrouillée." type="button">
                                <i class="fa-solid fa-lock"></i> Verrouillé
                            </button>
                        @else
                            <a href="{{ route('maisons.show', $maison->id) }}" class="btn-modify flex-grow-1" onclick="bookNow('{{ $maison['adresse'] }}')">
                                <i class="fa-solid fa-pen-to-square"></i> Modifier
                            </a>
                        @endif
                        
                        <a href="{{ route('maisons.infoA', $maison->id) }}" class="btn-view" title="Aperçu">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>

                    @if(!$isPending)
                        @if($maison->est_loue)
                            <form action="{{ route('maisons.toggleLoue', $maison->id) }}" method="POST" class="w-100 m-0">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                    <i class="fa-solid fa-lock-open me-1"></i> Rendre Disponible
                                </button>
                            </form>
                        @else
                            <button type="button" 
                                    class="btn btn-sm btn-outline-danger w-100 open-rented-modal" 
                                    data-id="{{ $maison->id }}"
                                    data-title="{{ $maison->titre }}">
                                <i class="fa-solid fa-lock me-1"></i> Marquer comme Loué
                            </button>
                        @endif
                    @else
                        <button class="btn btn-sm btn-light w-100" disabled style="font-size: 0.75rem; color: var(--text-light);">
                            Indisponible au public tant qu'en attente
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </section>
    </main>

    <!-- --- MODAL DE SÉLECTION DE SOURCE DU LOCATAIRE --- -->
    <div class="modal fade" id="rentedSourceModal" tabindex="-1" aria-labelledby="rentedSourceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold" id="rentedSourceModalLabel">Finaliser la mise en location</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-close="modal" aria-label="Close" style="filter: invert(1);"></button>
                </div>
                <form id="rentedForm" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="modal-body py-1">
                        <p class="text-muted small mb-3">Où avez-vous trouvé le locataire pour <strong id="modal-house-title"></strong> ?</p>
                        
                        <div class="mb-3">
                            <input class="form-check-input d-none" type="radio" name="tenant_source" id="source_site" value="site" checked>
                            <label class="form-check-label d-block w-100" for="source_site">
                                <div class="option-box p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-globe text-primary fs-4 me-3"></i>
                                        <div>
                                            <span class="d-block fw-bold">Sur MaisonLoc</span>
                                            <small class="text-muted text-wrap">Permet de gérer ses paiements et générer les contrats sur la page suivante.</small>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="mb-3">
                            <input class="form-check-input d-none" type="radio" name="tenant_source" id="source_hors_site" value="hors_site">
                            <label class="form-check-label d-block w-100" for="source_hors_site">
                                <div class="option-box p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-brands fa-whatsapp text-success fs-4 me-3"></i>
                                        <div>
                                            <span class="d-block fw-bold">Hors de la plateforme</span>
                                            <small class="text-muted text-wrap">Inviter le locataire par WhatsApp à rejoindre le site pour le suivi.</small>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div id="whatsapp-input-group" class="mb-3 px-2 d-none">
                            <label for="tenant_phone" class="form-label small fw-bold">Numéro WhatsApp du locataire (avec indicatif, ex: 22890000000)</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-success text-white border-0"><i class="fa-brands fa-whatsapp"></i></span>
                                <input type="tel" class="form-control" id="tenant_phone" name="tenant_phone" placeholder="Ex: 228XXXXXXXX">
                            </div>
                        </div>

                        <div class="mb-3">
                            <input class="form-check-input d-none" type="radio" name="tenant_source" id="source_aucun" value="aucun">
                            <label class="form-check-label d-block w-100" for="source_aucun">
                                <div class="option-box p-3">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-circle-minus text-secondary fs-4 me-3"></i>
                                        <div>
                                            <span class="d-block fw-bold">Juste marquer comme loué</span>
                                            <small class="text-muted text-wrap">Retirer l'annonce sans associer de locataire.</small>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-sm btn-primary px-3" id="submitBtn">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.ajouter') }}" class="fab-add" title="Ajouter un nouveau bien">
        <i class="fa-solid fa-plus"></i>
    </a>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function bookNow(adresse) {
            console.log("Modification de la maison à l'adresse :", adresse);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const rentedModal = new bootstrap.Modal(document.getElementById('rentedSourceModal'));
            const rentedForm = document.getElementById('rentedForm');
            const modalTitleElement = document.getElementById('modal-house-title');
            const whatsappGroup = document.getElementById('whatsapp-input-group');
            const whatsappInput = document.getElementById('tenant_phone');
            const submitBtn = document.getElementById('submitBtn');

            document.querySelectorAll('.open-rented-modal').forEach(button => {
                button.addEventListener('click', function() {
                    const houseId = this.getAttribute('data-id');
                    const houseTitle = this.getAttribute('data-title');
                    
                    rentedForm.action = `{{ route('maisons.toggleLoue', ['id' => ':id']) }}`.replace(':id', houseId);
                    modalTitleElement.textContent = houseTitle;
                    
                    document.getElementById('source_site').checked = true;
                    whatsappGroup.classList.add('d-none');
                    whatsappInput.removeAttribute('required');
                    submitBtn.textContent = "Confirmer";

                    rentedModal.show();
                });
            });

            document.querySelectorAll('input[name="tenant_source"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'hors_site') {
                        whatsappGroup.classList.remove('d-none');
                        whatsappInput.setAttribute('required', 'required');
                        submitBtn.innerHTML = '<i class="fa-brands fa-whatsapp me-1"></i> Inviter et Valider';
                    } else {
                        whatsappGroup.classList.add('d-none');
                        whatsappInput.removeAttribute('required');
                        submitBtn.textContent = "Confirmer";
                    }
                });
            });

            rentedForm.addEventListener('submit', function(e) {
                const selectedSource = document.querySelector('input[name="tenant_source"]:checked').value;
                
                if (selectedSource === 'hors_site') {
                    const phone = whatsappInput.value.trim();
                    if(phone) {
                        const message = encodeURIComponent("Bonjour ! J'ai marqué le logement que vous louez comme occupé sur MaisonLoc. Pour suivre vos quittances, vos paiements et votre contrat en ligne, créez votre compte en cliquant ici : " + window.location.origin + "/register");
                        const whatsappUrl = `https://wa.me/${phone}?text=${message}`;
                        
                        window.open(whatsappUrl, '_blank');
                    }
                }
            });
        });
    </script>
</body>
</html>