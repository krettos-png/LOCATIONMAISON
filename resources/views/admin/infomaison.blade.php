<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DétailADMIN - Chambre Meublée à Lomé</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MaisonLoc</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="/admin/home">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- Titre + Galerie -->
  <div class="container mt-5" >
    <h1 class="mb-3" style="margin-top: 75px;">{{  $maisons->titre }}</h1>

    <!-- Carrousel d'images -->
    <!-- Carrousel principal -->
<!-- Carrousel principal -->
<!-- Carrousel principal -->
<div id="carouselChambre" class="carousel slide mb-3" data-bs-interval="false">
  <div class="carousel-inner text-center">
    {{-- Slide principal --}}
    <div class="carousel-item active">
      <img src="{{ asset('storage/' . $maisons->image) }}" class="img-fluid mx-auto d-block" style="max-height: 400px;" onclick="openModal(this.src)">
    </div>

    {{-- Slides secondaires dynamiques --}}
    @foreach($maisons->photos as $index => $photo)
      <div class="carousel-item">
        <img src="{{ asset('storage/' . $photo->chemin) }}" class="img-fluid mx-auto d-block" style="max-height: 400px;" onclick="openModal(this.src)">
      </div>
    @endforeach
  </div>

  <!-- Flèches -->
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselChambre" data-bs-slide="prev">
    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
    <span class="visually-hidden">Précédent</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselChambre" data-bs-slide="next">
    <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
    <span class="visually-hidden">Suivant</span>
  </button>
</div>

<!-- Miniatures synchronisées -->
<div class="row justify-content-center mt-3">
  <div class="col-auto">
    {{-- Miniature de l'image principale --}}
    <img src="{{ asset('storage/' . $maisons->image) }}" class="img-thumbnail" width="100" onclick="setSlide(0)">
  </div>

  @foreach($maisons->photos as $index => $photo)
    <div class="col-auto">
      <img src="{{ asset('storage/' . $photo->chemin) }}" class="img-thumbnail" width="100" onclick="setSlide({{ $index + 1 }})">
    </div>
  @endforeach
</div>

<!-- Script pour changer l'image avec les miniatures -->
<script>
  function setSlide(index) {
    const carouselEl = document.getElementById('carouselChambre');
    const carousel = bootstrap.Carousel.getInstance(carouselEl) || new bootstrap.Carousel(carouselEl);
    carousel.to(index);
  }
</script>




<!-- Modale pour zoomer -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-xl">
    <div class="modal-content bg-transparent border-0">
        <!-- Bouton Fermer -->
      <!-- Bouton Fermer personnalisé -->
<!-- Bouton Fermer -->


<div class="modal-body text-center">
<button type="button" class="btn-close position-absolute top-80 end-0 m-3" data-bs-dismiss="modal" aria-label="Fermer"></button>

        <img id="modalImage" src="" class="img-fluid rounded zoomable" alt="Zoom" style="max-width: 100%;">
      </div>
    </div>
  </div>
</div>


<!--Script pour afficher la modale-->
<script>
  function openModal(src) {
    const modalImage = document.getElementById('modalImage');
    modalImage.src = src;
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    modal.show();
  }
</script>




<!--Style Pour zoomer-->

<style>
  .zoomable {
    transition: transform 0.3s ease;
    cursor: zoom-in;
  }

  .zoomable:active {
    cursor: zoom-out;
  }

  #modalImage {
    transform-origin: center;
  }
</style>

<script>
  // Zoom avec la molette
  document.addEventListener('DOMContentLoaded', () => {
    const modalImg = document.getElementById('modalImage');
    let scale = 1;

    modalImg.addEventListener('wheel', function (e) {
      e.preventDefault();
      scale += e.deltaY * -0.001;
      scale = Math.min(Math.max(.5, scale), 5);
      this.style.transform = `scale(${scale})`;
    });

    // Reset zoom à la fermeture
    document.getElementById('imageModal').addEventListener('hidden.bs.modal', () => {
      modalImg.style.transform = 'scale(1)';
      scale = 1;
    });
  });
</script>


<!--scripte pour fermer la fenetre zoom kwwww-->















    <!-- Contenu -->
    <div class="row">
      <div class="col-md-8">
        <h4>Description</h4>
        <p>{{ $maisons->description }}</p>

       <h2> <span class="text-primary"> Adresse:   </span> {{ $maisons->adresse }}</h2>
<br>
<br>
        <h4>Localisation</h4>

        <div class="ratio ratio-16x9 mb-4">

        
<div id="map" style="height: 400px;" class="rounded border"></div>

<!-- Leaflet CSS + JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const lat = {{ $maisons->latitude }};
    const lng = {{ $maisons->longitude }};

    const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    });

    const satelliteLayer = L.tileLayer(
      'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
      {
        attribution: '© ESRI',
        maxZoom: 19
      }
    );

    const map = L.map('map', {
      center: [lat, lng],
      zoom: 15,
      layers: [streetLayer]
    });

    const baseMaps = {
      "Carte Classique": streetLayer,
      "Vue Satellite": satelliteLayer
    };
    L.control.layers(baseMaps).addTo(map);

    L.marker([lat, lng]).addTo(map).bindPopup("Position enregistrée").openPopup();
  });
</script>


          </div>
      </div>

      <!-- Infos complémentaires -->
      <div class="col-md-4">
        <div class="card shadow-sm mb-4">
          <div class="card-body">
            <h4 class="card-title">Prix</h4>
            <p class="card-text fs-4 text-success">{{ $maisons->prix }} FCFA / mois</p>
            <a href="#" class="btn btn-primary w-100">Réserver</a>
          </div>
        </div>
@if (Auth::check())
        <div class="card shadow-sm">
          <div class="card-body">
            <h3>Contact propriétaire</h3>
            <p><strong>Nom :</strong> {{ Auth::user()->name }} </p>
            <p><strong>Prenom :</strong> {{ Auth::user()->prenom }} </p>
            <p><strong>Téléphone :</strong> {{ Auth::user()->contact }} </p>
            <p><strong>Email :</strong> {{ Auth::user()->email }} </p>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-light text-center py-3 mt-5">
    <p class="mb-0">© 2025 MaisonLoc. Tous droits réservés.</p>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
