


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

        <nav class="nav-container">
            <div class="nav-links">
                <a href="#maisons">Maisons</a>
                
            </div>

            <div class="nav-buttons">
                <a href="/" class="btn-login">Accueil</a>
               
            </div>
        </nav>
    </header>

    <div class="hero-content">
        <span class="hero-badge">🏡 Trouvez votre logement idéal</span>
        <h1>Louez ou faites louer une maison moderne facilement</h1>
        <p>Découvrez des milliers de maisons, villas et appartements disponibles partout.</p>

        <form class="search-container">
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
        </form>
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
    min-height: 85vh;
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


























































































    <!--<header>
        <h1>Maisons à louer</h1>
       

       

    </header>-->

















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






    <section class="houses" id="maisons">
        @foreach($maisons as $maison)
    {{-- Modification du lien pour pointer vers la catégorie si nécessaire --}}
    <a class="reste" href="/maison/{{ $maison->id }}/infoA" class="house-card" style="text-decoration: none; color: inherit;">
        <div class="card">
            {{-- Image de la catégorie ou de la première maison --}}
             <img src="{{ asset('storage/' . $maison->image) }}" alt="{{ $maison->titre }}">
            
            {{-- On affiche le nom de la catégorie --}}
            <h3 style="text-align: center; padding: 15px 0;">
                 {{ $maison->titre ?? 'Maison Sans Titre' }}
            </h3>
            
            {{-- Petit badge ou texte descriptif --}}
            <div class="house-price">
                        
                        <div class="price-sub"> {{ number_format($maison->prix, 0, ',', ' ') }} FCFA  par mois</div>
                    </div>
            
            <button>Voir la catégorie</button>
        </div>
    </a>
    @endforeach
</section>

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















































</style>










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
                    <a href="#" aria-label="Facebook">FB</a>
                    <a href="#" aria-label="WhatsApp">WA</a>
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