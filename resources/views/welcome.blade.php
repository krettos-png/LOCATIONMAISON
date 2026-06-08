<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locationsnn de maisonsyyy</title>
   
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>




<!-- <style>


nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: #222;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: right;
      z-index: 1000;
    }

    nav .brand {
      font-weight: bold;
      font-size: 20px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-size: 14px;
    }

    nav a:hover {
      text-decoration: underline;
    }


</style> -->







<!-- 
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MaisonLoc</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="/acd">Accueil</a>
          </li>
          
          
          <li class="nav-item">
            <a class="nav-link" href="/inscription">Inscription</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login">Connection</a>
          <li class="nav-item">
            <a class="nav-link" href="#">Nous Contacter</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/inscription">A propos</a>
          </li>
        </ul>
      </div>
    </div>
  </nav> -->














































<!-- =========================
     HERO LOCATION MAISON
========================= -->

<section class="hero-rental">
    <header class="navbar">
        <div class="logo">
            <a href="{{ url('/') }}">MaisonLoc</a>
        </div>

        <!-- Icône Menu Mobile -->
        <div class="menu-toggle" id="mobile-menu">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
        </div>

        <!-- <nav class="nav-container">
            <div class="nav-links">
                <a href="#maisons">Maisons</a>
                <a href="#maisons">Appartements</a>
                <a href="#maisons">Villas</a>
                <a href="#contact">Contact</a>
                <a href="#Apropos">À propos</a>
            </div>

            <div class="nav-buttons">
                <a href="/login" class="btn-login">Connexion</a>
                <a href="/inscription" class="btn-register">Publier un bien</a>
            </div>
        </nav> -->




