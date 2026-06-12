<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations de Maisons | MaisonLoc</title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* ===================================
           GLOBAL STYLES
        =================================== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Poppins', sans-serif; 
            background: #f8fafc; 
            color: #1e293b;
            overflow-x: hidden; 
        }

        /* ===================================
           HERO SECTION & NAVBAR
        =================================== */
        .hero-rental {
            min-height: 22vh;
            background: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)),
                        url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070');
            background-size: cover;
            background-position: center;
            padding: 20px 5%;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 70px;
            position: relative;
        }

        .logo a { color: white; text-decoration: none; font-size: 26px; font-weight: 700; }
        .logo span { color: #3b82f6; }

        .nav-container { display: flex; align-items: center; gap: 40px; }
        .nav-links a { color: white; text-decoration: none; font-weight: 500; transition: 0.3s; font-size: 15px; }
        .nav-links a:hover { color: #3b82f6; }
        .btn-login { background: rgba(255,255,255,0.15); color: white; text-decoration: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; backdrop-filter: blur(5px); transition: 0.3s; }
        .btn-login:hover { background: white; color: #1e293b; }

        /* Menu Mobile & Animation Croix Stable */
        .menu-toggle { display: none; cursor: pointer; flex-direction: column; gap: 6px; z-index: 110; width: 28px; height: 21px; justify-content: space-between; }
        .menu-toggle .bar { width: 28px; height: 3px; background: white; transition: 0.3s ease-in-out; border-radius: 2px; transform-origin: left center; }
        
        .menu-toggle.active .bar:nth-child(1) { transform: rotate(45deg); position: relative; top: -1px; left: 3px; }
        .menu-toggle.active .bar:nth-child(2) { width: 0%; opacity: 0; }
        .menu-toggle.active .bar:nth-child(3) { transform: rotate(-45deg); position: relative; bottom: -1px; left: 3px; }

        /* Hero Content */
        .hero-content { margin: 20px 0; max-width: 800px; }
        .hero-badge { background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.4); padding: 6px 14px; border-radius: 50px; backdrop-filter: blur(5px); font-size: 13px; display: inline-block; font-weight: 500; }
        .hero-content h1 { font-size: clamp(28px, 4.5vw, 46px); line-height: 1.2; margin-top: 15px; font-weight: 800; letter-spacing: -1px; }
        .hero-content p { margin-top: 10px; font-size: clamp(15px, 1.8vw, 17px); color: #cbd5e1; }

        /* Search Form (Haut) */
        .search-container {
            margin-top: 30px;
            background: white;
            border-radius: 14px;
            padding: 8px;
            display: flex;
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        }

        .search-item {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 18px;
            border-right: 1px solid #e2e8f0;
        }

        .search-item:last-of-type { border-right: none; }
        .search-item i { color: #3b82f6; font-size: 16px; }
        .search-item select, .search-item input { border: none; outline: none; width: 100%; font-size: 14px; background: transparent; cursor: pointer; color: #475569; font-weight: 500; }

        .search-btn {
            background: #3b82f6; color: white; border: none; padding: 12px 28px; border-radius: 10px; cursor: pointer; font-weight: 600; transition: 0.2s;
        }
        .search-btn:hover { background: #2563eb; }

        /* ===================================
           BARRE INTELLIGENTE STYLE IA
        =================================== */
        .smart-search-container {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border-radius: 14px;
            padding: 10px 12px 10px 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            max-width: 850px;
            margin: 30px auto 40px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
            gap: 10px;
        }

        .smart-search-container:focus-within {
            box-shadow: 0 4px 25px rgba(59, 130, 246, 0.15);
            border-color: #3b82f6;
        }

        .search-field-wrapper { display: flex; align-items: center; flex: 1; gap: 12px; }
        .search-field-wrapper .search-icon { color: #3b82f6; font-size: 1.2rem; }
        #smart-search-input { width: 100%; border: none; outline: none; font-size: 1rem; color: #1e293b; background: transparent; }
        #smart-search-input::placeholder { color: #94a3b8; }

        .smart-search-btn {
            display: flex; align-items: center; gap: 8px; background-color: #3b82f6; color: #ffffff;
            border: none; padding: 12px 26px; border-radius: 10px; font-size: 0.95rem; font-weight: 600;
            cursor: pointer; transition: 0.2s; white-space: nowrap;
        }
        .smart-search-btn:hover { background-color: #2563eb; }

        .btn-trigger-modal {
            display: flex; align-items: center; gap: 6px;
            background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;
            padding: 12px 18px; border-radius: 10px; font-weight: 600; transition: 0.2s; cursor: pointer;
            white-space: nowrap;
        }
        .btn-trigger-modal:hover { background-color: #e2e8f0; color: #0f172a; }

        /* ===================================
           HOUSES SECTION
        =================================== */
        .houses-section {
            padding: 0 4% 40px;
            max-width: 1440px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 35px;
            color: #0f172a;
            position: relative;
            padding-left: 15px;
        }
        .section-title span { color: #3b82f6; }
        .section-title::before {
            content: ''; position: absolute; left: 0; top: 15%; height: 70%; width: 4px; background: #3b82f6; border-radius: 4px;
        }

        .house-card-link { 
            text-decoration: none; 
            color: inherit; 
            display: block;
            height: 100%;
        }

        .house-card {
            background: white;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid #e2e8f0;
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
            .image-container { height: 180px; }
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }
        .house-card:hover .image-container img { transform: scale(1.04); }

        .card-body-content {
            padding: 12px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }
        
        @media(min-width: 576px) {
            .card-body-content { padding: 15px; }
        }

        .house-title {
            font-size: 14px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        @media(min-width: 576px) {
            .house-title { font-size: 15px; }
        }

        .house-location {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        @media(min-width: 576px) {
            .house-location { font-size: 13px; }
        }

        .price-tag {
            font-size: 14px;
            font-weight: 700;
            color: #2563eb;
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            flex-wrap: wrap;
        }
        
        @media(min-width: 576px) {
            .price-tag { font-size: 15px; }
        }
        .price-tag span { font-size: 11px; color: #64748b; font-weight: 400; }

        .view-btn {
            margin-top: 12px;
            background: #f1f5f9;
            color: #1e293b;
            border: none;
            padding: 8px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            text-align: center;
            transition: 0.2s;
        }
        @media(min-width: 576px) {
            .view-btn { font-size: 13px; }
        }
        .house-card:hover .view-btn { background: #3b82f6; color: white; }

        .house-card.rented { position: relative; opacity: 0.65; }
        .rented-badge {
            position: absolute; top: 12px; right: 12px; background: #ef4444; color: white;
            padding: 4px 10px; border-radius: 6px; font-weight: 700; font-size: 11px; z-index: 10;
        }

        .modal-filter-checkboxes .form-check { margin-bottom: 8px; }
        .modal-filter-checkboxes .form-check-input:checked { background-color: #3b82f6; border-color: #3b82f6; }

        /* ===================================
           FOOTER
        =================================== */
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

        /* ===================================
           RESPONSIVE REPAIRS ULTRA-COMPACT MOBILE
        =================================== */
        @media (max-width: 992px) {
            .menu-toggle { display: flex; position: absolute; top: 25px; right: 5%; }
            .nav-container {
                position: fixed; top: 0; right: -100%; height: 100vh; width: 260px;
                background: #0f172a; flex-direction: column; padding: 100px 30px;
                transition: 0.4s; box-shadow: -10px 0 30px rgba(0,0,0,0.3); z-index: 100;
            }
            .nav-container.active { right: 0; }
            .nav-links { flex-direction: column; gap: 25px; width: 100%; }
            .btn-login { text-align: center; width: 100%; margin-top: 20px; }
            
            /* FORMULAIRE HERO CONCENTRÉ (2 COLONNES SUR MOBILE) */
            .search-container { 
                display: flex;
                flex-direction: row; 
                flex-wrap: wrap; 
                padding: 4px; 
                margin-top: 15px; 
                gap: 0;
            }
            .search-item { 
                flex: 0 0 50%;
                width: 50%;
                border-right: 1px solid #f1f5f9; 
                border-bottom: none; 
                padding: 6px 8px;
                gap: 5px;
            }
            .search-item:nth-child(2) { border-right: none; }
            .search-item i { font-size: 12px; }
            .search-item select { font-size: 12px; padding: 2px 0; }
            
            .search-btn { 
                flex: 0 0 100%;
                width: 100%; 
                margin-top: 4px; 
                padding: 8px 15px; 
                font-size: 13px; 
                border-radius: 8px;
            }
            
            /* BARRE IA COMPACTE */
            .smart-search-container { flex-direction: column; align-items: stretch; padding: 8px; gap: 6px; margin: 25px auto; }
            .search-field-wrapper { gap: 8px; }
            #smart-search-input { font-size: 0.9rem; }
            .smart-search-btn { padding: 8px 16px; font-size: 0.85rem; justify-content: center; }
            .btn-trigger-modal { width: 100%; text-align: center; justify-content: center; padding: 8px; font-size: 0.85rem; }

            /* MODAL FILTRES AVANCÉS PLUS PETIT SUR MOBILE */
            .modal-dialog { margin: 10px; }
            .modal-body { padding: 14px !important; }
            .modal-header, .modal-footer { padding: 10px 14px !important; }
            .modal-body .row.g-3 { --bs-gutter-y: 0.6rem; --bs-gutter-x: 0.6rem; }
            .form-label { margin-bottom: 2px; font-size: 11px !important; }
            .form-select, .form-control { padding: 6px 10px; font-size: 13px; }
            .modal-filter-checkboxes .form-check { margin-bottom: 6px; }
            .modal-filter-checkboxes .form-check-label { font-size: 12.5px; }
        }
    </style>
</head>
<body>

<section class="hero-rental">
    <header class="navbar">
        <div class="logo">
            <a href="{{ url('/') }}">Maison<span>Loc</span></a>
        </div>
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span><span class="bar"></span><span class="bar"></span>
        </div>
        <nav class="nav-container">
            <div class="nav-links">
                <a href="#maisons"><i class="fa-solid fa-house-chimney me-2"></i>Maisons disponibles</a>
            </div>
            <a href="{{ url('/') }}" class="btn-login">Accueil</a>
        </nav>
    </header>

    <div class="hero-content">
        <span class="hero-badge">🏡 Trouvez votre logement idéal</span>
        <h1>Louez la maison de vos rêves en toute simplicité</h1>
        <p>Explorez les meilleures options de logements disponibles dans la catégorie sélectionnée.</p>

        <form id="filter-form" class="search-container" onsubmit="event.preventDefault(); triggerFilter();">
            <div class="search-item">
                <i class="fa-solid fa-location-dot"></i>
                <select id="search-ville" name="ville">
                    <option value="">Villes...</option>
                    @foreach($maisons->unique('ville')->sortBy('ville') as $maison)
                        @if($maison->ville) 
                            <option value="{{ strtolower($maison->ville) }}">{{ $maison->ville }}</option> 
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="search-item">
                <i class="fa-solid fa-map-pin"></i>
                <select id="search-quartier" name="quartier">
                    <option value="">Quartiers...</option>
                    @foreach($maisons->unique('adresse')->sortBy('adresse') as $maison)
                        @if($maison->adresse) 
                            <option value="{{ strtolower($maison->adresse) }}" data-ville="{{ strtolower($maison->ville) }}">
                                {{ $maison->adresse }}
                            </option> 
                        @endif
                    @endforeach
                </select>
            </div>

            <button type="submit" class="search-btn">
                <i class="fa-solid fa-magnifying-glass me-2"></i>Rechercher
            </button>
        </form>
    </div>
</section>

<section class="houses-section" id="maisons">

    <div class="smart-search-container">
        <form id="smart-filter-form" class="search-field-wrapper" onsubmit="event.preventDefault(); triggerFilter();">
            <i class="fa-solid fa-brain search-icon"></i> 
            <input type="text" name="query" id="smart-search-input" placeholder="Ex : Maison meublée à moins de 150k..." autocomplete="off">
            <button type="submit" class="smart-search-btn">
                <i class="fa-solid fa-magnifying-glass"></i>
                <span>Analyser</span>
            </button>
        </form>
        <button class="btn-trigger-modal" data-bs-toggle="modal" data-bs-target="#advancedFilterModal">
            <i class="fa-solid fa-sliders me-1"></i> Filtres avancés
        </button>
    </div>

    <div class="modal fade" id="advancedFilterModal" tabindex="-1" aria-labelledby="advancedFilterModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);">
          <div class="modal-header" style="border-bottom: 1px solid #f1f5f9;">
            <h6 class="modal-title fw-bold" id="advancedFilterModalLabel"><i class="fa-solid fa-sliders text-primary me-2"></i>Filtres avancés</h6>
            <button type="button" class="btn-close" data-bs-shadow="none" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row g-2 mb-3">
                <div class="col-6 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Ville</label>
                    <select id="modal-search-ville" class="form-select" style="border-radius: 6px;">
                        <option value="">Toutes...</option>
                        @foreach($maisons->unique('ville')->sortBy('ville') as $maison)
                            @if($maison->ville) 
                                <option value="{{ strtolower($maison->ville) }}">{{ $maison->ville }}</option> 
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Quartier</label>
                    <select id="modal-search-quartier" class="form-select" style="border-radius: 6px;">
                        <option value="">Tous...</option>
                        @foreach($maisons->unique('adresse')->sortBy('adresse') as $maison)
                            @if($maison->adresse) 
                                <option value="{{ strtolower($maison->adresse) }}" data-ville="{{ strtolower($maison->ville) }}">
                                    {{ $maison->adresse }}
                                </option> 
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Budget Min (FCFA)</label>
                    <input type="number" id="modal-price-min" class="form-control" placeholder="Ex: 50000" style="border-radius: 6px;">
                </div>
                <div class="col-6 col-md-6">
                    <label class="form-label fw-semibold small text-uppercase text-muted">Budget Max (FCFA)</label>
                    <input type="number" id="modal-price-max" class="form-control" placeholder="Ex: 200000" style="border-radius: 6px;">
                </div>
            </div>

            <hr style="color: #e2e8f0; margin: 10px 0;">

            <label class="form-label fw-semibold small text-uppercase text-muted mb-2 d-block">Commodités</label>
            <div class="row modal-filter-checkboxes">
                <div class="col-6 col-md-6">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="modal-opt-meuble">
                      <label class="form-check-label fw-medium ms-1" for="modal-opt-meuble">✨ Meublé</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="modal-opt-climatise">
                      <label class="form-check-label fw-medium ms-1" for="modal-opt-climatise">❄️ Climatisé</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="modal-opt-sanitaire">
                      <label class="form-check-label fw-medium ms-1" for="modal-opt-sanitaire">🚽 Sanitaire</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="modal-opt-etage">
                      <label class="form-check-label fw-medium ms-1" for="modal-opt-etage">🏢 En Étage</label>
                    </div>
                </div>
                <div class="col-6 col-md-6">
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="modal-opt-pmr">
                      <label class="form-check-label fw-medium ms-1" for="modal-opt-pmr">♿ Accès PMR</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="modal-opt-elec">
                      <label class="form-check-label fw-medium ms-1" for="modal-opt-elec">⚡ Compteur Élec</label>
                    </div>
                    <div class="form-check form-switch">
                      <input class="form-check-input" type="checkbox" id="modal-opt-eau">
                      <label class="form-check-label fw-medium ms-1" for="modal-opt-eau">🚰 Compteur Eau</label>
                    </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-light text-secondary" id="btn-reset-modal" style="border-radius: 6px;">Effacer</button>
            <button type="button" class="btn btn-sm btn-primary fw-semibold" data-bs-dismiss="modal" onclick="triggerFilter();" style="background-color: #3b82f6; border: none; padding: 6px 16px; border-radius: 6px;">Filtrer</button>
          </div>
        </div>
      </div>
    </div>

    <h2 class="section-title">Résultats de votre recherche dans la catégorie <span>{{ $Rcategory->nom }}</span></h2>

    <div id="no-results-message" class="alert text-center py-4 d-none" style="border-radius: 12px; background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; margin-bottom: 30px;">
        <i class="fa-solid fa-house-circle-exclamation fs-3 mb-2 d-block"></i>
        Aucune maison ne correspond à vos critères.
    </div>
    
    <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3 g-sm-4" id="houses-container">
        @foreach($maisons as $maison)
            @php $isRented = ($maison->est_loue == 1); @endphp
            <div class="col house-item" 
                 data-ville="{{ strtolower($maison->ville) }}" 
                 data-quartier="{{ strtolower($maison->adresse) }}"
                 data-etage="{{ $maison->immeuble_etage ?? 0 }}"
                 data-meuble="{{ $maison->meuble ?? 0 }}"
                 data-climatise="{{ $maison->climatise ?? 0 }}"
                 data-sanitaire="{{ $maison->sanitaire ?? 0 }}"
                 data-pmr="{{ $maison->adapte_pmr ?? 0 }}"
                 data-elec-perso="{{ $maison->compteur_elec_perso ?? 0 }}"
                 data-eau-perso="{{ $maison->compteur_eau_perso ?? 0 }}">
                 
                <a href="{{ route('maisons.infoA', $maison->id) }}" class="house-card-link">
                    <div class="house-card {{ $isRented ? 'rented' : '' }}">
                        @if($isRented) <div class="rented-badge">LOUÉ</div> @endif
                        <div class="image-container">
                            <img src="{{ asset($maison->image) }}" alt="{{ $maison->titre ?? 'Maison' }}">
                        </div>
                        <div class="card-body-content">
                            <h3 class="house-title">{{ $maison->titre ?? 'Maison Moderne' }}</h3>
                            <div class="house-location">
                                <i class="fa-solid fa-location-dot text-danger"></i>
                                <span>{{ $maison->ville }} • {{ $maison->adresse }}</span>
                            </div>
                            <div class="price-tag">
                                {{ number_format($maison->prix, 0, ',', ' ') }} FCFA <span>/ mois</span>
                            </div>
                            <button class="view-btn">{{ $isRented ? 'Voir détails' : 'Voir la maison' }}</button>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <button id="voir-plus-btn" class="btn btn-primary" style="padding: 12px 35px; border-radius: 8px; background-color: #3b82f6; border: none; font-weight: 600;">
            Voir plus de maisons
        </button>
    </div>
</section>

<footer class="main-footer">
    <div class="footer-logo">Maison<span>Loc</span></div>
    <p>© 2026 MaisonLoc byGerardKrettos - La référence au Togo.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const mobileMenu = document.getElementById('mobile-menu');
    const navContainer = document.querySelector('.nav-container');
    
    if(mobileMenu && navContainer) {
        // Toggle du menu au clic sur l'icône (ajoute la classe active)
        mobileMenu.addEventListener('click', (e) => {
            e.stopPropagation();
            mobileMenu.classList.toggle('active');
            navContainer.classList.toggle('active');
        });

        // Fermeture automatique si on clique n'importe où dans le vide
        document.addEventListener('click', (e) => {
            if (!navContainer.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.remove('active');
                navContainer.classList.remove('active');
            }
        });
    }

    const selectVilleHero = document.getElementById('search-ville');
    const selectQuartierHero = document.getElementById('search-quartier');
    const selectVilleModal = document.getElementById('modal-search-ville');
    const selectQuartierModal = document.getElementById('modal-search-quartier');
    
    const optionsQuartierHero = Array.from(selectQuartierHero.options).slice(1);
    const optionsQuartierModal = Array.from(selectQuartierModal.options).slice(1);

    function updateQuartierOptions(villeSelectionnee, selectQuartier, optionsList) {
        selectQuartier.value = ""; 
        optionsList.forEach(option => {
            option.style.display = (villeSelectionnee === "" || option.getAttribute('data-ville') === villeSelectionnee) ? "block" : "none";
        });
    }

    selectVilleHero.addEventListener('change', function () {
        selectVilleModal.value = this.value;
        updateQuartierOptions(this.value, selectQuartierHero, optionsQuartierHero);
        updateQuartierOptions(this.value, selectQuartierModal, optionsQuartierModal);
    });

    selectVilleModal.addEventListener('change', function () {
        selectVilleHero.value = this.value;
        updateQuartierOptions(this.value, selectQuartierHero, optionsQuartierHero);
        updateQuartierOptions(this.value, selectQuartierModal, optionsQuartierModal);
    });

    selectQuartierHero.addEventListener('change', function() { selectQuartierModal.value = this.value; });
    selectQuartierModal.addEventListener('change', function() { selectQuartierHero.value = this.value; });

    const itemsParPage = 8; 
    let maisonsVisiblesActuellement = itemsParPage;
    let maisonsFiltrees = [];

    const cards = Array.from(document.querySelectorAll('#houses-container .house-item'));
    const btnVoirPlus = document.getElementById('voir-plus-btn');
    const noResultsMessage = document.getElementById('no-results-message');
    const smartSearchInput = document.getElementById('smart-search-input');

    const priceMinInput = document.getElementById('modal-price-min');
    const priceMaxInput = document.getElementById('modal-price-max');
    const checkMeuble = document.getElementById('modal-opt-meuble');
    const checkClimatise = document.getElementById('modal-opt-climatise');
    const checkSanitaire = document.getElementById('modal-opt-sanitaire');
    const checkEtage = document.getElementById('modal-opt-etage');
    const checkPmr = document.getElementById('modal-opt-pmr');
    const checkElec = document.getElementById('modal-opt-elec');
    const checkEau = document.getElementById('modal-opt-eau');
    const btnResetModal = document.getElementById('btn-reset-modal');

    if(btnResetModal) {
        btnResetModal.addEventListener('click', function() {
            selectVilleHero.value = "";
            selectVilleModal.value = "";
            selectQuartierHero.value = "";
            selectQuartierModal.value = "";
            priceMinInput.value = "";
            priceMaxInput.value = "";
            [checkMeuble, checkClimatise, checkSanitaire, checkEtage, checkPmr, checkElec, checkEau].forEach(cb => {
                if(cb) cb.checked = false;
            });
            updateQuartierOptions("", selectQuartierHero, optionsQuartierHero);
            updateQuartierOptions("", selectQuartierModal, optionsQuartierModal);
            triggerFilter();
        });
    }

    const chiffresLettres = { "une": 1, "un": 1, "deux": 2, "trois": 3, "quatre": 4, "cinq": 5 };

    window.triggerFilter = function() {
        const villeValue = selectVilleHero.value.trim().toLowerCase();
        const quartierValue = selectQuartierHero.value.trim().toLowerCase();
        const smartPhrase = smartSearchInput.value.trim().toLowerCase();

        const inputPriceMin = priceMinInput.value ? parseInt(priceMinInput.value) : null;
        const inputPriceMax = priceMaxInput.value ? parseInt(priceMaxInput.value) : null;

        let nombreChambresRecherche = null;
        let budgetMaxRecherche = null;
        let motsClesPhrase = [];
        
        let requiertMeuble = smartPhrase.includes("meuble") || (checkMeuble && checkMeuble.checked);
        let requiertClime = smartPhrase.includes("climatis") || smartPhrase.includes("clime") || (checkClimatise && checkClimatise.checked);
        let requiertSanitaire = smartPhrase.includes("sanitaire") || (checkSanitaire && checkSanitaire.checked);
        let requiertEtage = smartPhrase.includes("etage") || smartPhrase.includes("étage") || (checkEtage && checkEtage.checked);
        let requiertPmr = smartPhrase.includes("pmr") || smartPhrase.includes("handicap") || (checkPmr && checkPmr.checked);
        let requiertElec = smartPhrase.includes("compteur personnel") || smartPhrase.includes("elec") || (checkElec && checkElec.checked);
        let requiertEau = smartPhrase.includes("forage") || smartPhrase.includes("eau") || (checkEau && checkEau.checked);

        if (smartPhrase !== "") {
            const regexChambre = /(?:(\d+)|(un|une|deux|trois|quatre|cinq))\s*chambre/i;
            const matchChambre = smartPhrase.match(regexChambre);
            if (matchChambre) {
                if (matchChambre[1]) nombreChambresRecherche = parseInt(matchChambre[1]);
                else if (matchChambre[2]) nombreChambresRecherche = chiffresLettres[matchChambre[2].toLowerCase()];
            }

            let phraseNettoyeePourPrix = smartPhrase.replace(/(\d+)\s*k\b/g, (m, p1) => p1 + "000");
            const regexBudget = /(?:moins de|maximum|max|budget de|à|de)\s*(\d+)/i;
            const matchBudget = phraseNettoyeePourPrix.match(regexBudget);
            if (matchBudget) { budgetMaxRecherche = parseInt(matchBudget[1]); }

            const motsAIgnorer = [
                "veux", "je", "recherche", "cherche", "maison", "une", "des", "pour", "dans", "avec", 
                "chambre", "chambres", "salon", "salons", "le", "la", "les", "un", "de", "à", "au", 
                "moins", "budget", "max", "maximum", "f", "fcfa", "mois", "prix", "meuble", "meublé", 
                "meublee", "climatise", "climatisé", "climatisée", "sanitaire", "etage", "étage"
            ];
            motsClesPhrase = smartPhrase.split(/[\s,'.]+/).filter(mot => mot.length > 2 && !motsAIgnorer.includes(mot));
        }

        maisonsFiltrees = cards.filter(card => {
            const cardVille = (card.getAttribute('data-ville') || "").toLowerCase();
            const cardQuartier = (card.getAttribute('data-quartier') || "").toLowerCase();
            const cardTitre = card.querySelector('.house-title').innerText.toLowerCase();
            const cardContenuGlobal = card.innerText.toLowerCase();

            const optionMeuble = card.getAttribute('data-meuble') === "1";
            const optionClime = card.getAttribute('data-climatise') === "1";
            const optionSanitaire = card.getAttribute('data-sanitaire') === "1";
            const optionEtage = parseInt(card.getAttribute('data-etage')) > 0;
            const optionPmr = card.getAttribute('data-pmr') === "1";
            const optionElec = card.getAttribute('data-elec-perso') === "1";
            const optionEau = card.getAttribute('data-eau-perso') === "1";

            const priceText = card.querySelector('.price-tag').innerText.replace(/[^\d]/g, '');
            const cardPrix = parseInt(priceText) || 0;

            if (villeValue !== "" && cardVille !== villeValue) return false;
            if (quartierValue !== "" && cardQuartier !== quartierValue) return false;
            if (inputPriceMin !== null && cardPrix < inputPriceMin) return false;
            if (inputPriceMax !== null && cardPrix > inputPriceMax) return false;

            if (requiertMeuble && !optionMeuble) return false;
            if (requiertClime && !optionClime) return false;
            if (requiertSanitaire && !optionSanitaire) return false;
            if (requiertEtage && !optionEtage) return false;
            if (requiertPmr && !optionPmr) return false;
            if (requiertElec && !optionElec) return false;
            if (requiertEau && !optionEau) return false;

            if (smartPhrase !== "") {
                if (nombreChambresRecherche !== null) {
                    const regexCardChambre = new RegExp(`(${nombreChambresRecherche}|${Object.keys(chiffresLettres).find(key => chiffresLettres[key] === nombreChambresRecherche) || '___' })\\s*chambre`, 'i');
                    if (!regexCardChambre.test(cardTitre) && !regexCardChambre.test(cardContenuGlobal)) return false;
                }
                if (budgetMaxRecherche !== null && cardPrix > budgetMaxRecherche) return false;
                if (motsClesPhrase.length > 0) {
                    const matchMotCle = motsClesPhrase.some(mot => cardVille.includes(mot) || cardQuartier.includes(mot) || cardTitre.includes(mot));
                    if (!matchMotCle) return false;
                }
            }
            return true;
        });

        if (maisonsFiltrees.length === 0) {
            noResultsMessage.classList.remove('d-none');
            btnVoirPlus.style.display = 'none';
            cards.forEach(c => c.style.display = 'none');
            return;
        } else {
            noResultsMessage.classList.add('d-none');
        }

        maisonsVisiblesActuellement = itemsParPage;
        renderGrid();
    };

    function renderGrid() {
        cards.forEach(c => c.style.display = 'none');
        const aAfficher = maisonsFiltrees.slice(0, maisonsVisiblesActuellement);
        aAfficher.forEach(c => c.style.display = 'block');
        btnVoirPlus.style.display = (maisonsVisiblesActuellement >= maisonsFiltrees.length) ? 'none' : 'inline-block';
    }

    btnVoirPlus.addEventListener('click', function() {
        maisonsVisiblesActuellement += itemsParPage;
        renderGrid();
    });

    triggerFilter();
});
</script>
</body>
</html>