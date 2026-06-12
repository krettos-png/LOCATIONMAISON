<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MaisonLoc - {{ $maisons->titre }}</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  
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

    /* Badges de caractéristiques */
    .feature-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 10px 16px;
      border-radius: 12px;
      font-size: 0.9rem;
      font-weight: 600;
      background: #F3F4F6;
      color: #374151;
      border: 1px solid #E5E7EB;
    }
    .feature-badge i {
      font-size: 1.05rem;
    }
    .feature-badge.available {
      background: #EEF2FF;
      color: var(--primary-color);
      border-color: #E0E7FF;
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

    .stat-box {
      background-color: #F3F4F6;
      border-radius: 10px;
      padding: 10px 14px;
      font-size: 0.95rem;
    }

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
            <a class="nav-link active" href="javascript:window.history.back();">
              <i class="fa-solid fa-arrow-left me-1"></i> Retour
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-4">
    <h1 class="fw-800 display-6 mb-4 text-break" style="letter-spacing: -1px;">{{ $maisons->titre }}</h1>

    <div id="carouselChambre" class="carousel slide mb-3" data-bs-interval="false">
      <div class="carousel-inner text-center">
        <div class="carousel-item active">
          <img src="{{ asset($maisons->image) }}" class="img-fluid mx-auto d-block" style="max-height: 340px;" onclick="openModal(this.src)">
        </div>

        @foreach($maisons->photos as $index => $photo)
          <div class="carousel-item">
            <img src="{{ asset($photo->chemin) }}" class="img-fluid mx-auto d-block" style="max-height: 340px;" onclick="openModal(this.src)">
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
        <img src="{{ asset($maisons->image) }}" class="img-thumbnail" width="75" style="cursor: pointer;" onclick="setSlide(0)">
      </div>
      @foreach($maisons->photos as $index => $photo)
        <div class="col-auto">
          <img src="{{ asset($photo->chemin) }}" class="img-thumbnail" width="75" style="cursor: pointer;" onclick="setSlide({{ $index + 1 }})">
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
          <h4 class="section-title">Caractéristiques du logement</h4>
          <div class="d-flex flex-wrap gap-2">
            <div class="feature-badge {{ $maisons->immeuble_etage ? 'available' : '' }}">
              <i class="fa-solid fa-building"></i> Immeuble à étage : <strong>{{ $maisons->immeuble_etage ? 'Oui' : 'Non' }}</strong>
            </div>
            <div class="feature-badge {{ $maisons->meuble ? 'available' : '' }}">
              <i class="fa-solid fa-chair"></i> Meublé : <strong>{{ $maisons->meuble ? 'Oui' : 'Non' }}</strong>
            </div>
            <div class="feature-badge {{ $maisons->climatise ? 'available' : '' }}">
              <i class="fa-solid fa-snowflake"></i> Climatisé : <strong>{{ $maisons->climatise ? 'Oui' : 'Non' }}</strong>
            </div>
            <div class="feature-badge {{ $maisons->sanitaire ? 'available' : '' }}">
              <i class="fa-solid fa-restroom"></i> Sanitaire intégré : <strong>{{ $maisons->sanitaire ? 'Oui' : 'Non' }}</strong>
            </div>
            <div class="feature-badge {{ $maisons->adapte_pmr ? 'available' : '' }}">
              <i class="fa-solid fa-wheelchair"></i> Accès PMR : <strong>{{ $maisons->adapte_pmr ? 'Oui' : 'Non' }}</strong>
            </div>
            <div class="feature-badge {{ $maisons->compteur_elec_perso ? 'available' : '' }}">
              <i class="fa-solid fa-bolt"></i> Compteur Élec Personnel : <strong>{{ $maisons->compteur_elec_perso ? 'Oui' : 'Commun' }}</strong>
            </div>
            <div class="feature-badge {{ $maisons->compteur_eau_perso ? 'available' : '' }}">
              <i class="fa-solid fa-droplet"></i> Compteur Eau Personnel : <strong>{{ $maisons->compteur_eau_perso ? 'Oui' : 'Commun' }}</strong>
            </div>
          </div>
        </div>

        <div class="row g-4 mb-4">
          <div class="col-md-6">
            <div class="modern-card h-100">
              <h4 class="section-title"><i class="fa-solid fa-city text-primary me-2"></i>Ville</h4>
              <p class="fs-5 fw-bold mb-0 text-uppercase">{{ $maisons->ville ?? 'Non spécifiée' }}</p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="modern-card h-100">
              <h4 class="section-title"><i class="fa-solid fa-location-dot text-primary me-2"></i>Quartier</h4>
              <p class="fs-5 fw-bold mb-0 text-capitalize">{{ $maisons->adresse }}</p>
            </div>
          </div>
        </div>

        <div class="modern-card mb-4">
          <h4 class="section-title">Localisation précise</h4>
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
          <span class="text-uppercase tracking-wider text-muted fw-bold small">Prix du Loyer</span>
          <div class="d-flex align-items-baseline my-2">
            <span class="fs-2 fw-800 text-success">{{ number_format($maisons->prix, 0, ',', ' ') }}</span>
            <span class="ms-2 text-muted fw-medium">FCFA / mois</span>
          </div>

          <div class="mt-4 pt-3 border-top">
            <h5 class="fw-bold mb-3 style" style="font-size: 0.95rem; color: var(--text-dark);">Conditions financières :</h5>
            <table class="table table-borderless table-sm mb-0" style="font-size: 0.9rem;">
              <tbody>
                @if($maisons->caution_mois)
                <tr>
                  <td class="text-muted ps-0">Mois de caution :</td>
                  <td class="text-end fw-bold">{{ $maisons->caution_mois }} mois</td>
                </tr>
                @endif
                @if($maisons->prepaiement_mois)
                <tr>
                  <td class="text-muted ps-0">Avance / Prépaiement :</td>
                  <td class="text-end fw-bold">{{ $maisons->prepaiement_mois }} mois</td>
                </tr>
                @endif
                @if($maisons->frais_visite)
                <tr>
                  <td class="text-muted ps-0">Frais de visite :</td>
                  <td class="text-end fw-bold text-danger">{{ number_format($maisons->frais_visite, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
                @if($maisons->commission)
                <tr>
                  <td class="text-muted ps-0">Commission agence :</td>
                  <td class="text-end fw-bold">{{ number_format($maisons->commission, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
                @if($maisons->caution_elec)
                <tr>
                  <td class="text-muted ps-0">Caution Électricité :</td>
                  <td class="text-end fw-semibold">{{ number_format($maisons->caution_elec, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
                @if($maisons->caution_eau)
                <tr>
                  <td class="text-muted ps-0">Caution Eau :</td>
                  <td class="text-end fw-semibold">{{ number_format($maisons->caution_eau, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
                @if($maisons->caution_elec_eau)
                <tr>
                  <td class="text-muted ps-0">Caution Élec + Eau :</td>
                  <td class="text-end fw-semibold">{{ number_format($maisons->caution_elec_eau, 0, ',', ' ') }} FCFA</td>
                </tr>
                @endif
              </tbody>
            </table>
          </div>

          @php $isRented = ($maisons->est_loue == 1); @endphp

          @if($isRented)
            <div class="alert alert-danger text-center fw-bold mt-3 mb-0">Déjà loué 🔴</div>
          @else
            <div class="mt-4">
                <button type="button" class="btn btn-primary w-100 py-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2" data-bs-toggle="modal" data-bs-target="#modalePrudence">
                    <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20,2H4A2,2 0 0,0 2,4V22L6,18H20A2,2 0 0,0 22,16V4A2,2 0 0,0 20,2M20,16H5.2L4,17.2V4H20V16Z"/>
                    </svg>
                    Contacter le propriétaire
                </button>
            </div>

            <div class="modal fade" id="modalePrudence" tabindex="-1" aria-labelledby="modalePrudenceLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow-lg">
                        <div class="modal-header bg-warning text-dark border-0">
                            <h5 class="modal-title fw-bold d-flex align-items-center gap-2" id="modalePrudenceLabel">
                                <span>⚠️</span> Consignes de sécurité
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body p-4 text-center">
                            <div class="text-warning mb-3">
                                <svg style="width:64px;height:64px" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12,2L1,21H23M12,6L19.8,19H4.2M11,10V14H13V10M11,16V18H13V16"/>
                                </svg>
                            </div>
                            <h5 class="fw-bold text-danger mb-3">Ne versez jamais d'argent à l'avance !</h5>
                            <p class="text-muted mb-0">
                                Pour votre sécurité, ne payez **aucun frais de visite, de dossier ou d'avance de caution** avant d'avoir visité physiquement le logement et vérifié l'identité du propriétaire.
                            </p>
                        </div>
                        
                        <div class="modal-footer flex-column gap-2 border-0 p-4 pt-0">
                            <p class="small text-secondary mb-2">Si vous acceptez ces consignes, choisissez votre moyen de contact :</p>
                            
                            <a href="{{ route('maisons.visite', ['id' => $maisons->id]) }}" target="_blank" rel="noopener noreferrer" class="btn btn-whatsapp w-100 py-2.5 fw-semibold text-white d-flex align-items-center justify-content-center gap-2" style="background-color: #25D366;">
                                <svg style="width:20px;height:20px" viewBox="0 0 24 24"><path fill="currentColor" d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21c5.46 0 9.91-4.45 9.91-9.91c0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0 0 12.04 2m.01 1.67c2.2 0 4.26.86 5.82 2.42a8.225 8.225 0 0 1 2.41 5.83c0 4.54-3.7 8.23-8.24 8.23c-1.48 0-2.93-.4-4.19-1.15l-.3-.18l-3.12.82l.83-3.04l-.2-.31a8.182 8.182 0 0 1-1.26-4.38c0-4.54 3.7-8.22 8.25-8.22m-3.61 4.62c-.2 0-.33.07-.5.26c-.18.19-.69.67-.69 1.63c0 .96.7 1.88.8 2.01c.09.13 1.36 2.08 3.3 2.91c.47.2 1 .34 1.34.45c.49.15.93.13 1.29.08c.39-.06 1.21-.5 1.38-.97c.17-.47.17-.87.12-.96c-.05-.08-.18-.13-.38-.23c-.19-.1-.1.41-.65-.6c-.08-.13-.17-.23-.27-.23c-.1 0-.17.05-.51.22c-.34.17-.58.28-.79.06c-.13-.13-1.49-1.52-2.03-2.01c-.42-.37-.09-.59.13-.81c.21-.21.43-.49.54-.74c.1-.25.05-.48-.02-.63c-.07-.15-.56-1.35-.77-1.85c-.2-.51-.42-.43-.57-.44c-.14-.01-.3-.01-.47-.01Z"/></svg>
                                Réserver via WhatsApp
                            </a>

                            <a href="tel:+22891304000" class="btn btn-dark w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <svg style="width:20px;height:20px" viewBox="0 0 24 24"><path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24c1.12.37 2.33.57 3.57.57c.55 0 1 .45 1 1V20c0 .55-.45 1-1 1c-9.39 0-17-7.61-17-17c0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02l-2.2 2.2Z"/></svg>
                                Appeler directement
                            </a>

                            <a href="mailto:contact@maisonloc.com?subject=Réservation%20-%20{{ urlencode($maisons->titre) }}&body=Bonjour..." class="btn btn-outline-secondary w-100 py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2">
                                <svg style="width:20px;height:20px" viewBox="0 0 24 24"><path fill="currentColor" d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2m0 4l-8 5l-8-5V6l8 5l8-5v2Z"/></svg>
                                Envoyer un message
                            </a>
                        </div>
                    </div>
                </div>
            </div>
          @endif
        </div>

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
    function setSlide(index) {
      const carouselEl = document.getElementById('carouselChambre');
      const carousel = bootstrap.Carousel.getInstance(carouselEl) || new bootstrap.Carousel(carouselEl);
      carousel.to(index);
    }

    function openModal(src) {
      const modalImage = document.getElementById('modalImage');
      modalImage.src = src;
      const modal = new bootstrap.Modal(document.getElementById('imageModal'));
      modal.show();
    }

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

    document.addEventListener('DOMContentLoaded', function () {
      const lat = {{ $maisons->latitude ?? 6.131 }}; // Fallback par défaut sur Lomé si NULL
      const lng = {{ $maisons->longitude ?? 1.223 }};

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