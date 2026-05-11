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

    <!-- NAVBAR -->
    <header class="navbar">

        <div class="logo">
            <a href="{{ url('/') }}">
                MaisonLoc
            </a>
        </div>

        <nav class="nav-links">
            <a href="#">Maisons</a>
            <a href="#">Appartements</a>
            <a href="#">Villas</a>
            <a href="#">Contact</a>

        </nav>

        <div class="nav-buttons">
            <a href="/login" class="btn-login">Connexion</a>
            <a href="/inscription" class="btn-register">Publier un bien</a>
        </div>

    </header>

    <!-- HERO CONTENT -->

    <div class="hero-content">

        <span class="hero-badge">
            🏡 Trouvez votre logement idéal
        </span>

        <h1>
            Louez ou faite louer une maison moderne facilement
        </h1>

        <p>
            Découvrez des milliers de maisons, villas et appartements
            disponibles partout dans votre ville.
        </p>

        <!-- SEARCH BOX -->

        <form class="search-container">

            <div class="search-item">
                <i class="fa-solid fa-location-dot"></i>
                <input type="text" placeholder="Ville ou quartier">
            </div>

            <div class="search-item">
                <i class="fa-solid fa-calendar"></i>
                <input type="date">
            </div>

            <div class="search-item">
                <i class="fa-solid fa-house"></i>

                <select>
                    <option>Type de logement</option>
                    <option>Maison</option>
                    <option>Appartement</option>
                    <option>Villa</option>
                </select>
            </div>

            <button type="submit" class="search-btn">
                Rechercher
            </button>

        </form>

    </div>

</section>

<!-- FONT AWESOME -->












<style>


/* =========================
   STYLE LOCATION MAISON
========================= */


*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins',sans-serif;
    background:#f4f7fb;
}

/* HERO */

.hero-rental{
    min-height:10vh;
    background:
    linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)),
    url('https://images.unsplash.com/photo-1568605114967-8130f3a36994?q=80&w=2070');
    
    background-size:cover;
    background-position:center;
    padding:30px 80px;
    color:white;
    position:relative;
}

/* NAVBAR */

.navbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
}

.logo a{
    color:white;
    text-decoration:none;
    font-size:34px;
    font-weight:700;
}

.nav-links{
    display:flex;
    gap:35px;
}

.nav-links a{
    color:white;
    text-decoration:none;
    font-weight:500;
    transition:0.3s;
}

.nav-links a:hover{
    opacity:0.8;
}

.nav-buttons{
    display:flex;
    gap:15px;
}

.btn-login{
    color:white;
    text-decoration:none;
    font-weight:500;
    padding:12px 18px;
}

.btn-register{
    background:white;
    color:#111827;
    padding:12px 20px;
    border-radius:10px;
    text-decoration:none;
    font-weight:600;
}

/* HERO CONTENT */

.hero-content{
    margin-top:120px;
    max-width:850px;
}

.hero-badge{
    background:rgba(255,255,255,0.15);
    padding:10px 18px;
    border-radius:50px;
    backdrop-filter:blur(10px);
    font-size:14px;
}

.hero-content h1{
    font-size:60px;
    line-height:1.1;
    margin-top:25px;
    font-weight:800;
}

.hero-content p{
    margin-top:25px;
    font-size:22px;
    line-height:1.7;
    color:#f1f1f1;
}

/* SEARCH BOX */

.search-container{
    margin-top:50px;
    background:white;
    border-radius:18px;
    padding:5px;
    display:flex;
    align-items:center;
    box-shadow:0 20px 40px rgba(0,0,0,0.2);
    gap:10px;
}

.search-item{
    flex:1;
    display:flex;
    align-items:center;
    gap:12px;
    padding:18px 20px;
    border-right:1px solid #e5e7eb;
}

.search-item:last-child{
    border-right:none;
}

.search-item i{
    color:#6b7280;
    font-size:18px;
}

.search-item input,
.search-item select{
    border:none;
    outline:none;
    width:100%;
    font-size:16px;
    color:#111827;
    background:none;
}

.search-btn{
    background:#2563eb;
    color:white;
    border:none;
    padding:22px 35px;
    border-radius:14px;
    cursor:pointer;
    font-size:18px;
    font-weight:600;
    transition:0.3s;
}

.search-btn:hover{
    background:#1d4ed8;
    transform:translateY(-2px);
}

/* RESPONSIVE */

@media(max-width:1100px){

    .hero-rental{
        padding:30px;
    }

    .hero-content h1{
        font-size:52px;
    }

    .search-container{
        flex-direction:column;
        align-items:stretch;
    }

    .search-item{
        border-right:none;
        border-bottom:1px solid #eee;
    }

    .search-btn{
        width:100%;
    }
}

@media(max-width:768px){

    .navbar{
        flex-direction:column;
        gap:25px;
    }

    .nav-links{
        display:none;
    }

    .hero-content{
        margin-top:80px;
    }

    .hero-content h1{
        font-size:40px;
    }

    .hero-content p{
        font-size:18px;
    }
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
                <div class="feature-icon">🏠</div>

                <h3>Maisons vérifiées</h3>

                <p>
                    Toutes les maisons et appartements publiés sur la plateforme
                    sont vérifiés pour garantir sécurité et fiabilité.
                </p>
            </div>

            <!-- CARD -->

            <div class="feature-card">
                <div class="feature-icon">📍</div>

                <h3>Locations partout au Togo</h3>

                <p>
                    Trouvez facilement des logements à Lomé, Kara,
                    Sokodé, Atakpamé et dans plusieurs autres villes.
                </p>
            </div>

            <!-- CARD -->

            <div class="feature-card">
                <div class="feature-icon">💬</div>

                <h3>Contact direct avec le propriétaire</h3>

                <p>
                    Discutez directement avec les propriétaires
                    sans intermédiaires compliqués.
                </p>
            </div>

            <!-- CARD -->

            <div class="feature-card">
                <div class="feature-icon">🔒</div>

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
                    Trouvez une maison moderne à prix abordable
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

                <a href="#" class="offer-btn">
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
    padding:90px 80px;
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

















    <section class="houses">
        @foreach($maisons as $maison)
        <a href="/maison/{{ $maison->id }}/info" style="text-decoration: none; color: inherit;">
            <div class="card">
                <img src="{{ asset('storage/' . $maison->image) }}" alt="{{ $maison['TITRE'] }}">
                <h2>{{ $maison['titre'] }}</h2>
                <p>{{ $maison['description'] }}</p>
                <p><strong>{{ $maison['prix'] }} FCFA/mois</strong></p>
                <button onclick="bookNow('{{ $maison['adresse'] }}')">En Savoir Plus</button>
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

/*header {
    margin-top :55px;
    background: #2c3e50;

    color: white;
    padding: 20px;
    text-align: center;
}*/

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
</body>
</html>