<nav class="nav-container">
    <div class="nav-links">
        <a href="#maisons">Nos Biens</a>
        <a href="#contact">Contact</a>
        <a href="#Apropos">À propos</a>

        {{-- Si l'utilisateur n'est PAS connecté --}}
        @guest
            <a href="#">Nader</a>
        @endguest
    </div>

    <div class="nav-buttons">
        {{-- Si l'utilisateur est connecté --}}
        @auth
            
            
            {{-- Vérification du rôle --}}
            @if(Auth::user()->role === 'admin')
            
                
                <a href="/admin/table" class="btn-login" title="Vous pouvez ajouter ou modifier une maison ici">Manager</a>
                
                
            @endif

            @if(Auth::user()->role === 'dev')
            
                
                <a href="#" class="btn-login" title="Vous pouvez ajouter une maison ici">DEVELOPPEUR</a>
@endif
            {{-- Bouton de déconnexion (obligatoire en Laravel via un petit formulaire) --}}
            <a class="btn-login"> {{ Auth::user()->name }} {{ Auth::user()->prenom}} !</a>
            <a href="/logout" class="btn-login">Deconnexion</a>
                
                @if(Auth::user()->role === 'admin')

                <a href="/admin/ajouter" class="btn-register">Publier un bien</a>
                @elseif(Auth::user()->role === 'dev')

                @else

                <a href="#" class="btn-register">Publier un bien</a>

                @endif
                
            
            

        @endauth

        {{-- Si l'utilisateur est un simple visiteur --}}
        @guest
            <a href="javascript:void(0)" class="btn-login" id="openLoginBtn">Connexion</a>
            <a href="javascript:void(0)" class="btn-register" id="openRegisterBtn">S'inscrire</a>
            <!-- <a href="/inscription" class="btn-register">S'inscrire</a> -->
        @endguest
    </div>
</nav>











    </header>

    <div class="hero-content">
        <span class="hero-badge">🏡 Trouvez votre logement idéal</span>
        <h1>Louez ou faites louer une maison moderne facilement</h1>
        <p>Découvrez des milliers de maisons, villas et appartements disponibles partout.</p>

        <!-- <form class="search-container">
            <div class="search-item">
                <i class="fa-solid fa-location-dot"></i>
                <select name="ville">
                    <option value="">Ville</option>
                    @foreach($villes as $ville)
                        @if($ville) <option value="{{ $ville }}">{{ $ville }}</option> @endif
                    @endforeach
                </select>
            </div>

            <div class="search-item">
                <i class="fa-solid fa-map-pin"></i>
                <select name="quartier">
                    <option value="">Quartier...</option>
                    @foreach($quartiers as $quartier)
                        @if($quartier) <option value="{{ $quartier }}">{{ $quartier }}</option> @endif
                    @endforeach
                </select>
            </div>

            <div class="search-item">
                <i class="fa-solid fa-house"></i>
                <select name="type">
                    <option value="">Type...</option>
                    @foreach($categoriess as $categorie)
                        @if($categorie) <option value="{{ $categorie->id }}">{{ $categorie->nom }}</option> @endif
                    @endforeach
                </select>
            </div>

            <button type="submit" class="search-btn">Rechercher</button>
        </form> -->
    </div>
</section>

<!-- FONT AWESOME -->












<style>


/* =========================
   STYLE LOCATION MAISON
========================= */

<style>
* { margin: 0; padding: 0; box-sizing: border-box; }
body { font-family: 'Poppins', sans-serif; background: #f4f7fb; overflow-x: hidden; }

.hero-rental {
    min-height: 8vh;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
                url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070');
    background-size: cover;
    background-position: center;
    padding: 20px 3%;
    color: white;
}
/* 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070' */
/* https://flagcdn.com/w20/tg.png */

/* NAVBAR */
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 80px;
}

.logo a { color: white; text-decoration: none; font-size: 28px; font-weight: 700; }

.nav-container { display: flex; align-items: center; gap: 40px; }
.nav-links { display: flex; gap: 25px; }
.nav-links a { color: white; text-decoration: none; font-weight: 500; transition: 0.3s; font-size: 15px; }
.nav-buttons { display: flex; gap: 10px; align-items: center; }

.btn-login { color: white; text-decoration: none; padding: 10px 15px; }
.btn-register { background: white; color: #111827; padding: 12px 20px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: 14px; }

/* MENU MOBILE TOGGLE */
.menu-toggle { display: none; cursor: pointer; flex-direction: column; gap: 6px; }
.menu-toggle .bar { width: 30px; height: 3px; background: white; transition: 0.3s; }

/* HERO CONTENT */
.hero-content { margin-top: 80px; max-width: 800px; }
.hero-badge { background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 50px; backdrop-filter: blur(5px); font-size: 13px; }
.hero-content h1 { font-size: clamp(32px, 5vw, 56px); line-height: 1.2; margin-top: 20px; font-weight: 800; }
.hero-content p { margin-top: 20px; font-size: clamp(16px, 2vw, 20px); color: #e5e7eb; }

/* SEARCH BOX */
.search-container {
    margin-top: 98px;
    background: white;
    border-radius: 15px;
    padding: 8px;
    display: flex;
    box-shadow: 0 15px 30px rgba(0,0,0,0.3);
}

.search-item {
    flex: 1;
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 15px;
    border-right: 1px solid #eee;
}

.search-item:last-of-type { border-right: none; }
.search-item i { color: #2563eb; font-size: 18px; }
.search-item select { border: none; outline: none; width: 100%; font-size: 15px; background: transparent; cursor: pointer; }

.search-btn {
    background: #2563eb;
    color: white;
    border: none;
    padding: 15px 30px;
    border-radius: 12px;
    cursor: pointer;
    font-weight: 600;
}

/* RESPONSIVE MEDIA QUERIES */

@media (max-width: 992px) {
    .menu-toggle { display: flex; z-index: 100; }
    
    .nav-container {
        position: fixed;
        top: 0; right: -100%;
        height: 100vh; width: 70%;
        background: #111827;
        flex-direction: column;
        padding: 100px 40px;
        transition: 0.4s;
        box-shadow: -10px 0 20px rgba(0,0,0,0.2);
    }

    .nav-container.active { right: 0; }
    .nav-links { flex-direction: column; width: 100%; gap: 30px; }
    .nav-links a { font-size: 20px; }
    .nav-buttons { flex-direction: column; width: 100%; margin-top: 40px; }
    .btn-register { text-align: center; width: 100%; }

    .search-container { flex-direction: column; }
    .search-item { border-right: none; border-bottom: 1px solid #eee; width: 100%; }
    .search-btn { width: 100%; margin-top: 10px; }
}

@media (max-width: 480px) {
    .hero-rental { padding: 20px; }
    .hero-content { margin-top: 40px; }
    .search-container { padding: 15px; }
}





/* On s'assure que le bouton de menu (qui devient la croix) reste fixe */
.menu-toggle {
    display: none; /* Cache par défaut sur PC */
    cursor: pointer;
    flex-direction: column;
    gap: 6px;
    z-index: 110; /* Doit être au-dessus du menu (qui est à 100) */
    position: relative; /* Par défaut */
}

@media (max-width: 992px) {
    .menu-toggle {
        display: flex;
        position: fixed; /* <--- C'EST LA CLÉ */
        top: 25px;       /* Ajuste selon ton design */
        right: 25px;     /* Ajuste selon ton design */
    }

    .nav-container {
        position: fixed;
        top: 0; 
        right: -100%;
        height: 100vh; 
        width: 80%; /* Un peu plus large pour le confort */
        background: #111827;
        flex-direction: column;
        padding: 100px 40px;
        transition: 0.4s;
        overflow-y: auto; /* Permet de défiler le contenu du menu seulement */
        z-index: 100;
    }
}









</style>






<!-- ===================================
     SECTION JS MAISON ENTETE
=================================== -->



<script>
    const menuToggle = document.getElementById('mobile-menu');
    const navContainer = document.querySelector('.nav-container');

    menuToggle.addEventListener('click', () => {
        navContainer.classList.toggle('active');
        // Animation simple des barres du menu
        const bars = document.querySelectorAll('.bar');
        bars[0].style.transform = navContainer.classList.contains('active') ? 'rotate(45deg) translate(5px, 6px)' : 'none';
        bars[1].style.opacity = navContainer.classList.contains('active') ? '0' : '1';
        bars[2].style.transform = navContainer.classList.contains('active') ? 'rotate(-45deg) translate(7px, -8px)' : 'none';
    });
</script>




    <!-- <section class="houses">
    @foreach($maisons as $maison)
    <a class="reste" href="/maison/{{ $maison->id }}/infoA" style="text-decoration: none; color: inherit;">
        <div class="card">
            <img src="{{ asset('storage/' . $maison->image) }}" alt="{{ $maison['titre'] }}">
            
            {{-- Limite le titre à 10 caractères --}}
            <h2>{{ Str::limit($maison['titre'], 10, '...') }}</h2>
            
            {{-- Limite la description à 30 caractères --}}
            <p>{{ Str::limit($maison['description'], 30, '...') }}</p>
            
            <p><strong>{{ $maison['prix'] }} FCFA/mois</strong></p>
            <button onclick="bookNow('{{ $maison['adresse'] }}')">En Savoir Plus</button>
        </div>
    </a>
    @endforeach
</section>
    <script src="{{ asset('js/script.js') }}"></script>

-->

    <style>
        body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f5f7fa;
    color: #333;
}

/*header {
    margin-top :55px;
    background: #2c3e50;

    color: white;
    padding: 20px;
    text-align: center;
}*/


.card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    height: 100%; /* Pour que toutes les cartes d'une même ligne soient égales */
    min-height: 400px; /* Ajuste cette valeur selon tes besoins */
}

.houses {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    padding: 10px;
    gap: 10px;
}

.card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 300px;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: scale(1.03);
}

.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card h2 {
    margin: 10px;
    font-size: 1.2em;
}

.card p {
    margin: 10px;
    font-size: 0.9em;
}

.card button {
    background: #2563eb;
    color: white;
    border: none;
    padding: 10px;
    margin: 10px;
    width: calc(100% - 20px);
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.card button:hover {
    background: #219150;
}
    </style>



<br>
<h2 style="text-align: center; margin-bottom: 20px;">Les Catégories de biens disponibles</h2>

    <section class="houses" id="maisons">
        
        
    @auth
        @foreach($categoriess as $categorie)
    {{-- Modification du lien pour pointer vers la catégorie si nécessaire --}}
    <a class="reste" class="link-categorie" href="/categories/{{ $categorie->id }}" style="text-decoration: none; color: inherit;">
        <div class="card">
            {{-- Image de la catégorie ou de la première maison --}}
             <img src="{{ $categorie->description }}" alt="{{ $categorie->nom }}">
            
            {{-- On affiche le nom de la catégorie --}}
            <h1 style="text-align: center; padding: 15px 0;">
                 {{ $categorie->nom ?? 'Catégorie Sans Nom' }}
            </h1>
            
            {{-- Petit badge ou texte descriptif --}}
            <p style="text-align: center; color: #666;">
                Découvrir nos offres
            </p>
            
            <button>Voir la catégorie</button>
        </div>
    </a>
    @endforeach
    @else
        @foreach($categoriess as $categorie)
    {{-- Modification du lien pour pointer vers la catégorie si nécessaire --}}
    <a class="reste" class="link-categorie" href="javascript:void(0)" onclick="preparerMessage(); openLoginModal()" style="text-decoration: none; color: inherit;">
        <div class="card">
            {{-- Image de la catégorie ou de la première maison --}}
             <img src="{{ $categorie->description }}" alt="{{ $categorie->nom }}">
            
            {{-- On affiche le nom de la catégorie --}}
            <h1 style="text-align: center; padding: 15px 0;">
                 {{ $categorie->nom ?? 'Catégorie Sans Nom' }}
            </h1>
            
            {{-- Petit badge ou texte descriptif --}}
            <p style="text-align: center; color: #666;">
                Découvrir nos offres
            </p>
            
            <button>Voir la catégorie</button>
        </div>
    </a>
    
    @endforeach
    @endauth
</section>





<script>
function preparerMessage() {
    const messageBox = document.getElementById('auth-message');
    if (messageBox) {
        messageBox.innerText = "Veuillez vous connecter pour explorer cette catégorie.";
        messageBox.style.display = 'block';
    }
}

function openLoginModal() {
    const loginModal = document.getElementById('loginModal');
    if (loginModal) {
        loginModal.style.display = 'flex';
    }
}
</script>






    <script src="{{ asset('js/script.js') }}"></script>


    <style>
        body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f5f7fa;
    color: #333;
}



    .card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 280px; /* Légèrement plus étroit pour les catégories */
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center; /* Centre le contenu */
    padding-bottom: 15px;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.15);
}

.card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

</style>










<!-- ===================================
     SECTION AVANTAGES + OFFRES TOGO
=================================== -->

<section class="why-section">

    <div class="container">

        <!-- TITLE -->

        <h2 class="section-title">
            Pourquoi choisir MaisonLoc ?
        </h2>

        <!-- FEATURES -->

        <div class="features-grid">

            <!-- CARD -->

            <div class="feature-card">
                <div class="feature-icon"></div>

                <h3>Maisons vérifiées</h3>

                <p>
                    Toutes les maisons et appartements publiés sur la plateforme
                    sont vérifiés pour garantir sécurité et fiabilité.
                </p>
            </div>

            <!-- CARD -->

            <div class="feature-card">
                <div class="feature-icon"></div>

                <h3>Locations partout au Togo</h3>

                <p>
                    Trouvez facilement des logements à Lomé, Kara,
                    Sokodé, Atakpamé et dans plusieurs autres villes.
                </p>
            </div>

            <!-- CARD -->

            <div class="feature-card">
                <div class="feature-icon"></div>

                <h3>Contact direct avec le propriétaire</h3>

                <p>
                    Discutez directement avec les propriétaires
                    sans intermédiaires compliqués.
                </p>
            </div>

            <!-- CARD -->

            <div class="feature-card">
                <div class="feature-icon"></div>

                <h3>Paiements sécurisés</h3>

                <p>
                    Réservez votre maison en toute confiance
                    grâce à des paiements fiables et sécurisés.
                </p>
            </div>

        </div>

        <!-- OFFERS -->

        <div class="offers-section">

            <div class="offers-content">

                <span class="offer-badge">
                    OFFRES SPÉCIALES AU TOGO
                </span>

                <h2>
                    Trouvez une maison à prix abordable
                </h2>

                <p>
                    Découvrez des villas, appartements meublés et maisons familiales
                    disponibles à des prix accessibles dans plusieurs quartiers populaires
                    de Lomé et des grandes villes du Togo.
                </p>

                <ul class="offer-list">
                    <li>✔️ Maisons meublées disponibles immédiatement</li>
                    <li>✔️ Réservation rapide et sécurisée</li>
                    <li>✔️ Prix adaptés à tous les budgets</li>
                    <li>✔️ Assistance client 7j/7</li>
                </ul>

                <a href="#maisons" class="offer-btn">
                    Explorer les maisons
                </a>

            </div>

            <!-- IMAGE -->

            <div class="offers-image">
                <img src="https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?q=80&w=1200"
                     alt="Maison moderne">
            </div>

        </div>

    </div>

</section>








<style>



/* ===================================
   SECTION AVANTAGES LOCATION TOGO
=================================== */

.why-section{
    background:#f5f7fb;
    padding:40px 80px;
}

.container{
    max-width:1300px;
    margin:auto;
}

/* TITLE */

.section-title{
    font-size:42px;
    color:#111827;
    margin-bottom:50px;
    font-weight:800;
}

/* FEATURES */

.features-grid{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:25px;
}

.feature-card{
    background:white;
    padding:35px 30px;
    border-radius:18px;
    transition:0.3s;
    border:1px solid #e5e7eb;
}

.feature-card:hover{
    transform:translateY(-6px);
    box-shadow:0 15px 35px rgba(0,0,0,0.08);
}

.feature-icon{
    font-size:45px;
    margin-bottom:20px;
}

.feature-card h3{
    font-size:24px;
    margin-bottom:15px;
    color:#111827;
}

.feature-card p{
    color:#6b7280;
    line-height:1.8;
    font-size:16px;
}

/* OFFERS */

.offers-section{
    margin-top:80px;
    background:white;
    border-radius:24px;
    padding:50px;
    display:flex;
    align-items:center;
    justify-content:space-between;
    gap:50px;
    border:1px solid #e5e7eb;
}

.offer-badge{
    background:#dbeafe;
    color:#2563eb;
    padding:10px 18px;
    border-radius:50px;
    font-size:14px;
    font-weight:600;
}

.offers-content h2{
    margin-top:25px;
    font-size:46px;
    line-height:1.2;
    color:#111827;
}

.offers-content p{
    margin-top:20px;
    color:#4b5563;
    line-height:1.9;
    font-size:18px;
    max-width:650px;
}

.offer-list{
    margin-top:25px;
    list-style:none;
}

.offer-list li{
    margin-bottom:15px;
    font-size:17px;
    color:#111827;
}

.offer-btn{
    display:inline-block;
    margin-top:30px;
    background:#2563eb;
    color:white;
    text-decoration:none;
    padding:18px 30px;
    border-radius:12px;
    font-weight:600;
    transition:0.3s;
}

.offer-btn:hover{
    background:#1d4ed8;
    transform:translateY(-2px);
}

/* IMAGE */

.offers-image img{
    width:420px;
    border-radius:20px;
    object-fit:cover;
    box-shadow:0 20px 40px rgba(0,0,0,0.15);
}

/* RESPONSIVE */

@media(max-width:1100px){

    .features-grid{
        grid-template-columns:repeat(2,1fr);
    }

    .offers-section{
        flex-direction:column;
        text-align:center;
    }

    .offers-content p{
        max-width:100%;
    }

    .offers-image img{
        width:100%;
    }
}

@media(max-width:768px){

    .why-section{
        padding:60px 20px;
    }

    .section-title{
        font-size:32px;
    }

    .features-grid{
        grid-template-columns:1fr;
    }

    .offers-content h2{
        font-size:34px;
    }

    .offers-content p{
        font-size:16px;
    }
}






</style>















































































    <!--<header>
        <h1>Maisons à louer</h1>
       

       

    </header>-->































<!-- ===================================
     SECTION À PROPOS - MaisonLoc
=================================== -->
<section class="about-section" id="Apropos">
    <div class="container">
        <div class="about-grid">
            
            <!-- IMAGE ET STATS -->
            <div class="about-visual">
                <div class="image-wrapper">
                    <img src="https://images.unsplash.com/photo-1560185007-c5ca9d2c014d?q=80&w=1200">
                    
                    <!-- Petit badge flottant de stats -->
                    <div class="stat-card">
                        <span class="stat-number">500+</span>
                        <span class="stat-label">Annonces vérifiées</span>
                    </div>
                </div>
            </div>

            <!-- TEXTE -->
            <div class="about-content">
                <span class="about-badge">QUI SOMMES-NOUS ?</span>
                <h2>La solution n°1 pour votre logement au Togo</h2>
                
                <p>
                    Lancée avec l'ambition de simplifier l'accès à l'immobilier, <strong>MaisonLoc</strong> est une plateforme dédiée à connecter les locataires et les propriétaires sur toute l'étendue du territoire togolais.
                </p>

                <div class="mission-box">
                    <div class="mission-item">
                        <div class="mission-dot"></div>
                        <div>
                            <h4>Notre Vision</h4>
                            <p>Éliminer les barrières et les intermédiaires informels pour une location transparente.</p>
                        </div>
                    </div>

                    <div class="mission-item">
                        <div class="mission-dot"></div>
                        <div>
                            <h4>Notre Engagement</h4>
                            <p>Sécurité totale : chaque annonce est manuellement validée par nos équipes locales.</p>
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

/* ===================================
   SECTION À PROPOS STYLE
=================================== */

.about-section {
    padding: 100px 80px;
    background: white; /* Alternance avec le gris clair des autres sections */
}

.about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    align-items: center;
    gap: 80px;
}

/* Visuel à gauche */
.about-visual {
    position: relative;
}

.image-wrapper {
    position: relative;
    padding: 20px;
}

.image-wrapper img {
    width: 100%;
    height: 500px;
    object-fit: cover;
    border-radius: 30px;
    box-shadow: 20px 20px 60px rgba(0,0,0,0.05);
}

.stat-card {
    position: absolute;
    bottom: -20px;
    right: -20px;
    background: #2563eb;
    color: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 15px 30px rgba(37, 99, 235, 0.3);
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 32px;
    font-weight: 800;
}

.stat-label {
    font-size: 14px;
    opacity: 0.9;
}

/* Contenu à droite */
.about-badge {
    color: #2563eb;
    font-weight: 700;
    letter-spacing: 1px;
    font-size: 14px;
    display: block;
    margin-bottom: 15px;
}

.about-content h2 {
    font-size: 40px;
    color: #111827;
    line-height: 1.2;
    margin-bottom: 25px;
    font-weight: 800;
}

.about-content p {
    color: #4b5563;
    font-size: 18px;
    line-height: 1.8;
    margin-bottom: 30px;
}

.mission-box {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.mission-item {
    display: flex;
    gap: 20px;
}

.mission-dot {
    width: 12px;
    height: 12px;
    background: #2563eb;
    border-radius: 50%;
    margin-top: 6px;
    flex-shrink: 0;
}

.mission-item h4 {
    font-size: 18px;
    color: #111827;
    margin-bottom: 5px;
}

.mission-item p {
    font-size: 16px;
    margin-bottom: 0;
}

.about-footer {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #f3f4f6;
}

.signature strong {
    display: block;
    font-size: 18px;
    color: #111827;
}

.signature span {
    color: #6b7280;
    font-size: 14px;
}

/* RESPONSIVE */

@media(max-width: 1100px) {
    .about-grid {
        grid-template-columns: 1fr;
        gap: 60px;
    }

    .about-visual {
        order: 2;
    }

    .about-content {
        order: 1;
        text-align: center;
    }

    .mission-item {
        text-align: left;
    }
    
    .image-wrapper img {
        height: 400px;
    }
}

@media(max-width: 768px) {
    .about-section {
        padding: 60px 20px;
    }

    .about-content h2 {
        font-size: 30px;
    }

    .stat-card {
        padding: 20px;
        right: 10px;
    }
}




</style>





























<section class="contact-section">


<!-- /* ===================================
   SECTION CONTACT LOCATION TOGO
=================================== */ -->

    <div class="container" id="contact">
        
        <h2 class="section-title">Contactez-nous</h2>

        <div class="contact-wrapper">
            
            <div class="contact-info">
                <h3>Besoin d'aide ?</h3>
                <p>Notre équipe togolaise est à votre écoute pour vous accompagner dans votre recherche de logement.</p>
                
                <div class="info-item">
                    <div class="info-icon">📞</div>
                    <div class="info-text">
                        <span>Appelez-nous</span>
                        <p>+228 91 30 40 00</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">✉️</div>
                    <div class="info-text">
                        <span>Email</span>
                        <p>contact@maisonloc.tg</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-text">
                        <span>Siège social</span>
                        <p>Quartier Agoè, Lomé - Togo</p>
                    </div>
                </div>

                <div class="social-links">
                    <small>Suivez-nous sur les réseaux sociaux</small>
                    <div class="social-icons">
                        <a href="#">FB</a>
                        <a href="#">WA</a>
                        <a href="#">IG</a>
                    </div>
                </div>
            </div>

            <div class="contact-form-container">
                <form class="contact-form">
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
                        <textarea rows="5" placeholder="Comment pouvons-nous vous aider ?" required></textarea>
                    </div>

                    <button type="submit" class="submit-btn">Envoyer le message</button>
                </form>
            </div>

        </div>
    </div>
</section>





<!-- /* ===================================
   SECTION CONTACT STYLE
=================================== */ -->


<style>
.contact-section {
    background: #f5f7fb; /* Même fond que Why-section */
    padding: 90px 80px;
}

.contact-wrapper {
    display: flex;
    gap: 60px;
    background: white;
    padding: 40px;
    border-radius: 24px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 10px 30px rgba(0,0,0,0.05);
}

/* Infos à gauche */
.contact-info {
    flex: 1;
    padding-right: 20px;
}

.contact-info h3 {
    font-size: 30px;
    color: #111827;
    margin-bottom: 15px;
}

.contact-info p {
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 40px;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 30px;
}

.info-icon {
    width: 50px;
    height: 50px;
    background: #f0f7ff;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.info-text span {
    display: block;
    font-size: 14px;
    color: #6b7280;
    margin-bottom: 2px;
}

.info-text p {
    margin: 0;
    font-weight: 700;
    color: #111827;
    font-size: 18px;
}

/* Formulaire à droite */
.contact-form-container {
    flex: 1.2;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-group label {
    font-weight: 600;
    font-size: 15px;
    color: #374151;
}

.form-group input, 
.form-group select, 
.form-group textarea {
    padding: 14px 18px;
    border-radius: 10px;
    border: 1px solid #d1d5db;
    font-size: 16px;
    transition: 0.3s;
    outline: none;
}

.form-group input:focus, 
.form-group select:focus, 
.form-group textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
}

.submit-btn {
    background: #2563eb;
    color: white;
    padding: 16px;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 16px;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
}

.submit-btn:hover {
    background: #1d4ed8;
    transform: translateY(-2px);
}

.social-links {
    margin-top: 40px;
    padding-top: 30px;
    border-top: 1px solid #e5e7eb;
}

.social-icons {
    display: flex;
    gap: 15px;
    margin-top: 15px;
}

.social-icons a {
    text-decoration: none;
    width: 40px;
    height: 40px;
    background: #111827;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    transition: 0.3s;
}

.social-icons a:hover {
    background: #2563eb;
}

/* RESPONSIVE */

@media(max-width: 1100px) {
    .contact-wrapper {
        flex-direction: column;
        padding: 30px;
    }
    
    .contact-info {
        padding-right: 0;
        text-align: center;
    }

    .info-item {
        justify-content: center;
    }

    .social-icons {
        justify-content: center;
    }
}

@media(max-width: 768px) {
    .contact-section {
        padding: 60px 20px;
    }
}


</style>












            <!-- MODALE DE CONNEXION -->
<div id="loginModal" class="modal-overlay">
    
  <div class="auth-card">
    <div class="close-modal" id="closeLogin">&times;</div>
    <div class="auth-header">
      <div class="icon-box">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3"/></svg>
      </div>
      <h3>Connexion</h3>
      <p>Heureux de vous revoir sur MaisonLoc</p>
    </div>

    <form method="POST" action="/login">
       @if(session('registre_ok'))
    <div style="background: #ecfdf5; color: #059669; padding: 12px; border-radius: 10px; border: 1px solid #10b981; margin-bottom: 20px; font-size: 14px; text-align: center;">
        ✨ Inscription réussie ! Connectez-vous maintenant.
    </div>
@endif
      @csrf
      @if($errors->any())
  <div class="error-message-box">
    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
    </svg>
    <span>Identifiants incorrects</span>
  </div>
@endif
      <div class="input-group">
        <label>Adresse e-mail</label>
        <input type="email" name="email" placeholder="votre@email.com" required autofocus>
      </div>
      <div class="input-group">
        <label>Mot de passe</label>
        <input type="password" name="password" placeholder="••••••••" required>
      </div>
      <div class="auth-options">
        <label class="checkbox-container">
          <input type="checkbox" name="remember"> <span class="checkmark"></span> Se souvenir de moi
        </label>
        <a href="{{ route('password.request') }}" class="forgot-link">Oublié ?</a>
      </div>
      <button type="submit" class="auth-btn">Se connecter</button>
    </form>
    <div class="auth-footer">Pas de compte ? <a href="javascript:void(0)" class="toggle-to-register">S'inscrire</a></div>
  </div>
</div>

<!-- MODALE D'INSCRIPTION -->
<div id="registerModal" class="modal-overlay">
  <div class="auth-card">
    <div class="close-modal" id="closeRegister">&times;</div>
    <div class="auth-header">
      <div class="icon-box register-icon">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="17" y1="11" x2="23" y2="11"/></svg>
      </div>
      <h3>Créer un compte</h3>
      <p>Rejoignez la communauté MaisonLoc</p>
    </div>

    @if($errors->register->any())
      <div class="error-message-box">
        <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
        </svg>
        <span>Les mots de passe ne correspondent pas</span>
      </div>
    @endif

    <form method="POST" action="/enregistrer/store" enctype="multipart/form-data">
      @csrf
      
      <div class="role-selector">
        <p>Avez-vous des maisons à louer ?</p>
        <div class="radio-group">
          <label class="radio-btn"><input type="radio" name="role" value="oui" {{ old('role') === 'oui' ? 'checked' : '' }} required> <span>Oui</span></label>
          <label class="radio-btn"><input type="radio" name="role" value="non" {{ old('role') === 'non' ? 'checked' : '' }} required> <span>Non</span></label>
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
  :root {
    --primary: #2563eb;
    --primary-soft: #eff6ff;
    --text-dark: #1e293b;
    --text-light: #64748b;
    --bg-card: #ffffff;
  }

  /* Messages d'erreur / succès */
  .success-message-box {
    background: #f0fdf4; color: #16a34a; padding: 10px 12px; border-radius: 12px;
    border: 1px solid #bbf7d0; font-size: 13px; font-weight: 600; margin-bottom: 15px;
    display: flex; align-items: center; gap: 8px;
  }
  .error-message-box {
    background: #fff1f2; color: #e11d48; padding: 10px 15px; border-radius: 12px;
    font-size: 13px; font-weight: 600; margin-bottom: 15px; display: flex;
    align-items: center; gap: 8px; border: 1px solid #ffe4e6;
  }

  /* Overlay & Card (Ajusté le padding de 40px à 30px) */
  .modal-overlay {
    display: none; position: fixed; inset: 0; z-index: 10000;
    background: rgba(15, 23, 42, 0.7); backdrop-filter: blur(8px);
    justify-content: center; align-items: center; padding: 20px;
  }
  .auth-card {
    background: var(--bg-card); width: 100%; max-width: 480px;
    border-radius: 24px; padding: 30px; position: relative;
    box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
    animation: slideUp 0.4s ease-out;
  }

  /* Header (Réduit la marge basse) */
  .auth-header { text-align: center; margin-bottom: 15px; }
  .icon-box {
    width: 48px; height: 48px; background: var(--primary-soft); color: var(--primary);
    border-radius: 12px; display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
  }
  .auth-header h3 { font-size: 22px; color: var(--text-dark); font-weight: 800; }
  .auth-header p { color: var(--text-light); font-size: 13px; margin-top: 3px; }

  /* Inputs (Espace vertical réduit de 18px à 12px) */
  .input-group { margin-bottom: 12px; flex: 1; }
  .input-row { display: flex; gap: 12px; }
  .input-group label { display: block; font-size: 12px; font-weight: 600; color: var(--text-dark); margin-bottom: 4px; }
  .input-group input {
    width: 100%; padding: 10px 14px; border-radius: 10px; border: 2px solid #f1f5f9;
    background: #f8fafc; font-size: 14px; transition: 0.2s;
  }
  .input-group input:focus { border-color: var(--primary); background: #fff; outline: none; }

  /* Role Selection (Plus compact) */
  .role-selector { background: #f1f5f9; padding: 10px; border-radius: 12px; margin-bottom: 15px; text-align: center; }
  .role-selector p { font-size: 12px; font-weight: 700; margin-bottom: 6px; }
  .radio-group { display: flex; justify-content: center; gap: 15px; }
  .radio-btn { cursor: pointer; font-weight: 600; color: var(--text-dark); font-size: 13px; }
  .radio-btn input { accent-color: var(--primary); margin-right: 4px; }

  /* Buttons & Actions */
  .auth-btn {
    width: 100%; padding: 12px; background: var(--primary); color: white;
    border: none; border-radius: 12px; font-weight: 700; cursor: pointer; transition: 0.3s;
    margin-top: 5px;
  }
  .auth-btn:hover { background: #1d4ed8; transform: translateY(-1px); }
  .auth-footer { margin-top: 15px; text-align: center; font-size: 13px; color: var(--text-light); }
  .auth-footer a { color: var(--primary); font-weight: 700; text-decoration: none; }

  .close-modal { position: absolute; top: 15px; right: 20px; font-size: 24px; cursor: pointer; color: var(--text-light); }
  @keyframes slideUp { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
  
</style>











<script>
    // 1. Initialisation des variables
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');

    // 2. Fonctions de base
    const showLogin = () => { loginModal.style.display = 'flex'; registerModal.style.display = 'none'; };
    const showRegister = () => { registerModal.style.display = 'flex'; loginModal.style.display = 'none'; };
    const closeAll = () => { loginModal.style.display = 'none'; registerModal.style.display = 'none'; };

    // 3. Événements de clic
    document.getElementById('openLoginBtn').onclick = showLogin;
    document.getElementById('openRegisterBtn').onclick = showRegister;
    document.getElementById('closeLogin').onclick = closeAll;
    document.getElementById('closeRegister').onclick = closeAll;

    // Basculements (liens dans les pieds de page des modales)
    document.querySelector('.toggle-to-register').onclick = (e) => { e.preventDefault(); showRegister(); };
    document.querySelector('.toggle-to-login').onclick = (e) => { e.preventDefault(); showLogin(); };

    // 4. LOGIQUE AUTOMATIQUE AU CHARGEMENT
    window.onload = () => {
        // Détection du succès d'inscription (Flash Session)
        @if(session('registre_ok'))
            console.log("Inscription réussie détectée");
            showLogin(); // On ouvre la connexion
            
        // Détection des erreurs d'inscription (Sac nommé 'register')
        @elseif($errors->register->any())
            showRegister();

        // Détection des erreurs de connexion (Sac par défaut)
        @elseif($errors->any())
            showLogin();
        @endif
    };

    // Fermeture clic extérieur
    window.onclick = (e) => {
        if (e.target == loginModal || e.target == registerModal) closeAll();
    };
</script>





















</body>



<!-- ===================================
     FOOTER - MaisonLoc
=================================== -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            
            <!-- COLONNE 1 : LOGO & DESCRIPTION -->
            <div class="footer-col about-col">
                <div class="footer-logo">
                    Maison<span>Loc</span>
                </div>
                <p>
                    La plateforme de référence pour la location immobilière au Togo. 
                    Nous rendons la recherche de logement simple, rapide et sécurisée pour tous.
                </p>
                <div class="footer-socials">
                    <a href="https://www.facebook.com/gerard.krettossmith" aria-label="Facebook" target="_blank">FB</a>
                    <a href="https://wa.me/22891304000" aria-label="WhatsApp" target="_blank">WA</a>
                    <a href="#" aria-label="Instagram">IG</a>
                    <a href="#" aria-label="LinkedIn">IN</a>
                </div>
            </div>
        

            <!-- COLONNE 2 : LIENS RAPIDES -->
            <div class="footer-col">
                <h4>Navigation</h4>
                <ul class="footer-links">
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Explorer les maisons</a></li>
                    <li><a href="#">À propos de nous</a></li>
                    <li><a href="#">Devenir partenaire</a></li>
                </ul>
            </div>

            <!-- COLONNE 3 : VILLES POPULAIRES -->
            <div class="footer-col">
                <h4>Villes populaires</h4>
                <ul class="footer-links">
                    <li><a href="#">Locations à Lomé</a></li>
                    <li><a href="#">Locations à Kara</a></li>
                    <li><a href="#">Locations à Sokodé</a></li>
                    <li><a href="#">Locations à Kpalimé</a></li>
                </ul>
            </div>

            <!-- COLONNE 4 : NEWSLETTER / CONTACT RAPIDE -->
            <div class="footer-col">
                <h4>Restez informé</h4>
                <p class="small-text">Inscrivez-vous pour recevoir les dernières offres immobilières au Togo.</p>
                <form class="newsletter-form">
                    <input type="email" placeholder="Votre email" required>
                    <button type="submit">S'inscrire</button>
                </form>
            </div>

        </div>

        <!-- BAS DU FOOTER -->
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
/* ===================================
   FOOTER STYLE
=================================== */

.main-footer {
    background: #111827; /* Noir bleuté profond */
    color: #e5e7eb;
    padding: 80px 80px 30px;
}

.footer-grid {
    display: grid;
    grid-template-columns: 1.5fr 1fr 1fr 1.5fr;
    gap: 50px;
    margin-bottom: 60px;
}

/* Colonne Logo/About */
.footer-logo {
    font-size: 28px;
    font-weight: 800;
    color: white;
    margin-bottom: 20px;
}

.footer-logo span {
    color: #3b82f6;
}

.about-col p {
    line-height: 1.7;
    color: #9ca3af;
    font-size: 15px;
    max-width: 300px;
}

/* Titres des colonnes */
.footer-col h4 {
    color: white;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 25px;
    position: relative;
}

.footer-col h4::after {
    content: '';
    position: absolute;
    left: 0;
    bottom: -8px;
    width: 30px;
    height: 2px;
    background: #3b82f6;
}

/* Liens */
.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links a {
    color: #9ca3af;
    text-decoration: none;
    transition: 0.3s;
    font-size: 15px;
}

.footer-links a:hover {
    color: white;
    padding-left: 5px;
}

/* Newsletter */
.small-text {
    font-size: 14px;
    color: #9ca3af;
    margin-bottom: 15px;
}

.newsletter-form {
    display: flex;
    gap: 10px;
}

.newsletter-form input {
    flex: 1;
    background: #1f2937;
    border: 1px solid #374151;
    padding: 12px 15px;
    border-radius: 8px;
    color: white;
    outline: none;
}

.newsletter-form button {
    background: #3b82f6;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.newsletter-form button:hover {
    background: #2563eb;
}

/* Réseaux Sociaux */
.footer-socials {
    display: flex;
    gap: 12px;
    margin-top: 25px;
}

.footer-socials a {
    width: 36px;
    height: 36px;
    background: #1f2937;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
    color: white;
    text-decoration: none;
    transition: 0.3s;
}

.footer-socials a:hover {
    background: #3b82f6;
    transform: translateY(-3px);
}

/* Bas du Footer */
.footer-bottom {
    padding-top: 30px;
    border-top: 1px solid #1f2937;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 14px;
    color: #6b7280;
}

.footer-legal {
    display: flex;
    gap: 25px;
}

.footer-legal a {
    color: #6b7280;
    text-decoration: none;
}

.footer-legal a:hover {
    color: #9ca3af;
}

/* RESPONSIVE */

@media(max-width: 1100px) {
    .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }
}

@media(max-width: 768px) {
    .main-footer {
        padding: 60px 20px 30px;
    }

    .footer-grid {
        grid-template-columns: 1fr;
        text-align: center;
    }

    .footer-col h4::after {
        left: 50%;
        transform: translateX(-50%);
    }

    .footer-socials, .newsletter-form {
        justify-content: center;
    }

    .footer-bottom {
        flex-direction: column;
        gap: 20px;
        text-align: center;
    }
}
</style>











</html>