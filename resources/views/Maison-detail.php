<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>DétailaA - Chambre Meublée à Lomé</title>
  <link rel="stylesheet" href="{{ asset('css/maison-detail.css') }}" />
 <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />-->
</head>
<body>

  <nav class="navbar">
    <div class="navbar-container">
      <a class="brand" href="#">MaisonLocnn</a>
      <div class="nav-links">
        <a href="/acd" class="nav-link active">Accueil</a>
        <a href="#" class="nav-link">Contact</a>
      </div>
    </div>
  </nav>

  <main class="container">
    <h1 class="main-title">{{ $maisons->titre }}</h1>

    <div class="carousel" id="carouselChambre">
      <img class="carousel-image active" src="{{ asset('storage/' . $maisons->image) }}" onclick="openModal(this.src)" />

      @foreach($maisons->photos as $photo)
        <img class="carousel-image" src="{{ asset('storage/' . $photo->chemin) }}" onclick="openModal(this.src)" />
      @endforeach

      <button class="carousel-btn prev" onclick="prevSlide()">&#10094;</button>
      <button class="carousel-btn next" onclick="nextSlide()">&#10095;</button>
    </div>

    <div class="thumbnails">
      <img src="{{ asset('storage/' . $maisons->image) }}" onclick="setSlide(0)" />
      @foreach($maisons->photos as $index => $photo)
        <img src="{{ asset('storage/' . $photo->chemin) }}" onclick="setSlide({{ $index + 1 }})" />
      @endforeach
    </div>

    <div id="imageModal" class="modal">
      <span class="close" onclick="closeModal()">&times;</span>
      <img class="modal-content" id="modalImage" />
    </div>

    <div class="row">
      <div class="column">
        <h4>Description</h4>
        <p>{{ $maisons->description }}</p>
        <h2><span class="text-primary">Adresse:</span> {{ $maisons->adresse }}</h2>

        <h4>Localisation</h4>
        <div id="map" data-last="{{ $maisons->latitude }}" data-lng="{{ $maisons->longitude }}"></div>
      </div>

      <div class="column side">
        <div class="card">
          <h4>Prix</h4>
          <p class="price">{{ $maisons->prix }} FCFA / mois</p>
          <button>Réserver</button>
        </div>

        <div class="card">
          <h5>Contact propriétaireDD</h5>
          <p><strong>Nom :</strong></p>
          <p><strong>Prénom :</strong> g</p>
          <p><strong>Téléphone :</strong> +228 g</p>
          <p><strong>Email :</strong> g</p>
        </div>
      </div>
    </div>
  </main>

  <footer>
    <p>© 2025 MaisonLoc. Tous droits réservés.</p>
  </footer>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="maison-detail.js"></script>






  

<style>
  
</style>




















  
</body>
</html>