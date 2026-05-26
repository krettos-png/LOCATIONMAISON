<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations de Maisons | MaisonLoc</title>
   
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts (Poppins) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome (Icônes) -->
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

        .newsletter-form { display: flex; gap: 8px; margin-top: 15px; }
        .newsletter-form input { flex: 1; background: #1e293b; border: 1px solid #334155; padding: 10px 14px; border-radius: 8px; color: white; outline: none; font-size: 14px; }
        .newsletter-form button { background: #3b82f6; color: white; border: none; padding: 10px 16px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; font-size: 14px; }
        .newsletter-form button:hover { background: #2563eb; }

        .footer-bottom {
            max-width: 1400px; margin: 0 auto; padding-top: 30px; border-top: 1px solid #334155;
            display: flex; justify-content: space-between; flex-wrap: wrap; gap: 15px; font-size: 13px;
        }
        .footer-legal a { color: #94a3b8; text-decoration: none; margin-left: 20px; }
        .footer-legal a:hover { color: white; }

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

        /* ... votre code existant ... */
    
    /* Réduction de la taille des cartes sur mobile */
    .houses-grid {
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 15px;
    }
    .house-card { transform: scale(0.95); }



    /* ... votre code existant ... */

    /* Ajout pour réduire la taille des maisons sur mobile */
    .houses-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)) !important;
        gap: 15px !important;
    }
    
    .house-card {
        font-size: 0.9em; /* Réduit légèrement la taille du texte interne */
    }
    
    .image-container {
        height: 150px !important; /* Réduit la hauteur de l'image sur mobile */
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






    </style>
</head>
<body>

<!-- HERO SECTION & RECHERCHE -->
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

        <!-- Formulaire de Recherche Filtré Instantanément par JS -->
        <form id="filter-form" class="search-container">
    <!-- Sélecteur de Villes -->
    <div class="search-item">
        <i class="fa-solid fa-location-dot"></i>
        <select id="search-ville" name="ville">
            <option value="">Toutes les villes...</option>
            {{-- unique('ville') permet de ne garder qu'une seule maison par ville --}}
            @foreach($maisons->unique('ville')->sortBy('ville') as $maison)
                @if($maison->ville) 
                    <option value="{{ strtolower($maison->ville) }}">{{ $maison->ville }}</option> 
                @endif
            @endforeach
        </select>
    </div>

    <!-- Sélecteur de Quartiers interconnecté -->
    <div class="search-item">
        <i class="fa-solid fa-map-pin"></i>
        <select id="search-quartier" name="quartier">
            <option value="">Tous les quartiers...</option>
            {{-- unique('adresse') évite d'afficher deux fois le même quartier --}}
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

<!-- SECTION D'AFFICHAGE DES MAISONS -->
<section class="houses-section" id="maisons">

<form id="filter-form" class="smart-search-container">
    <div class="search-field-wrapper">
        <i class="fa-solid fa-brain search-icon"></i> <input 
            type="text" 
            name="query" 
            id="smart-search-input" 
            placeholder="Que recherchez-vous ? (ex: Bureaux avec parking...)" 
            autocomplete="off"
        >
    </div>

    <button type="submit" class="smart-search-btn">
        <i class="fa-solid fa-magnifying-glass"></i>
        <span>Rechercher</span>
    </button>
</form>



<!-- //style pour la barre de recherche intelligente -->

<style>


    /* Container principal de la barre */
.smart-search-container {
    display: flex;
    align-items: center;
    background-color: #ffffff;
    border-radius: 50px; /* Donne l'effet capsule */
    padding: 6px 8px 6px 20px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08); /* Ombre douce */
    max-width: 800px;
    margin: 20px auto;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

/* Effet de focus sur toute la barre quand on clique dedans */
.smart-search-container:focus-within {
    box-shadow: 0 4px 20px rgba(0, 102, 255, 0.15);
    border-color: #3b82f6;
}

/* Wrapper du champ de texte et de son icône */
.search-field-wrapper {
    display: flex;
    align-items: center;
    flex: 1;
    gap: 12px;
}

/* Petite icône décorative à gauche */
.search-field-wrapper .search-icon {
    color: #94a3b8;
    font-size: 1.1rem;
}

/* Le champ de saisie (input) de la barre */
#smart-search-input {
    width: 100%;
    border: none;
    outline: none;
    font-size: 1rem;
    color: #1e293b;
    background: transparent;
}

/* Style du texte d'aide (placeholder) */
#smart-search-input::placeholder {
    color: #94a3b8;
}

/* Le bouton Rechercher (bleu) */
.smart-search-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    background-color: #0066ff; /* Bleu similaire à votre image */
    color: #ffffff;
    border: none;
    padding: 12px 28px;
    border-radius: 40px;
    font-size: 0.95rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s ease, transform 0.1s ease;
}

/* Effet de survol du bouton */
.smart-search-btn:hover {
    background-color: #0052cc;
}

/* Effet de clic sur le bouton */
.smart-search-btn:active {
    transform: scale(0.98);
}

/* --- RESPONSIVE (Pour les écrans de smartphones) --- */
@media (max-width: 600px) {
    .smart-search-container {
        flex-direction: column;
        border-radius: 16px;
        padding: 12px;
        gap: 12px;
    }
    
    .search-field-wrapper {
        width: 100%;
        padding: 4px 8px;
    }
    
    .smart-search-btn {
        width: 100%;
        justify-content: center;
        border-radius: 12px;
    }
}



</style>

    <h2 class="section-title">Résultats de votre recherche dans la catégorie <h1>{{ $Rcategory->nom }}</h1></h2>

    <!-- Message de notification d'absence de résultats -->
    <div id="no-results-message" class="alert text-center py-4 d-none" style="border-radius: 12px; background: #fef2f2; color: #991b1b; border: 1px solid #fca5a5; margin-bottom: 30px;">
        <i class="fa-solid fa-house-circle-exclamation fs-3 mb-2 d-block"></i>
        Aucune maison ne correspond à vos critères de recherche dans cette zone. Affichage de toutes nos offres de départ.
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
    <button id="voir-plus-btn" class="btn btn-primary" style="padding: 12px 30px; border-radius: 8px;">
        Voir plus de maisons
    </button>
</div>
</section>




















<!-- FOOTER -->
<footer class="main-footer">
    <div class="footer-grid">
        <div class="footer-col about-col">
            <div class="footer-logo">Maison<span>Loc</span></div>
            <p>La plateforme de référence pour la location immobilière au Togo. Nous rendons la recherche simple, rapide et sécurisée.</p>
        </div>

        <div class="footer-col">
            <h4>Navigation</h4>
            <ul class="footer-links">
                <li><a href="#">Accueil</a></li>
                <li><a href="#">Explorer les maisons</a></li>
                <li><a href="#">À propos de nous</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Villes populaires</h4>
            <ul class="footer-links">
                <li><a href="#">Locations à Lomé</a></li>
                <li><a href="#">Locations à Kpalimé</a></li>
                <li><a href="#">Locations à Kara</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Restez informé</h4>
            <form class="newsletter-form">
                <input type="email" placeholder="Votre email" required>
                <button type="submit">S'inscrire</button>
            </form>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 MaisonLoc Togo. Tous droits réservés.</p>
        <div class="footer-legal">
            <a href="#">Mentions légales</a>
            <a href="#">Confidentialité</a>
        </div>
    </div>
</footer>

<!-- SCRIPTS JAVASCRIPT GLOBAUX -->
<script>
    // --- MENU INTERACTIF MOBILE ---
    const menuToggle = document.getElementById('mobile-menu');
    const navContainer = document.querySelector('.nav-container');

    menuToggle.addEventListener('click', () => {
        navContainer.classList.toggle('active');
        const bars = document.querySelectorAll('.bar');
        bars[0].style.transform = navContainer.classList.contains('active') ? 'rotate(45deg) translate(5px, 6px)' : 'none';
        bars[1].style.opacity = navContainer.classList.contains('active') ? '0' : '1';
        bars[2].style.transform = navContainer.classList.contains('active') ? 'rotate(-45deg) translate(5px, -6px)' : 'none';
    });

    // --- FILTRAGE DYNAMIQUE & SANS RECHARGEMENT ---
    const filterForm = document.getElementById('filter-form');
    const selectVille = document.getElementById('search-ville');
    const selectQuartier = document.getElementById('search-quartier');
    const houseCards = document.querySelectorAll('.house-card-link');
    const noResultsMessage = document.getElementById('no-results-message');

    filterForm.addEventListener('submit', function(e) {
        e.preventDefault(); // Annule le comportement classique de redirection

        const filterVille = selectVille.value.trim();
        const filterQuartier = selectQuartier.value.trim();

        let countVisible = 0;

        houseCards.forEach(card => {
            const houseVille = card.getAttribute('data-ville');
            const houseQuartier = card.getAttribute('data-quartier');

            // Evaluation des conditions de filtrage
            const matchesVille = filterVille === "" || houseVille.includes(filterVille);
            const matchesQuartier = filterQuartier === "" || houseQuartier.includes(filterQuartier);

            if (matchesVille && matchesQuartier) {
                card.style.display = "block";
                countVisible++;
            } else {
                card.style.display = "none";
            }
        });

        // Gestion du cas où aucune maison ne correspond aux filtres
        if (countVisible === 0) {
            // 1. Réafficher toutes les maisons par défaut
            houseCards.forEach(card => card.style.display = "block");
            // 2. Faire apparaître le message d'erreur
            noResultsMessage.classList.remove('d-none');
            // 3. Réinitialiser la sélection des listes déroulantes
            selectVille.value = "";
            selectQuartier.value = "";
        } else {
            // Masquer le message si un ou plusieurs éléments matchent
            noResultsMessage.classList.add('d-none');
        }
    });
</script>




<script>


document.addEventListener('DOMContentLoaded', function () {
    const selectVille = document.getElementById('search-ville');
    const selectQuartier = document.getElementById('search-quartier');
    const optionsQuartiers = Array.from(selectQuartier.options);

    // 1. Nettoyage initial : supprime les doublons de quartiers dans la liste visuelle
    const vus = new Set();
    optionsQuartiers.forEach(opt => {
        if (opt.value === "") return;
        const cle = opt.value + '-' + opt.getAttribute('data-ville');
        if (vus.has(cle)) {
            opt.remove();
        } else {
            vus.add(cle);
        }
    });

    // Sauvegarde de la liste propre des quartiers pour s'en servir de référence
    const listeQuartiersPropre = Array.from(selectQuartier.options);

    // 2. Événement : Quand la ville change
    selectVille.addEventListener('change', function () {
        const villeSelectionnee = this.value;

        // Réinitialise le sélecteur de quartier
        selectQuartier.innerHTML = '';
        // Réinsère l'option par défaut ("Tous les quartiers...")
        selectQuartier.appendChild(listeQuartiersPropre[0]);

        // Filtre et affiche uniquement les quartiers de la ville sélectionnée
        listeQuartiersPropre.forEach(opt => {
            if (opt.value === "") return;
            
            const villeDuQuartier = opt.getAttribute('data-ville');
            if (villeSelectionnee === "" || villeDuQuartier === villeSelectionnee) {
                selectQuartier.appendChild(opt);
            }
        });

        // Remet le sélecteur de quartier sur l'option par défaut
        selectQuartier.value = "";
    });
});




</script>





</body>
</html>