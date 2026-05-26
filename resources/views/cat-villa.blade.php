), on utilise des expressions régulières (RegEx). Le script va "décortiquer" la phrase de l'utilisateur pour y extraire les mots-clés importants (chiffres + chambres, noms de villes, de quartiers).

Voici le code complet mis à jour. J'ai modifié le script pour qu'il analyse intelligemment la phrase saisie.

Le Code Complet Mis à Jour
HTML
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
            min-height: 20vh;
            background: linear-gradient(rgba(15, 23, 42, 0.6), rgba(15, 23, 42, 0.6)),
                        url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070');
            background-size: cover;
            background-position: center;
            padding: 20px 5%;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-bottom: 3px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }

        .logo a { color: white; text-decoration: none; font-size: 28px; font-weight: 700; }
        .logo span { color: #3b82f6; }

        .nav-container { display: flex; align-items: center; gap: 40px; }
        .nav-links a { color: white; text-decoration: none; font-weight: 500; transition: 0.3s; font-size: 15px; }
        .nav-links a:hover { color: #3b82f6; }
        .btn-login { background: rgba(255,255,255,0.15); color: white; text-decoration: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; backdrop-filter: blur(5px); transition: 0.3s; }
        .btn-login:hover { background: white; color: #1e293b; }

        /* Menu Mobile */
        .menu-toggle { display: none; cursor: pointer; flex-direction: column; gap: 6px; z-index: 110; }
        .menu-toggle .bar { width: 28px; height: 3px; background: white; transition: 0.3s; border-radius: 2px; }

        /* Hero Content */
        .hero-content { margin: auto 0; max-width: 800px; }
        .hero-badge { background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.4); padding: 8px 16px; border-radius: 50px; backdrop-filter: blur(5px); font-size: 14px; display: inline-block; font-weight: 500; }
        .hero-content h1 { font-size: clamp(32px, 5vw, 52px); line-height: 1.2; margin-top: 20px; font-weight: 800; letter-spacing: -1px; }
        .hero-content p { margin-top: 15px; font-size: clamp(16px, 2vw, 18px); color: #cbd5e1; }

        /* Search Form */
        .search-container {
            margin-top: 40px;
            background: white;
            border-radius: 16px;
            padding: 10px;
            display: flex;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .search-item {
            flex: 1;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            border-right: 1px solid #e2e8f0;
        }

        .search-item:last-of-type { border-right: none; }
        .search-item i { color: #3b82f6; font-size: 18px; }
        .search-item select { border: none; outline: none; width: 100%; font-size: 15px; background: transparent; cursor: pointer; color: #475569; font-weight: 500; }

        .search-btn {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 14px 32px;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 600;
            transition: 0.3s;
        }
        .search-btn:hover { background: #2563eb; }

        /* ===================================
           HOUSES SECTION (GRID MODERNE)
        =================================== */
        .houses-section {
            padding: 20px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .section-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 40px;
            color: #0f172a;
            position: relative;
            padding-left: 15px;
        }
        .section-title::before {
            content: '';
            position: absolute;
            left: 0; top: 15%; height: 70%; width: 5px;
            background: #3b82f6;
            border-radius: 4px;
        }

        .houses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
        }

        .house-card-link {
            text-decoration: none;
            color: inherit;
        }

        .house-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            height: 100%;
            border: 1px solid #f1f5f9;
        }

        .house-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04);
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 220px;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .house-card:hover .image-container img {
            transform: scale(1.05);
        }

        .card-body-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .house-title {
            font-size: 18px;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .house-location {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .price-tag {
            font-size: 18px;
            font-weight: 700;
            color: #2563eb;
            margin-top: auto;
            padding-top: 15px;
            border-top: 1px solid #f1f5f9;
            display: flex;
            align-items: baseline;
            justify-content: space-between;
        }
        .price-tag span { font-size: 13px; color: #64748b; font-weight: 400; }

        .view-btn {
            margin-top: 15px;
            background: #f1f5f9;
            color: #1e293b;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            text-align: center;
            transition: 0.2s;
        }
        .house-card:hover .view-btn {
            background: #3b82f6;
            color: white;
        }

        /* ===================================
           FOOTER
        =================================== */
        .main-footer {
            background: #0f172a;
            color: #94a3b8;
            padding: 80px 5% 30px;
            margin-top: 80px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto 60px;
        }

        .footer-logo { font-size: 26px; font-weight: 800; color: white; margin-bottom: 20px; }
        .footer-logo span { color: #3b82f6; }
        .about-col p { line-height: 1.6; font-size: 14px; }

        .footer-col h4 {
            color: white; font-size: 16px; font-weight: 600; margin-bottom: 20px; position: relative;
        }
        .footer-col h4::after {
            content: ''; position: absolute; left: 0; bottom: -6px; width: 24px; height: 2px; background: #3b82f6;
        }

        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 12px; }
        .footer-links a { color: #94a3b8; text-decoration: none; transition: 0.3s; font-size: 14px; }
        .footer-links a:hover { color: white; padding-left: 4px; }

        /* ===================================
           RESPONSIVE DESIGN
        =================================== */
        @media (max-width: 992px) {
            .menu-toggle { display: flex; position: absolute; top: 40px; right: 5%; }
            .nav-container {
                position: fixed; top: 0; right: -100%; height: 100vh; width: 280px;
                background: #0f172a; flex-direction: column; padding: 100px 30px;
                transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: -10px 0 30px rgba(0,0,0,0.3); z-index: 100;
            }
            .nav-container.active { right: 0; }
            .nav-links { flex-direction: column; gap: 25px; width: 100%; }
            .btn-login { text-align: center; width: 100%; margin-top: 20px; }
            .search-container { flex-direction: column; padding: 15px; }
            .search-item { border-right: none; border-bottom: 1px solid #e2e8f0; width: 100%; padding: 15px 5px; }
            .search-btn { width: 100%; margin-top: 15px; padding: 14px; }
        }

        /* Responsive Grids */
        @media (max-width: 600px) {
            .houses-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)) !important;
                gap: 15px !important;
            }
            .house-card { font-size: 0.9em; transform: scale(1); }
            .image-container { height: 150px !important; }
        }

        /* Style pour les maisons louées */
        .house-card.rented {
            position: relative;
            opacity: 0.8;
            filter: grayscale(0.5);
        }
        .rented-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: #ef4444;
            color: white;
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 12px;
            z-index: 10;
        }

        /* Style pour la barre de recherche intelligente */
        .smart-search-container {
            display: flex;
            align-items: center;
            background-color: #ffffff;
            border-radius: 50px;
            padding: 6px 8px 6px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            max-width: 800px;
            margin: 20px auto 40px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .smart-search-container:focus-within {
            box-shadow: 0 4px 20px rgba(0, 102, 255, 0.15);
            border-color: #3b82f6;
        }

        .search-field-wrapper {
            display: flex;
            align-items: center;
            flex: 1;
            gap: 12px;
        }

        .search-field-wrapper .search-icon {
            color: #3b82f6;
            font-size: 1.1rem;
        }

        #smart-search-input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 1rem;
            color: #1e293b;
            background: transparent;
        }

        #smart-search-input::placeholder {
            color: #94a3b8;
        }

        .smart-search-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #3b82f6;
            color: #ffffff;
            border: none;
            padding: 12px 28px;
            border-radius: 40px;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
        }

        .smart-search-btn:hover { background-color: #2563eb; }
        .smart-search-btn:active { transform: scale(0.98); }

        @media (max-width: 600px) {
            .smart-search-container {
                flex-direction: column;
                border-radius: 16px;
                padding: 12px;
                gap: 12px;
            }
            .search-field-wrapper { width: 100%; padding: 4px 8px; }
            .smart-search-btn { width: 100%; justify-content: center; border-radius: 12px; }
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
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <nav class="nav-container">
            <div class="nav-links">
                <a href="#maisons"><i class="fa-solid fa-house-chimney me-2"></i>Maisons disponibles</a>
            </div>
            <div class="nav-buttons">
                <a href="{{ url('/') }}" class="btn-login">Accueil</a>
            </div>
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
                    <option value="">Toutes les villes...</option>
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
                    <option value="">Tous les quartiers...</option>
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

    <form id="smart-filter-form" class="smart-search-container" onsubmit="event.preventDefault(); triggerFilter();">
        <div class="search-field-wrapper">
            <i class="fa-solid fa-brain search-icon"></i> 
            <input 
                type="text" 
                name="query" 
                id="smart-search-input" 
                placeholder="Ex : Je veux une maison de 2 chambres à Agoè..." 
                autocomplete="off"
            >
        </div>
        <button type="submit" class="smart-search-btn">
            <i class="fa-solid fa-magnifying-glass"></i>
            <span>Analyser</span>
        </button>
    </form>

    <h2 class="section-title">Résultats de votre recherche dans la catégorie <span>{{ $Rcategory->nom }}</span></h2>

    <div id="no-results-message" class="alert text-center py-4 d-none" style="border-radius: 12px; background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; margin-bottom: 30px;">
        <i class="fa-solid fa-house-circle-exclamation fs-3 mb-2 d-block"></i>
        Aucune maison ne correspond à vos critères de recherche. Essayez de reformuler (ex: "2 chambres", "Agoè").
    </div>
    
    <div class="houses-grid" id="houses-container">
        @foreach($maisons as $maison)
            @php $isRented = ($maison->est_loue == 1); @endphp
            
            <a href="/maison/{{ $maison->id }}/infoA" class="house-card-link" data-ville="{{ strtolower($maison->ville) }}" data-quartier="{{ strtolower($maison->adresse) }}">
                <div class="house-card {{ $isRented ? 'rented' : '' }}">
                    @if($isRented)
                        <div class="rented-badge">LOUÉ</div>
                    @endif
                    
                    <div class="image-container">
                        <img src="{{ asset('storage/' . $maison->image) }}" alt="{{ $maison->titre ?? 'Maison' }}">
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
        @endforeach
    </div>

    <div class="text-center mt-5">
        <button id="voir-plus-btn" class="btn btn-primary" style="padding: 12px 30px; border-radius: 8px; background-color: #3b82f6; border: none; font-weight: 600;">
            Voir plus de maisons
        </button>
    </div>
</section>

<footer class="main-footer">
    <div class="footer-grid">
        <div class="footer-col about-col">
            <div class="footer-logo">Maison<span>Loc</span></div>
            <p>La plateforme de référence pour la location immobilière au Togo.</p>
        </div>
    </div>
</footer>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Menu mobile toggle
    const mobileMenu = document.getElementById('mobile-menu');
    const navContainer = document.querySelector('.nav-container');
    if(mobileMenu) {
        mobileMenu.addEventListener('click', () => {
            navContainer.classList.toggle('active');
        });
    }

    // Interconnexion classique Ville -> Quartier
    const selectVille = document.getElementById('search-ville');
    const selectQuartier = document.getElementById('search-quartier');
    const optionsQuartier = Array.from(selectQuartier.options).slice(1);

    selectVille.addEventListener('change', function () {
        const villeSelectionnee = this.value;
        selectQuartier.value = ""; 

        optionsQuartier.forEach(option => {
            if (villeSelectionnee === "" || option.getAttribute('data-ville') === villeSelectionnee) {
                option.style.display = "block";
            } else {
                option.style.display = "none";
            }
        });
    });

    // --- LOGIQUE RECHERCHE ET PAGINATION DE 10 EN 10 ---
    const itemsParPage = 10;
    let maisonsVisiblesActuellement = itemsParPage;
    let maisonsFiltrees = [];

    const cards = Array.from(document.querySelectorAll('#houses-container .house-card-link'));
    const btnVoirPlus = document.getElementById('voir-plus-btn');
    const noResultsMessage = document.getElementById('no-results-message');
    const smartSearchInput = document.getElementById('smart-search-input');

    // Dictionnaire des équivalences textuelles pour les chiffres écrits en lettres
    const chiffresLettres = { "une": 1, "un": 1, "deux": 2, "trois": 3, "quatre": 4, "cinq": 5 };

    window.triggerFilter = function() {
        const villeValue = selectVille.value.trim().toLowerCase();
        const quartierValue = selectQuartier.value.trim().toLowerCase();
        const smartPhrase = smartSearchInput.value.trim().toLowerCase();

        // 1. Analyse en Langage Naturel (NLP basique via RegEx) de la phrase intelligente
        let nombreChambresRecherche = null;
        let motsClesPhrase = [];

        if (smartPhrase !== "") {
            // Extraction du nombre de chambres (ex: "2 chambres", "deux chambres", "3chambres")
            // Détecte les formats digitaux (2) ou textuels (deux) suivis du mot chambre
            const regexChambre = /(?:(\d+)|(un|une|deux|trois|quatre|cinq))\s*chambre/i;
            const matchChambre = smartPhrase.match(regexChambre);
            
            if (matchChambre) {
                if (matchChambre[1]) {
                    nombreChambresRecherche = parseInt(matchChambre[1]);
                } else if (matchChambre[2]) {
                    nombreChambresRecherche = chiffresLettres[matchChambre[2].toLowerCase()];
                }
            }

            // Découpage de la phrase en mots-clés uniques de plus de 2 lettres pour la correspondance géographique
            // On ignore les mots vides inutiles
            const motsAIgnorer = ["veux", "maison", "une", "des", "pour", "dans", "avec", "chambre", "chambres", "salon"];
            motsClesPhrase = smartPhrase.split(/[\s,'.]+/).filter(mot => mot.length > 2 && !motsAIgnorer.includes(mot));
        }

        // 2. Filtrage global croisé
        maisonsFiltrees = cards.filter(card => {
            const cardVille = card.getAttribute('data-ville') || "";
            const cardQuartier = card.getAttribute('data-quartier') || "";
            const cardTitre = card.querySelector('.house-title').innerText.toLowerCase();
            const cardContenuGlobal = card.innerText.toLowerCase();

            // --- A. Validation des filtres classiques (Sélecteurs du haut) ---
            if (villeValue !== "" && cardVille !== villeValue) return false;
            if (quartierValue !== "" && cardQuartier !== quartierValue) return false;

            // --- B. Validation de la phrase intelligente ---
            if (smartPhrase !== "") {
                // Si l'utilisateur a demandé un nombre précis de chambres
                if (nombreChambresRecherche !== null) {
                    // On cherche si le titre contient le chiffre exact (ex: "2" ou "deux") relié à chambre
                    const regexCardChambre = new RegExp(`(${nombreChambresRecherche}|${Object.keys(chiffresLettres).find(key => chiffresLettres[key] === nombreChambresRecherche) || '___' })\\s*chambre`, 'i');
                    if (!regexCardChambre.test(cardTitre) && !regexCardChambre.test(cardContenuGlobal)) {
                        return false;
                    }
                }

                // Vérification géographique ou textuelle des autres mots-clés (ex: "agoè", "baguida")
                // Il faut qu'au moins l'un des mots-clés importants saisis se retrouve dans la carte
                if (motsClesPhrase.length > 0) {
                    const matchMotCle = motsClesPhrase.some(mot => 
                        cardVille.includes(mot) || 
                        cardQuartier.includes(mot) || 
                        cardTitre.includes(mot)
                    );
                    if (!matchMotCle) return false;
                }
            }

            return true;
        });

        // 3. Gestion de l'affichage des blocs et états vides
        if (maisonsFiltrees.length === 0) {
            noResultsMessage.classList.remove('d-none');
            btnVoirPlus.style.display = 'none';
            cards.forEach(c => c.style.display = 'none');
            return;
        } else {
            noResultsMessage.classList.add('d-none');
        }

        // Réinitialisation de la pagination au changement de critère
        maisonsVisiblesActuellement = itemsParPage;
        renderGrid();
    };

    // Rendu sélectif basé sur la limite de pagination
    function renderGrid() {
        cards.forEach(c => c.style.display = 'none');

        const aAfficher = maisonsFiltrees.slice(0, maisonsVisiblesActuellement);
        aAfficher.forEach(c => c.style.display = 'block');

        if (maisonsVisiblesActuellement >= maisonsFiltrees.length) {
            btnVoirPlus.style.display = 'none';
        } else {
            btnVoirPlus.style.display = 'inline-block';
        }
    }

    // Gestionnaire du bouton "Voir plus"
    btnVoirPlus.addEventListener('click', function() {
        maisonsVisiblesActuellement += itemsParPage;
        renderGrid();
    });

    // Lancement instantané pendant l'écriture
    smartSearchInput.addEventListener('input', triggerFilter);

    // Initialisation
    triggerFilter();
});
</script>

</body>
</html>