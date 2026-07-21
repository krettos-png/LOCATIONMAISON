<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Propriétaire - MaisonLoc</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
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

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background: var(--bg-light); 
            color: var(--text-dark);
            overflow-x: hidden; 
            transition: background 0.3s ease, color 0.3s ease;
        }

        /* ===================================
           HEADER & HERO SECTION
        =================================== */
        .hero-rental {
            min-height: 20vh;
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.75)),
                        url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070');
            background-size: cover;
            background-position: center;
            padding: 15px 5% 35px 5%;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            position: relative;
        }

        .logo a { color: white; text-decoration: none; font-size: 24px; font-weight: 700; }
        .logo span { color: #3b82f6; }

        .nav-container { display: flex; align-items: center; gap: 20px; }
        .btn-contracts-nav {
            background: #27ae60;
            color: white;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 4px 10px rgba(39, 174, 96, 0.3);
            transition: 0.3s;
        }
        .btn-contracts-nav:hover { background: #219653; color: white; transform: translateY(-2px); }

        .btn-back {
            background: rgba(255,255,255,0.15);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            backdrop-filter: blur(5px);
            transition: 0.3s;
        }
        .btn-back:hover { background: white; color: #1e293b; }

        .hero-content { margin: 15px 0 0 0; max-width: 800px; }
        .hero-content h1 { font-size: clamp(22px, 3.5vw, 36px); line-height: 1.2; font-weight: 800; letter-spacing: -0.5px; }
        .hero-content p { margin-top: 5px; font-size: clamp(13px, 1.5vw, 15px); color: #cbd5e1; }

        /* ===================================
           STATS CONTAINER
        =================================== */
        .stats-container { max-width: 1440px; margin: -25px auto 30px auto; padding: 0 4%; }

        .stat-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 12px 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }

        .stat-icon { font-size: 1.5rem; opacity: 0.8; }
        .stat-details h3 { font-size: 1.2rem; font-weight: 700; margin: 0; color: var(--text-dark); }
        .stat-details p { margin: 0; color: var(--text-muted); font-size: 0.68rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 600; }

        /* ===================================
           HOUSES SECTION (STYLE EXACT DE LA RECHERCHE)
        =================================== */
        .houses-section {
            padding: 0 4% 60px;
            max-width: 1440px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 25px;
            color: var(--text-dark);
            position: relative;
            padding-left: 15px;
        }
        .section-title span { color: var(--primary); }
        .section-title::before {
            content: ''; position: absolute; left: 0; top: 15%; height: 70%; width: 4px; background: #3b82f6; border-radius: 4px;
        }

        .house-card {
            background: var(--bg-card);
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid var(--border-color);
            position: relative;
        }

        .house-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 20px -5px rgba(0,0,0,0.08);
            border-color: #cbd5e1;
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 140px; 
            overflow: hidden;
            background-color: #f1f5f9;
        }

        @media(min-width: 576px) {
            .image-container { height: 170px; }
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .house-card:hover .image-container img { transform: scale(1.04); }

        .house-card.house-locked .image-container img,
        .house-card.house-pending .image-container img { filter: grayscale(40%) blur(1px); }

        /* BADGES STATUTS */
        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            color: white;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 700;
            backdrop-filter: blur(5px);
            z-index: 2;
        }
        .bg-available { background: rgba(39, 174, 96, 0.95); }
        .bg-locked { background: rgba(239, 68, 68, 0.95); }
        .bg-pending { background: rgba(245, 158, 11, 0.95); }

        .card-body-content {
            padding: 12px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .house-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .house-description {
            font-size: 11px;
            color: var(--text-light);
            margin-bottom: 8px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .price-tag {
            font-size: 13px;
            font-weight: 700;
            color: #2563eb;
            margin-top: auto;
            padding-top: 8px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }
        .price-tag span { font-size: 10px; color: var(--text-muted); font-weight: 400; }

        /* ACTIONS BOUTONS COMPACTS */
        .card-actions { padding: 0 12px 12px 12px; }

        .btn-modify {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 6px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 11px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            text-decoration: none;
            transition: 0.2s;
        }
        .btn-modify:hover { background: #2563eb; color: white; }
        .btn-modify.disabled-lock { background: #9ca3af !important; color: #ffffff !important; cursor: not-allowed; }

        .btn-view {
            background: var(--primary-soft);
            color: var(--text-light);
            border: none;
            width: 30px;
            height: 30px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 11px;
        }
        .btn-view:hover { background: var(--border-color); color: var(--text-dark); }

        .fab-add {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #3b82f6;
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
            font-size: 1.2rem;
            text-decoration: none;
            z-index: 1000;
            transition: 0.3s;
        }
        .fab-add:hover { background: #2563eb; color: white; transform: scale(1.05); }

        .modal-content {
            background-color: var(--bg-card);
            color: var(--text-dark);
            border: none;
            border-radius: 12px;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);
        }
        .option-box {
            border: 1px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }
        .option-box:hover {
            border-color: #3b82f6;
            background-color: var(--primary-soft);
        }
        .form-check-input:checked + .form-check-label .option-box {
            border-color: #3b82f6;
            background-color: var(--primary-soft);
        }

        /* FOOTER EXACT */
        .main-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 20px 5%;
            margin-top: 50px;
            text-align: center;
            font-size: 13px;
            border-top: 3px solid #3b82f6;
        }
        .footer-logo { font-size: 20px; font-weight: 800; color: white; margin-bottom: 5px; }
        .footer-logo span { color: #3b82f6; }
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

    <!-- ALERTS -->
    @if(session('success'))
        <div class="alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3 shadow border-0 z-3" role="alert" style="z-index: 9999; border-radius: 8px; font-size: 13px;">
            {{ session('success') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger position-fixed top-0 start-50 translate-middle-x mt-3 shadow border-0 z-3" role="alert" style="z-index: 9999; border-radius: 8px; font-size: 13px;">
            {{ session('error') }}
        </div>
    @endif

    <!-- HERO HEADER -->
    <section class="hero-rental">
        <header class="navbar">
            <div class="logo">
                <a href="{{ url('/') }}">Maison<span>Loc</span></a>
            </div>
            <div class="nav-container">
                <a href="{{ route('contrats.index') }}" class="btn-contracts-nav">
                    <i class="fa-solid fa-file-signature"></i> <span class="d-none d-sm-inline">Contrats & Paiements</span>
                </a>
                <a href="{{ route('home') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left me-1"></i> Retour
                </a>
            </div>
        </header>

        <div class="hero-content">
            <h1>Mon Tableau de Bord</h1>
            <p>Gérez vos biens immobiliers et suivez leur statut en temps réel.</p>
        </div>
    </section>

    <!-- STATS COMPACTES -->
    <div class="stats-container">
        <div class="row g-2 row-cols-2 row-cols-md-4">
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('statut_moderation', 'publiee')->count() }}</h3>
                        <p>Publiées</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-building" style="color: #3b82f6;"></i></div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('statut_moderation', 'en_attente')->count() }}</h3>
                        <p>En Attente</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-hourglass-half" style="color: #f59e0b;"></i></div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('est_loue', true)->count() }}</h3>
                        <p>Louées</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-lock" style="color: #ef4444;"></i></div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ number_format($maisons->where('statut_moderation', 'publiee')->sum('prix'), 0, ',', ' ') }}</h3>
                        <p>Revenu (FCFA)</p>
                    </div>
                    <div class="stat-icon"><i class="fa-solid fa-wallet" style="color: #10b981;"></i></div>
                </div>
            </div>
        </div>
    </div>

    <!-- MAIN MAISONS GRID (MÊME GRILLE QUE LA RECHERCHE) -->
    <main class="houses-section">
        <h2 class="section-title">Mes Maisons <span>Enregistrées</span></h2>
        
        <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-sm-4">
            @foreach($maisons as $maison)
            @php
                $isPending = ($maison->statut_moderation ?? 'publiee') === 'en_attente';
            @endphp
            <div class="col">
                <div class="house-card {{ $maison->est_loue ? 'house-locked' : '' }} {{ $isPending ? 'house-pending' : '' }}">
                    
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
                        <h3 class="house-title">{{ $maison['titre'] }}</h3>
                        <p class="house-description">{{ $maison['description'] }}</p>
                        <div class="price-tag">
                            {{ number_format($maison['prix'], 0, ',', ' ') }} FCFA <span>/ mois</span>
                        </div>
                    </div>

                    <div class="card-actions d-flex flex-column gap-1">
                        <div class="d-flex gap-1 w-100">
                            @if($isPending)
                                <button class="btn-modify disabled-lock flex-grow-1" title="Annonce en cours de modération." type="button">
                                    <i class="fa-solid fa-ban"></i> Examen
                                </button>
                            @elseif($maison->est_loue)
                                <button class="btn-modify disabled-lock flex-grow-1" title="Logement actuellement loué." type="button">
                                    <i class="fa-solid fa-lock"></i> Verrouillé
                                </button>
                            @else
                                <a href="{{ route('maisons.show', $maison->id) }}" class="btn-modify flex-grow-1">
                                    <i class="fa-solid fa-pen-to-square"></i> Modifier
                                </a>
                            @endif
                            
                            <a href="{{ route('maisons.infoA', $maison->id) }}" class="btn-view" title="Aperçu">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>

                        @if(!$isPending)
                            @if($maison->est_loue)
                                <button type="button" class="btn btn-sm btn-outline-danger w-100 py-1" style="font-size: 11px; border-radius: 6px;" data-bs-toggle="modal" data-bs-target="#resiliationModal{{ $maison->id }}">
                                    <i class="fa-solid fa-lock-open me-1"></i> Libérer
                                </button>
                            @else
                                <button type="button" 
                                        class="btn btn-sm btn-outline-danger w-100 open-rented-modal py-1" 
                                        style="font-size: 11px; border-radius: 6px;"
                                        data-id="{{ $maison->id }}"
                                        data-title="{{ $maison->titre }}">
                                    <i class="fa-solid fa-lock me-1"></i> Marquer Loué
                                </button>
                            @endif
                        @else
                            <button class="btn btn-sm btn-light w-100 py-1" disabled style="font-size: 10px; border-radius: 6px; color: var(--text-light);">
                                Non publié
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- MODAL RÉSILIATION -->
            @if($maison->est_loue)
            @php
                $contratActif = method_exists($maison, 'contrats') ? $maison->contrats->where('statut', 'actif')->first() : null;
            @endphp
            <div class="modal fade" id="resiliationModal{{ $maison->id }}" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white border-0">
                            <h6 class="modal-title fw-bold" id="resiliationLabel{{ $maison->id }}">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> Clôture & Libération
                            </h6>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <form action="{{ route('maisons.toggleLoue', $maison->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="modal-body p-3 text-start">
                                <p class="text-dark fw-medium mb-2 small">Logement concerné : <strong>{{ $maison->titre }}</strong></p>
                                
                                @if($contratActif)
                                    <div class="bg-light p-2 rounded mb-2 border-start border-danger border-3">
                                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Locataire actuel</small>
                                        <span class="fw-bold text-dark small">
                                            {{ $contratActif->locataire->prenom ?? '' }} {{ $contratActif->locataire->nom ?? $contratActif->locataire->name ?? 'Inconnu' }}
                                        </span>
                                    </div>
                                    @php $impayes = $contratActif->paiements->where('statut', 'En attente')->count(); @endphp
                                    @if($impayes > 0)
                                        <div class="alert alert-warning py-1 px-2 small border-0 mb-2 text-dark" style="font-size: 11px;">
                                            <i class="fa-solid fa-wallet me-1"></i> Attention: <strong>{{ $impayes }} versement(s) en attente</strong>.
                                        </div>
                                    @endif
                                @endif

                                <div class="mb-2">
                                    <label class="form-label small fw-bold text-muted" style="font-size: 11px;">Motif de libération <span class="text-danger">*</span></label>
                                    <select class="form-select form-select-sm text-dark" name="motif_depart" required style="font-size: 12px; border-radius: 6px;">
                                        <option value="" disabled selected>Choisir une raison...</option>
                                        <option value="Fin de bail standard">Fin de bail standard</option>
                                        <option value="Départ anticipé du locataire">Départ anticipé</option>
                                        <option value="Non-paiement / Expulsion">Impayés / Expulsion</option>
                                        <option value="Erreur de manipulation">Correction d'erreur</option>
                                    </select>
                                </div>

                                <div class="form-check mt-2">
                                    <input class="form-check-input check-securite-resiliation" type="checkbox" id="confirmCheck{{ $maison->id }}" data-target="btnSubmitResil{{ $maison->id }}">
                                    <label class="form-check-label text-muted ms-1" for="confirmCheck{{ $maison->id }}" style="font-size: 11px;">
                                        Je confirme que ce logement est vide.
                                    </label>
                                </div>
                            </div>
                            
                            <div class="modal-footer bg-light border-0 py-2">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Annuler</button>
                                <button type="submit" id="btnSubmitResil{{ $maison->id }}" class="btn btn-danger btn-sm fw-semibold px-3" disabled>
                                    Confirmer la libération
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            @endforeach
        </div>
    </main>

    <!-- MODAL SELECTION LOCATAIRE -->
    <div class="modal fade" id="rentedSourceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h6 class="modal-title fw-bold" id="rentedSourceModalLabel">Mettre en location</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="rentedForm" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="modal-body py-2">
                        <p class="text-muted small mb-2" style="font-size: 12px;">Locataire pour <strong id="modal-house-title"></strong> :</p>
                        
                        <div class="mb-2">
                            <input class="form-check-input d-none" type="radio" name="tenant_source" id="source_site" value="site" checked>
                            <label class="form-check-label d-block w-100" for="source_site">
                                <div class="option-box p-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-globe text-primary fs-5 me-2"></i>
                                        <div>
                                            <span class="d-block fw-bold small">Sur MaisonLoc</span>
                                            <small class="text-muted" style="font-size: 10px;">Gérer les paiements et contrats en ligne.</small>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div class="mb-2">
                            <input class="form-check-input d-none" type="radio" name="tenant_source" id="source_hors_site" value="hors_site">
                            <label class="form-check-label d-block w-100" for="source_hors_site">
                                <div class="option-box p-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-brands fa-whatsapp text-success fs-5 me-2"></i>
                                        <div>
                                            <span class="d-block fw-bold small">Hors de la plateforme</span>
                                            <small class="text-muted" style="font-size: 10px;">Inviter le locataire via WhatsApp.</small>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <div id="whatsapp-input-group" class="mb-2 d-none">
                            <label for="tenant_phone" class="form-label fw-bold small mb-1" style="font-size: 11px;">N° WhatsApp (ex: 22890000000)</label>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-success text-white border-0"><i class="fa-brands fa-whatsapp"></i></span>
                                <input type="tel" class="form-control" id="tenant_phone" name="tenant_phone" placeholder="228XXXXXXXX">
                            </div>
                        </div>

                        <div class="mb-2">
                            <input class="form-check-input d-none" type="radio" name="tenant_source" id="source_aucun" value="aucun">
                            <label class="form-check-label d-block w-100" for="source_aucun">
                                <div class="option-box p-2">
                                    <div class="d-flex align-items-center">
                                        <i class="fa-solid fa-circle-minus text-secondary fs-5 me-2"></i>
                                        <div>
                                            <span class="d-block fw-bold small">Masquer simplement</span>
                                            <small class="text-muted" style="font-size: 10px;">Retirer l'annonce du public.</small>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-sm btn-primary px-3" id="submitBtn">Confirmer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- BOUTON AJOUT FIXE -->
    <a href="{{ route('admin.ajouter') }}" class="fab-add" title="Ajouter un nouveau bien">
        <i class="fa-solid fa-plus"></i>
    </a>

    <!-- FOOTER EXACT -->
    <footer class="main-footer">
        <div class="footer-logo">Maison<span>Loc</span></div>
        <p>© 2026 MaisonLoc byGerardKrettos - La référence au Togo.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
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
                        submitBtn.innerHTML = '<i class="fa-brands fa-whatsapp me-1"></i> Inviter';
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
                        const message = encodeURIComponent("Bonjour ! J'ai marqué votre logement comme occupé sur MaisonLoc. Pour suivre vos contrats et quittances en ligne, créez votre compte ici : " + window.location.origin + "/register");
                        window.open(`https://wa.me/${phone}?text=${message}`, '_blank');
                    }
                }
            });

            document.querySelectorAll('.check-securite-resiliation').forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const targetButtonId = this.getAttribute('data-target');
                    const submitButton = document.getElementById(targetButtonId);
                    if (submitButton) {
                        submitButton.disabled = !this.checked;
                    }
                });
            });
        });
    </script>
</body>
</html>