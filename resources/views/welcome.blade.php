<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations de maisons - MaisonLoc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

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
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body { font-family: 'Poppins', sans-serif; background: var(--bg-light); color: var(--text-dark); overflow-x: hidden; }
    .container { max-width: 1300px; margin: auto; padding: 0 20px; }
</style>

<section class="hero-rental">
    <header class="navbar-custom container">
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
                <a href="#maisons">Nos Biens</a>
                <a href="#contact">Contact</a>
                <a href="#Apropos">À propos</a>
            </div>

            <div class="nav-buttons">
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="/admin/table" class="btn-login" title="Manager l'application">Manager</a>
                    @endif

                    @if(Auth::user()->role === 'dev')
                        <a href="/admin/dev" class="btn-login">DEVELOPPEUR</a>
                        <a href="/admin/table" class="btn-login">Manager</a>
                    @endif
                    
                    <span class="user-greeting"><i class="fa-solid fa-user"></i> {{ Auth::user()->name }} !</span>
                    <a href="/logout" class="btn-logout">Déconnexion</a>
                        
                    @if(Auth::user()->role === 'admin')
                        <a href="/admin/ajouter" class="btn-register">Publier un bien</a>
                    @elseif(Auth::user()->role === 'dev')
                        @else
                        <a href="#" class="btn-register">Publier un bien</a>
                    @endif
                @endauth

                @guest
                    <a href="javascript:void(0)" class="btn-login" id="openLoginBtn">Connexion</a>
                    <a href="javascript:void(0)" class="btn-register" id="openRegisterBtn">S'inscrire</a>
                @endguest
            </div>
        </nav>
    </header>

    <div class="hero-content container">
        <span class="hero-badge">🏡 Trouvez votre logement idéal</span>
        <h1>Louez ou faites louer une maison moderne facilement</h1>
        <p>Découvrez des milliers de maisons, villas et appartements disponibles partout au Togo.</p>

        
    </div>
</section>

