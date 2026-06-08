<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MaisonLoc - {{ $maisons->titre }}</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
  
  <style>
    :root {
      --primary-color: #4F46E5;
      --whatsapp-color: #25D366;
      --whatsapp-hover: #128C7E;
      --phone-color: #0EA5E9;
      --phone-hover: #0284C7;
      --email-color: #64748B;
      --email-hover: #475569;
      --text-dark: #1F2937;
      --text-muted: #4B5563;
      --bg-light: #F9FAFB;
    }

    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background-color: var(--bg-light);
      color: var(--text-dark);
      padding-top: 90px;
    }

    /* Navbar Moderne */
    .navbar {
      background: rgba(255, 255, 255, 0.8) !important;
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    .navbar-brand {
      font-weight: 800;
      color: var(--primary-color) !important;
      letter-spacing: -0.5px;
    }
    .nav-link {
      color: var(--text-dark) !important;
      font-weight: 500;
    }
    .nav-link.active {
      color: var(--primary-color) !important;
      font-weight: 700;
    }

    /* Blocs de contenu modernes */
    .modern-card {
      background: #ffffff;
      border: 1px solid rgba(0, 0, 0, 0.04);
      border-radius: 16px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
      padding: 24px;
    }
    .section-title {
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 16px;
      color: var(--text-dark);
      letter-spacing: -0.3px;
    }

    /* Bouton WhatsApp Premium */
    .btn-whatsapp {
      background-color: var(--whatsapp-color) !important;
      border: none !important;
      color: white !important;
      font-weight: 600;
      font-size: 1.05rem;
      padding: 14px 24px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 8px 20px rgba(37, 211, 102, 0.25);
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-whatsapp:hover {
      background-color: var(--whatsapp-hover) !important;
      transform: translateY(-2px);
      box-shadow: 0 12px 24px rgba(37, 211, 102, 0.35);
    }

    /* Bouton Appeler Premium */
    .btn-phone {
      background-color: var(--phone-color) !important;
      border: none !important;
      color: white !important;
      font-weight: 600;
      font-size: 1.05rem;
      padding: 14px 24px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 8px 20px rgba(14, 165, 233, 0.25);
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-phone:hover {
      background-color: var(--phone-hover) !important;
      transform: translateY(-2px);
      box-shadow: 0 12px 24px rgba(14, 165, 233, 0.35);
    }

    /* Bouton Email Premium */
    .btn-email {
      background-color: var(--email-color) !important;
      border: none !important;
      color: white !important;
      font-weight: 600;
      font-size: 1.05rem;
      padding: 14px 24px;
      border-radius: 12px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      box-shadow: 0 8px 20px rgba(100, 116, 139, 0.25);
      transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .btn-email:hover {
      background-color: var(--email-hover) !important;
      transform: translateY(-2px);
      box-shadow: 0 12px 24px rgba(100, 116, 139, 0.35);
    }

    /* Style d'origine pour le zoom */
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

    /* Bouton fermer de la modale ajusté */
    .custom-close-btn {
      background-color: rgba(0, 0, 0, 0.6) !important;
      border-radius: 50%;
      padding: 12px;
      z-index: 1060;
      opacity: 0.85;
      transition: opacity 0.2s;
    }
    .custom-close-btn:hover {
      opacity: 1;
    }

    /* Badges pour les statistiques */
    .stat-box {
      background-color: #F3F4F6;
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 0.95rem;
    }

    /* Design de la Carte Leaflet */
    #map {
      border-radius: 14px;
      overflow: hidden;
    }
  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg fixed-top py-3">
    <div class="container">
      <a class="navbar-brand" href="#">MaisonLoc</a>
      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="/">Accueil</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-4">
    <h1 class="fw-800 display-6 mb-4 text-break" style="letter-spacing: -1px;">{{ $maisons->titre }}</h1>

    <div id="carouselChambre" class="carousel slide mb-3" data-bs-interval="false">
      <div class="carousel-inner text-center">
        {{-- Slide principal --}}
        <div class="carousel-item active">
          <img src="{{ asset('storage/' . $maisons->image) }}" class="img-fluid mx-auto d-block" style="max-height: 340px;" onclick="openModal(this.src)">
        </div>

        {{-- Slides secondaires dynamiques --}}
        @foreach($maisons->photos as $index => $photo)
          <div class="carousel-item">
            <img src="{{ asset('storage/' . $photo->chemin) }}" class="img-fluid mx-auto d-block" style="max-height: 340px;" onclick="openModal(this.src)">
          </div>
        @endforeach
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselChambre" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
        <span class="visually-hidden">Précédent</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselChambre" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
        <span class="visually-hidden">Suivant</span>
      </button>
    </div>

    <div class="row justify-content-center g-2 mt-3 mb-5">
      <div class="col-auto">
        <img src="{{ asset('storage/' . $maisons->image) }}" class="img-thumbnail" width="75" style="cursor: pointer;" onclick="setSlide(0)">
      </div>
      @foreach($maisons->photos as $index => $photo)
        <div class="col-auto">
          <img src="{{ asset('storage/' . $photo->chemin) }}" class="img-thumbnail" width="75" style="cursor: pointer;" onclick="setSlide({{ $index + 1 }})">
        </div>
      @endforeach
    </div>

    <div class="row g-4">
      
      <div class="col-lg-8">
        <div class="modern-card mb-4">
          <h4 class="section-title">Description</h4>
          <p class="text-secondary lh-lg mb-0 text-break" style="white-space: pre-line; font-size: 1.05rem;">{{ $maisons->description }}</p>
        </div>

        <div class="modern-card mb-4">
          <h4 class="section-title"><span class="text-primary">Ville :</span> {{ $maisons->ville }}</h4>
        </div>

        <div class="modern-card mb-4">
          <h4 class="section-title"><span class="text-primary">Quartier :</span> {{ $maisons->adresse }}</h4>
        </div>

        <div class="modern-card mb-4">
          <h4 class="section-title">Localisation</h4>
          <div class="ratio ratio-16x9 rounded" style="min-height: 300px;">
            <div id="map" class="w-100 h-100"></div>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        
        <div class="modern-card mb-4">
          <h4 class="section-title" style="font-size: 1.1rem;">Statistiques du bien</h4>
          <div class="d-flex flex-column gap-2">
            <div class="d-flex align-items-center justify-content-between stat-box">
              <span class="text-muted">👁️ Vues de l'annonce</span>
              <span class="fw-bold">{{ $maisons->vues }}</span>
            </div>
            <div class="d-flex align-items-center justify-content-between stat-box">
              <span class="text-muted">📅 Visites demandées</span>
              <span class="fw-bold text-primary">{{ $maisons->visites_demandees }}</span>
            </div>
          </div>
        </div>

        <div class="modern-card mb-4 border-top border-4 border-primary">
          <span class="text-uppercase tracking-wider text-muted fw-bold small">Prix</span>
          <div class="d-flex align-items-baseline my-2">
            <span class="fs-2 fw-800 text-success">{{ number_format($maisons->prix, 0, ',', ' ') }}</span>
            <span class="ms-2 text-muted fw-medium">FCFA / mois</span>
          </div>

          @php $isRented = ($maisons->est_loue == 1); @endphp

          @if($isRented)
              
          @else

           



          <div class="d-flex flex-column gap-2 mt-3">
            <a href="{{ route('maisons.visite', ['id' => $maisons->id]) }}" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp w-100 py-3">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.4-4.19-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.182 8.182 0 0 1-1.26-4.38c0-4.54 3.7-8.22 8.25-8.22m-3.61 4.62c-.2 0-.33.07-.5.26c-.18.19-.69.67-.69 1.63c0 .96.7 1.88.8 2.01c.09.13 1.36 2.08 3.3 2.91c.47.2 1 .34 1.34.45c.49.15.93.13 1.29.08c.39-.06 1.21-.5 1.38-.97c.17-.47.17-.87.12-.96c-.05-.08-.18-.13-.38-.23c-.19-.1-.1.41-.65-.6c-.08-.13-.17-.23-.27-.23c-.1 0-.17.05-.51.22c-.34.17-.58.28-.79.06c-.13-.13-1.49-1.52-2.03-2.01c-.42-.37-.09-.59.13-.81c.21-.21.43-.49.54-.74c.1-.25.05-.48-.02-.63c-.07-.15-.56-1.35-.77-1.85c-.2-.51-.42-.43-.57-.44c-.14-.01-.3-.01-.47-.01Z"/>
              </svg>
              Réserver via WhatsApp
            </a>

            <a href="tel:+22891304000" class="btn btn-phone w-100 py-3">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24c1.12.37 2.33.57 3.57.57c.55 0 1 .45 1 1V20c0 .55-.45 1-1 1c-9.39 0-17-7.61-17-17c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02l-2.2 2.2Z"/>
              </svg>
              Appeler directement
            </a>

            <a href="mailto:contact@maisonloc.com?subject=Réservation%20-%20{{ urlencode($maisons->titre) }}&body=Bonjour,%20je%20souhaite%20avoir%20plus%20d'informations%20concernant%20l'annonce%20:%20{{ urlencode($maisons->titre) }}" class="btn btn-email w-100 py-3">
              <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5v2Z"/>
              </svg>
              Envoyer un message
            </a>
          </div>
          @endif
        </div>

        @if (Auth::check())
        <div class="modern-card">
          <h3 class="h5 fw-bold mb-3 text-secondary">Contact propriétaire</h3>
          <p class="mb-1"><strong>Nom :</strong> {{ Auth::user()->name }} </p>
          <p class="mb-1"><strong>Prenom :</strong> {{ Auth::user()->prenom }} </p>
          <p class="mb-1"><strong>Téléphone :</strong> {{ Auth::user()->contact }} </p>
          <p class="mb-1"><strong>Téléphone :</strong> {{ $maisons->utilisateur_id }} </p>

          <p class="mb-0"><strong>Email :</strong> <span class="text-break">{{ Auth::user()->email }}</span></p>
        </div>
        @endif

      </div>
    </div>
  </div>

  <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
      <div class="modal-content bg-transparent border-0">
        <div class="modal-body text-center position-relative p-0">
          <button type="button" class="btn-close btn-close-white custom-close-btn position-fixed top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Fermer"></button>
          <img id="modalImage" src="" class="img-fluid rounded zoomable" alt="Zoom" style="max-width: 100%; max-height: 85vh;">
        </div>
      </div>
    </div>
  </div>

  <footer class="bg-light text-center py-3 mt-5 border-top">
    <p class="mb-0 text-muted">© 2026 MaisonLoc. Tous droits réservés.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
    // Script des miniatures
    function setSlide(index) {
      const carouselEl = document.getElementById('carouselChambre');
      const carousel = bootstrap.Carousel.getInstance(carouselEl) || new bootstrap.Carousel(carouselEl);
      carousel.to(index);
    }

    // Script d'ouverture modale
    function openModal(src) {
      const modalImage = document.getElementById('modalImage');
      modalImage.src = src;
      const modal = new bootstrap.Modal(document.getElementById('imageModal'));
      modal.show();
    }

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

      document.getElementById('imageModal').addEventListener('hidden.bs.modal', () => {
        modalImg.style.transform = 'scale(1)';
        scale = 1;
      });
    });

    // Script de la carte Leaflet
    document.addEventListener('DOMContentLoaded', function () {
      const lat = {{ $maisons->latitude }};
      const lng = {{ $maisons->longitude }};

      const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
      });

      const satelliteLayer = L.tileLayer(
        'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        { attribution: '© ESRI', maxZoom: 19 }
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
  
</body>
</html>