<style>
    .hero-rental {
        min-height: 8vh;
        background: linear-gradient(rgba(0,0,0,0.55), rgba(0,0,0,0.55)),
                    url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070');
        background-size: cover;
        background-position: center;
       
        padding: 20px 3%;
        
        color: white;
    }
    .navbar-custom { display: flex; justify-content: space-between; align-items: center; height: 80px; }
    .logo a { color: white; text-decoration: none; font-size: 28px; font-weight: 800; }
    .logo a span { color: var(--primary); }
    
    .nav-container { display: flex; align-items: center; gap: 40px; }
    .nav-links { display: flex; gap: 25px; }
    .nav-links a { color: white; text-decoration: none; font-weight: 500; transition: 0.3s; font-size: 15px; }
    .nav-links a:hover { color: var(--primary); }
    .nav-buttons { display: flex; gap: 15px; align-items: center; }
    
    .btn-login { color: white; text-decoration: none; font-weight: 500; transition: 0.3s; }
    .btn-login:hover { color: var(--primary); }
    .btn-logout { background: #ef4444; color: white; text-decoration: none; padding: 8px 16px; border-radius: 8px; font-size: 14px; font-weight: 600; }
    .btn-register { background: white; color: var(--text-dark); padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; transition: 0.3s; }
    .btn-register:hover { background: var(--primary); color: white; }
    .user-greeting { font-size: 14px; background: rgba(255,255,255,0.2); padding: 6px 12px; border-radius: 20px; }

    /* MENU MOBILE TOGGLE */
    .menu-toggle { display: none; cursor: pointer; flex-direction: column; gap: 6px; z-index: 110; }
    .menu-toggle .bar { width: 28px; height: 3px; background: white; transition: 0.3s; border-radius: 2px; }

    /* HERO CONTENT */
    .hero-content { margin-top: 60px; }
    .hero-badge { background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 50px; backdrop-filter: blur(5px); font-size: 13px; font-weight: 500; display: inline-block; }
    .hero-content h1 { font-size: clamp(28px, 5vw, 54px); line-height: 1.2; margin-top: 20px; font-weight: 800; max-width: 800px; }
    .hero-content p { margin-top: 20px; font-size: clamp(16px, 2vw, 20px); color: #e5e7eb; max-width: 600px; }

    /* SEARCH BOX */
    .search-container { margin-top: 50px; background: white; border-radius: 15px; padding: 10px; display: flex; box-shadow: 0 15px 30px rgba(0,0,0,0.25); }
    .search-item { flex: 1; display: flex; align-items: center; gap: 10px; padding: 10px 15px; border-right: 1px solid #e5e7eb; }
    .search-item:last-of-type { border-right: none; }
    .search-item i { color: var(--primary); font-size: 18px; }
    .search-item select { border: none; outline: none; width: 100%; font-size: 15px; color: var(--text-dark); background: transparent; cursor: pointer; }
    .search-btn { background: var(--primary); color: white; border: none; padding: 15px 30px; border-radius: 12px; cursor: pointer; font-weight: 600; transition: 0.3s; }
    .search-btn:hover { background: var(--primary-hover); }

    /* RESPONSIVE HERO & NAVBAR */
    @media (max-width: 992px) {
        .menu-toggle { display: flex; position: absolute; top: 25px; right: 20px; }
        .nav-container { position: fixed; top: 0; right: -100%; height: 100vh; width: 280px; background: #111827; flex-direction: column; padding: 100px 30px; transition: 0.4s; overflow-y: auto; z-index: 100; gap: 30px; align-items: flex-start; box-shadow: -10px 0 30px rgba(0,0,0,0.3); }
        .nav-container.active { right: 0; }
        .nav-links { flex-direction: column; width: 100%; gap: 20px; }
        .nav-links a { font-size: 18px; }
        .nav-buttons { flex-direction: column; width: 100%; gap: 15px; align-items: stretch; }
        .btn-register, .btn-logout, .btn-login { text-align: center; width: 100%; }
        .search-container { flex-direction: column; gap: 5px; }
        .search-item { border-right: none; border-bottom: 1px solid #eee; padding: 15px 5px; }
        .search-btn { width: 100%; margin-top: 10px; }
    }
</style>

<section class="categories-section container" id="maisons">
    <h2 class="section-main-title">Les Catégories de biens disponibles</h2>
    
    <div class="houses-grid">
        @auth
            @foreach($categoriess as $categorie)
            <a class="card-link" href="/categories/{{ $categorie->id }}">
                <div class="category-card">
                    <img src="{{ $categorie->description }}" alt="{{ $categorie->nom }}">
                    <div class="card-body-custom">
                        <h3>{{ $categorie->nom ?? 'Catégorie Sans Nom' }}</h3>
                        <p>Découvrir nos offres disponibles</p>
                        <button class="card-btn">Voir la catégorie</button>
                    </div>
                </div>
            </a>
            @endforeach
        @else
            @foreach($categoriess as $categorie)
            <a class="card-link" href="javascript:void(0)" onclick="preparerMessage(); openLoginModal()">
                <div class="category-card">
                    <img src="{{ $categorie->description }}" alt="{{ $categorie->nom }}">
                    <div class="card-body-custom">
                        <h3>{{ $categorie->nom ?? 'Catégorie Sans Nom' }}</h3>
                        <p>Découvrir nos offres disponibles</p>
                        <button class="card-btn">Voir la catégorie</button>
                    </div>
                </div>
            </a>
            @endforeach
        @endauth
    </div>
</section>

<style>
    .categories-section { padding: 60px 20px; }
    .section-main-title { text-align: center; margin-bottom: 40px; font-size: clamp(24px, 4vw, 32px); font-weight: 800; color: var(--text-dark); }
    
    .houses-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px; justify-content: center; }
    .card-link { text-decoration: none; color: inherit; display: block; }
    
    .category-card { background: white; border-radius: 15px; box-shadow: 0 8px 16px rgba(0,0,0,0.06); overflow: hidden; transition: transform 0.3s ease, box-shadow 0.3s ease; height: 100%; display: flex; flex-direction: column; }
    .category-card:hover { transform: translateY(-5px); box-shadow: 0 12px 24px rgba(0,0,0,0.12); }
    .category-card img { width: 100%; height: 200px; object-fit: cover; }
    
    .card-body-custom { padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between; text-align: center; }
    .card-body-custom h3 { font-size: 20px; font-weight: 700; margin-bottom: 10px; color: var(--text-dark); }
    .card-body-custom p { font-size: 14px; color: var(--text-light); margin-bottom: 20px; }
    
    .card-btn { background: var(--primary); color: white; border: none; padding: 10px 20px; width: 100%; border-radius: 8px; font-weight: 600; cursor: pointer; transition: 0.3s; }
    .card-btn:hover { background: #219150; } /* Garde ton effet vert d'origine au survol */
</style>

<section class="why-section">
    <div class="container">
        <h2 class="section-title">Pourquoi choisir MaisonLoc ?</h2>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                <h3>Maisons vérifiées</h3>
                <p>Toutes les maisons et appartements publiés sur la plateforme sont vérifiés pour garantir sécurité et fiabilité.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-map-location-dot"></i></div>
                <h3>Locations au Togo</h3>
                <p>Trouvez facilement des logements à Lomé, Kara, Sokodé, Atakpamé et dans plusieurs autres villes.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-comments"></i></div>
                <h3>Contact direct</h3>
                <p>Discutez directement avec les propriétaires ou gestionnaires agréés sans intermédiaires compliqués.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-credit-card"></i></div>
                <h3>Paiements sécurisés</h3>
                <p>Réservez votre maison en toute confiance grâce à des options et outils de paiement fiables.</p>
            </div>
        </div>

        <div class="offers-section">
            <div class="offers-content">
                <span class="offer-badge">OFFRES SPÉCIALES AU TOGO</span>
                <h2>Trouvez une maison à prix abordable</h2>
                <p>Découvrez des villas, appartements meublés et maisons familiales disponibles à des prix accessibles dans plusieurs quartiers populaires de Lomé et des grandes villes du Togo.</p>

                <ul class="offer-list">
                    <li><i class="fa-solid fa-circle-check"></i> Maisons meublées disponibles immédiatement</li>
                    <li><i class="fa-solid fa-circle-check"></i> Réservation rapide et sécurisée</li>
                    <li><i class="fa-solid fa-circle-check"></i> Prix adaptés à tous les budgets</li>
                    <li><i class="fa-solid fa-circle-check"></i> Assistance client 7j/7</li>
                </ul>

                <a href="#maisons" class="offer-btn">Explorer les maisons</a>
            </div>

            <div class="offers-image">
                <img src="https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?q=80&w=1200" alt="Maison moderne">
            </div>
        </div>
    </div>
</section>

<style>
    .why-section { padding: 80px 0; background: #f5f7fb; }
    .section-title { font-size: clamp(26px, 4vw, 38px); color: var(--text-dark); margin-bottom: 40px; font-weight: 800; text-align: center; }
    
    .features-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; }
    .feature-card { background: white; padding: 30px; border-radius: 18px; border: 1px solid #e5e7eb; transition: 0.3s; }
    .feature-card:hover { transform: translateY(-6px); box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
    .feature-icon { font-size: 35px; color: var(--primary); margin-bottom: 15px; }
    .feature-card h3 { font-size: 20px; margin-bottom: 12px; font-weight: 700; color: var(--text-dark); }
    .feature-card p { color: var(--text-light); line-height: 1.6; font-size: 15px; }

    /* OFFERS DESIGN RESPONSIVE */
    .offers-section { margin-top: 60px; background: white; border-radius: 24px; padding: 40px; display: flex; align-items: center; justify-content: space-between; gap: 40px; border: 1px solid #e5e7eb; }
    .offer-badge { background: #dbeafe; color: var(--primary); padding: 8px 16px; border-radius: 50px; font-size: 13px; font-weight: 600; display: inline-block; }
    .offers-content h2 { margin-top: 20px; font-size: clamp(24px, 4vw, 38px); line-height: 1.3; font-weight: 800; color: var(--text-dark); }
    .offers-content p { margin-top: 15px; color: var(--text-light); line-height: 1.7; font-size: 16px; }
    
    .offer-list { margin-top: 20px; list-style: none; }
    .offer-list li { margin-bottom: 12px; font-size: 15px; display: flex; align-items: center; gap: 10px; color: var(--text-dark); }
    .offer-list li i { color: #10b981; }
    
    .offer-btn { display: inline-block; margin-top: 25px; background: var(--primary); color: white; text-decoration: none; padding: 15px 30px; border-radius: 12px; font-weight: 600; transition: 0.3s; }
    .offer-btn:hover { background: var(--primary-hover); transform: translateY(-2px); }
    
    .offers-image img { width: 100%; max-width: 420px; height: auto; border-radius: 20px; object-fit: cover; box-shadow: 0 15px 30px rgba(0,0,0,0.1); }

    @media (max-width: 992px) {
        .offers-section { flex-direction: column; text-align: center; padding: 30px 20px; }
        .offer-list li { justify-content: center; }
        .offers-image img { max-width: 100%; }
    }
</style>

<section class="about-section" id="Apropos">
    <div class="container">
        <div class="about-grid">
            <div class="about-visual">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?q=80&w=1200" alt="MaisonLoc Togo">
                    <div class="stat-card">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Annonces vérifiées</span>
                    </div>
                </div>
            </div>

            <div class="about-content">
                <span class="about-badge">QUI SOMMES-NOUS ?</span>
                <h2>La solution n°1 pour votre logement au Togo</h2>
                <p>Lancée avec l'ambition de simplifier l'accès à l'immobilier, <strong>MaisonLoc</strong> est une plateforme dédiée à connecter les locataires et les propriétaires sur toute l'étendue du territoire togolais.</p>

                <div class="mission-box">
                    <div class="mission-item">
                        <div class="mission-dot"></div>
                        <div>
                            <h4>Notre Vision</h4>
                            <p>Éliminer les barrières et les intermédiaires informels pour une location immobilière transparente.</p>
                        </div>
                    </div>

                    <div class="mission-item">
                        <div class="mission-dot"></div>
                        <div>
                            <h4>Notre Engagement</h4>
                            <p>Sécurité totale : chaque annonce est manuellement validée par nos équipes locales basées sur place.</p>
                        </div>
                    </div>
                </div>

                <div class="about-footer">
                    <div class="signature">
                        <strong>L'équipe MaisonLoc</strong>
                        <span>Basée à Lomé, Togo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .about-section { padding: 80px 0; background: white; }
    .about-grid { display: grid; grid-template-columns: 1fr 1fr; align-items: center; gap: 60px; }
    
    .about-visual { position: relative; }
    .image-wrapper { position: relative; }
    .image-wrapper img { width: 100%; height: 450px; object-fit: cover; border-radius: 24px; }
    
    .stat-card { position: absolute; bottom: -15px; right: -15px; background: var(--primary); color: white; padding: 20px 25px; border-radius: 15px; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3); text-align: center; }
    .stat-number { display: block; font-size: 28px; font-weight: 800; }
    .stat-label { font-size: 13px; opacity: 0.9; }

    .about-badge { color: var(--primary); font-weight: 700; letter-spacing: 1px; font-size: 14px; display: block; margin-bottom: 15px; }
    .about-content h2 { font-size: clamp(24px, 4vw, 36px); color: var(--text-dark); line-height: 1.3; margin-bottom: 20px; font-weight: 800; }
    .about-content p { color: var(--text-light); font-size: 16px; line-height: 1.7; margin-bottom: 25px; }
    
    .mission-box { display: flex; flex-direction: column; gap: 20px; }
    .mission-item { display: flex; gap: 15px; text-align: left; }
    .mission-dot { width: 10px; height: 10px; background: var(--primary); border-radius: 50%; margin-top: 6px; flex-shrink: 0; }
    .mission-item h4 { font-size: 18px; font-weight: 700; color: var(--text-dark); margin-bottom: 5px; }
    .mission-item p { font-size: 15px; color: var(--text-light); }
    
    .about-footer { margin-top: 30px; padding-top: 20px; border-top: 1px solid #f3f4f6; }
    .signature strong { display: block; font-size: 16px; color: var(--text-dark); }
    .signature span { color: var(--text-muted); font-size: 13px; }

    @media (max-width: 992px) {
        .about-grid { grid-template-columns: 1fr; gap: 50px; }
        .about-content { text-align: center; }
        .mission-item { text-align: left; }
        .image-wrapper img { height: 350px; }
        .stat-card { right: 10px; bottom: 10px; }
    }
</style>

<section class="contact-section" id="contact">
    <div class="container">
        <h2 class="section-title">Contactez-nous</h2>

        <div class="contact-wrapper">
            <div class="contact-info">
                <h3>Besoin d'aide ?</h3>
                <p>Notre équipe togolaise est à votre écoute pour vous accompagner dans votre recherche ou mise en location de logement.</p>
                
                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-phone"></i></div>
                    <div class="info-text">
                        <span>Appelez-nous</span>
                        <p>+228 91 30 40 00</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-envelope"></i></div>
                    <div class="info-text">
                        <span>Email</span>
                        <p>contact@maisonloc.tg</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon"><i class="fa-solid fa-location-dot"></i></div>
                    <div class="info-text">
                        <span>Siège social</span>
                        <p>Quartier Agoè, Lomé - Togo</p>
                    </div>
                </div>

                <div class="social-links">
                    <small>Suivez-nous sur les réseaux sociaux</small>
                    <div class="social-icons">
                        <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="contact-form-container">
                <form class="contact-form" action="#" method="POST">
                    <div class="form-group">
                        <label>Nom complet</label>
                        <input type="text" placeholder="Ex: Jean Koffi" required>
                    </div>

                    <div class="form-group">
                        <label>Votre Email</label>
                        <input type="email" placeholder="jean.koffi@email.com" required>
                    </div>

                    <div class="form-group">
                        <label>Sujet</label>
                        <select required>
                            <option value="">Choisissez une option</option>
                            <option value="location">Recherche de location</option>
                            <option value="proprietaire">Mettre mon bien en location</option>
                            <option value="assistance">Assistance technique</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Message</label>
                        <textarea rows="4" placeholder="Comment pouvons-nous vous aider ?" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Envoyer le message</button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    .contact-section { background: #f5f7fb; padding: 80px 0; }
    .contact-wrapper { display: flex; gap: 40px; background: white; padding: 40px; border-radius: 24px; border: 1px solid #e5e7eb; box-shadow: 0 10px 30px rgba(0,0,0,0.02); }
    
    .contact-info, .contact-form-container { flex: 1; }
    .contact-info h3 { font-size: 26px; font-weight: 700; color: var(--text-dark); margin-bottom: 15px; }
    .contact-info p { color: var(--text-light); font-size: 15px; line-height: 1.6; margin-bottom: 30px; }
    
    .info-item { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; }
    .info-icon { width: 45px; height: 45px; background: var(--primary-soft); color: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 18px; }
    .info-text span { display: block; font-size: 13px; color: var(--text-muted); }
    .info-text p { margin: 0; font-weight: 700; color: var(--text-dark); font-size: 16px; }

    .contact-form { display: flex; flex-direction: column; gap: 15px; }
    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group label { font-weight: 600; font-size: 14px; color: var(--text-dark); }
    .form-group input, .form-group select, .form-group textarea { padding: 12px 15px; border-radius: 8px; border: 1px solid #d1d5db; font-size: 15px; outline: none; transition: 0.2s; background: #f9fafb; }
    .form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: var(--primary); background: white; box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15); }
    
    .submit-btn { background: var(--primary); color: white; padding: 14px; border: none; border-radius: 8px; font-weight: 600; font-size: 16px; cursor: pointer; transition: 0.3s; }
    .submit-btn:hover { background: var(--primary-hover); transform: translateY(-1px); }

    .social-links { margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; }
    .social-icons { display: flex; gap: 12px; margin-top: 10px; }
    .social-icons a { text-decoration: none; width: 36px; height: 36px; background: var(--text-dark); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; transition: 0.3s; font-size: 14px; }
    .social-icons a:hover { background: var(--primary); transform: translateY(-2px); }

    @media (max-width: 992px) {
        .contact-wrapper { flex-direction: column; padding: 30px 20px; gap: 40px; }
        .contact-info { text-align: center; }
        .info-item { justify-content: flex-start; text-align: left; max-width: 300px; margin: 0 auto 20px auto; }
        .social-icons { justify-content: center; }
    }
</style>

<div id="loginModal" class="modal-overlay">
    <div class="auth-card">
        <div class="close-modal" id="closeLogin">&times;</div>
        <div class="auth-header">
            <div class="icon-box"><i class="fa-solid fa-right-to-bracket"></i></div>
            <h3>Connexion</h3>
            <p>Heureux de vous revoir sur MaisonLoc</p>
        </div>

        <form method="POST" action="/login">
            @if(session('registre_ok'))
                <div class="success-message-box">✨ Inscription réussie ! Connectez-vous.</div>
            @endif
            @csrf
            @if($errors->any())
                <div class="error-message-box"><i class="fa-solid fa-circle-exclamation"></i> Identifiants incorrects</div>
            @endif
            
            <div class="input-group">
                <label>Adresse e-mail</label>
                <input type="email" name="email" placeholder="votre@email.com" required>
            </div>
            <div class="input-group">
                <label>Mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="auth-options">
                <label class="checkbox-container">
                    <input type="checkbox" name="remember"> Se souvenir de moi
                </label>
                <a href="{{ route('password.request') }}" class="forgot-link">Oublié ?</a>
            </div>
            <button type="submit" class="auth-btn">Se connecter</button>
        </form>
        <div class="auth-footer">Pas de compte ? <a href="javascript:void(0)" class="toggle-to-register">S'inscrire</a></div>
    </div>
</div>

<div id="registerModal" class="modal-overlay">
    <div class="auth-card">
        <div class="close-modal" id="closeRegister">&times;</div>
        <div class="auth-header">
            <div class="icon-box"><i class="fa-solid fa-user-plus"></i></div>
            <h3>Créer un compte</h3>
            <p>Rejoignez la communauté MaisonLoc</p>
        </div>

        @if($errors->register->any())
            <div class="error-message-box"><i class="fa-solid fa-circle-exclamation"></i> Les mots de passe ne correspondent pas</div>
        @endif

        <form method="POST" action="/enregistrer/store" enctype="multipart/form-data">
            @csrf
            <div class="role-selector">
                <p>Avez-vous des maisons à louer ?</p>
                <div class="radio-group">
                    <label class="radio-btn"><input type="radio" name="role" value="oui" {{ old('role') === 'oui' ? 'checked' : '' }} required> Oui</label>
                    <label class="radio-btn"><input type="radio" name="role" value="non" {{ old('role') === 'non' ? 'checked' : '' }} required> Non</label>
                </div>
            </div>

            <div class="input-row">
                <div class="input-group"><label>Nom</label><input type="text" name="nom" value="{{ old('nom') }}" required></div>
                <div class="input-group"><label>Prénom</label><input type="text" name="prenom" value="{{ old('prenom') }}" required></div>
            </div>

            <div class="input-row">
                <div class="input-group"><label>Contact</label><input type="number" name="contact" value="{{ old('contact') }}" required></div>
                <div class="input-group"><label>Email</label><input type="email" name="email" value="{{ old('email') }}" required></div>
            </div>

            <div class="input-row">
                <div class="input-group"><label>Mot de passe</label><input type="password" name="password" required></div>
                <div class="input-group"><label>Confirmer</label><input type="password" name="password_confirmation" required></div>
            </div>

            <button type="submit" class="auth-btn">S'inscrire</button>
        </form>
        <div class="auth-footer">Déjà inscrit ? <a href="javascript:void(0)" class="toggle-to-login">Se connecter</a></div>
    </div>
</div>

<style>
    .modal-overlay { display: none; position: fixed; inset: 0; z-index: 10000; background: rgba(15, 23, 42, 0.75); backdrop-filter: blur(6px); justify-content: center; align-items: center; padding: 20px; overflow-y: auto; }
    .auth-card { background: white; width: 100%; max-width: 480px; border-radius: 20px; padding: 30px; position: relative; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25); margin: auto; }
    
    .success-message-box { background: #f0fdf4; color: #16a34a; padding: 12px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 15px; text-align: center; }
    .error-message-box { background: #fff1f2; color: #e11d48; padding: 12px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-bottom: 15px; text-align: center; }
    
    .auth-header { text-align: center; margin-bottom: 20px; }
    .auth-header h3 { font-size: 22px; font-weight: 800; color: var(--text-dark); }
    .auth-header p { font-size: 13px; color: var(--text-light); }
    
    .input-group { margin-bottom: 15px; width: 100%; }
    .input-row { display: flex; gap: 15px; width: 100%; }
    .input-group label { display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 5px; }
    .input-group input { width: 100%; padding: 10px 14px; border-radius: 8px; border: 2px solid #f1f5f9; background: #f8fafc; font-size: 14px; outline: none; }
    .input-group input:focus { border-color: var(--primary); background: white; }
    
    .auth-options { display: flex; justify-content: space-between; align-items: center; font-size: 13px; margin-bottom: 15px; }
    .forgot-link { color: var(--primary); text-decoration: none; font-weight: 600; }
    .auth-btn { width: 100%; padding: 12px; background: var(--primary); color: white; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; transition: 0.2s; }
    .auth-btn:hover { background: var(--primary-hover); }
    
    .role-selector { background: #f1f5f9; padding: 12px; border-radius: 10px; margin-bottom: 15px; text-align: center; }
    .role-selector p { font-size: 13px; font-weight: 600; margin-bottom: 5px; }
    .radio-group { display: flex; justify-content: center; gap: 20px; }
    .radio-btn { font-size: 13px; font-weight: 600; cursor: pointer; }
    
    .auth-footer { text-align: center; margin-top: 20px; font-size: 13px; color: var(--text-light); }
    .auth-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }
    .close-modal { position: absolute; top: 15px; right: 20px; font-size: 26px; cursor: pointer; color: var(--text-muted); }

    @media (max-width: 576px) {
        .input-row { flex-direction: column; gap: 0; }
        .auth-card { padding: 20px; }
    }
</style>

<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col about-col">
                <div class="footer-logo">Maison<span>Loc</span></div>
                <p>La plateforme de référence pour la location immobilière au Togo. Nous rendons la recherche de logement simple, rapide et sécurisée pour tous.</p>
                <div class="footer-socials">
                    <a href="https://www.facebook.com/gerard.krettossmith" aria-label="Facebook" target="_blank">FB</a>
                    <a href="https://wa.me/22891304000" aria-label="WhatsApp" target="_blank">WA</a>
                    <a href="#" aria-label="Instagram">IG</a>
                </div>
            </div>

            <div class="footer-col">
                <h4>Navigation</h4>
                <ul class="footer-links">
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#maisons">Explorer les biens</a></li>
                    <li><a href="#Apropos">À propos de nous</a></li>
                    <li><a href="#contact">Nous contacter</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Villes populaires</h4>
                <ul class="footer-links">
                    <li><a href="#">Locations à Lomé</a></li>
                    <li><a href="#">Locations à Kara</a></li>
                    <li><a href="#">Locations à Sokodé</a></li>
                    <li><a href="#">Locations à Kpalimé</a></li>
                </ul>
            </div>

            <div class="footer-col">
                <h4>Restez informé</h4>
                <p class="small-text">Inscrivez-vous pour recevoir les dernières offres immobilières au Togo.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Votre email" required>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2026 MaisonLoc Togo by Gkrettos TAGBA. Tous droits réservés.</p>
            <div class="footer-legal">
                <a href="#">Mentions légales</a>
                <a href="#">Politique de confidentialité</a>
            </div>
        </div>
    </div>
</footer>

<style>
    .main-footer { background: #111827; color: #e5e7eb; padding: 60px 0 30px 0; }
    .footer-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 40px; margin-bottom: 40px; }
    
    .footer-logo { font-size: 26px; font-weight: 800; color: white; margin-bottom: 15px; }
    .footer-logo span { color: var(--primary); }
    .about-col p { line-height: 1.6; color: var(--text-muted); font-size: 14px; max-width: 280px; }
    
    .footer-col h4 { color: white; font-size: 16px; font-weight: 700; margin-bottom: 20px; position: relative; }
    .footer-col h4::after { content: ''; position: absolute; left: 0; bottom: -6px; width: 30px; height: 2px; background: var(--primary); }
    
    .footer-links { list-style: none; padding: 0; }
    .footer-links li { margin-bottom: 10px; }
    .footer-links a { color: var(--text-muted); text-decoration: none; transition: 0.2s; font-size: 14px; }
    .footer-links a:hover { color: white; padding-left: 4px; }
    
    .small-text { font-size: 13px; color: var(--text-muted); margin-bottom: 12px; }
    .newsletter-form { display: flex; gap: 8px; }
    .newsletter-form input { flex: 1; background: #1f2937; border: 1px solid #374151; padding: 10px 12px; border-radius: 6px; color: white; outline: none; font-size: 14px; }
    .newsletter-form button { background: var(--primary); color: white; border: none; padding: 10px 16px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 14px; }
    .newsletter-form button:hover { background: var(--primary-hover); }

    .footer-bottom { padding-top: 25px; border-top: 1px solid #1f2937; display: flex; justify-content: space-between; align-items: center; font-size: 13px; color: #6b7280; flex-wrap: wrap; gap: 15px; }
    .footer-legal { display: flex; gap: 20px; }
    .footer-legal a { color: #6b7280; text-decoration: none; }
    .footer-legal a:hover { color: var(--text-muted); }

    @media (max-width: 768px) {
        .footer-grid { text-align: center; }
        .footer-col h4::after { left: 50%; transform: translateX(-50%); }
        .footer-socials, .newsletter-form { justify-content: center; }
        .about-col p { margin: 0 auto; }
        .footer-bottom { flex-direction: column; text-align: center; }
    }
</style>

<script>
    // Gestion Menu Mobile Navbar
    const menuToggle = document.getElementById('mobile-menu');
    const navContainer = document.querySelector('.nav-container');

    menuToggle.addEventListener('click', () => {
        navContainer.classList.toggle('active');
        const bars = document.querySelectorAll('.bar');
        bars[0].style.transform = navContainer.classList.contains('active') ? 'rotate(45deg) translate(5px, 6px)' : 'none';
        bars[1].style.opacity = navContainer.classList.contains('active') ? '0' : '1';
        bars[2].style.transform = navContainer.classList.contains('active') ? 'rotate(-45deg) translate(5px, -6px)' : 'none';
    });

    // Fonctions Modales Authentification
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');

    const showLogin = () => { loginModal.style.display = 'flex'; registerModal.style.display = 'none'; };
    const showRegister = () => { registerModal.style.display = 'flex'; loginModal.style.display = 'none'; };
    const closeAll = () => { loginModal.style.display = 'none'; registerModal.style.display = 'none'; };

    // Assignation conditionnelle des événements (évite les erreurs si déconnecté/connecté)
    if(document.getElementById('openLoginBtn')) document.getElementById('openLoginBtn').onclick = showLogin;
    if(document.getElementById('openRegisterBtn')) document.getElementById('openRegisterBtn').onclick = showRegister;
    
    document.getElementById('closeLogin').onclick = closeAll;
    document.getElementById('closeRegister').onclick = closeAll;

    document.querySelector('.toggle-to-register').onclick = (e) => { e.preventDefault(); showRegister(); };
    document.querySelector('.toggle-to-login').onclick = (e) => { e.preventDefault(); showLogin(); };

    function preparerMessage() {
        // Optionnel : tu peux créer une div d'alerte ou injecter un message dans ton formulaire de connexion
        console.log("Tentative d'exploration hors ligne.");
    }

    function openLoginModal() {
        showLogin();
    }

    // Gestion de l'affichage automatique basé sur les retours de sessions Laravel Flash
    window.onload = () => {
        @if(session('registre_ok'))
            showLogin();
        @elseif($errors->register->any())
            showRegister();
        @elseif($errors->any())
            showLogin();
        @endif
    };

    // Fermeture en cliquant en dehors de la boîte blanche
    window.onclick = (e) => {
        if (e.target == loginModal || e.target == registerModal) closeAll();
    };
</script>

</body>
</html>