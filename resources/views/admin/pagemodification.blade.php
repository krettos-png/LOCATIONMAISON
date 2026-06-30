<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DétailADMINCHANGE - Modifier une Maison</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<style>
  .navbar {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  /* Style harmonieux pour les switchs en édition */
  .checkbox-group {
    background-color: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    border: 1px solid #e9ecef;
  }
  .form-check-label {
    font-size: 14px;
    cursor: pointer;
  }
  .section-title {
    font-size: 16px;
    font-weight: bold;
    margin-top: 20px;
    margin-bottom: 15px;
    color: #495057;
    border-left: 4px solid #0d6efd;
    padding-left: 10px;
  }
</style>

 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-house-chimney me-2"></i>MaisonLoc</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('ttt') }}">
                            <i class="fa-solid fa-arrow-left me-1"></i> Retour
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

<div class="container mt-5" >
  <div class="card shadow-lg" style="margin-top: 75px;">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="fa-solid fa-house-medical me-2"></i>Modifier une maison à louer</h4>
      
      <form action="{{ route('maisons.sup', $maisons->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette maison ?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Supprimer la maison</button>
      </form>
    
    </div>

    <div class="card-body">
      <form action="{{ route('maisons.update', $maisons->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label for="categorie" class="form-label fw-bold">Catégorie</label>
          <select required name="categorie_id" id="categorie" class="form-control">
              <option value="" disabled>Sélectionnez la catégorie</option>
              <option value="1" {{ $maisons->categorie_id == 1 ? 'selected' : '' }}>Habitation</option>
              <option value="2" {{ $maisons->categorie_id == 2 ? 'selected' : '' }}>Bureau</option>
              <option value="3" {{ $maisons->categorie_id == 3 ? 'selected' : '' }}>Boutique/Magasin</option>
          </select>
        </div>
        <br>

        <div class="mb-3">
          <label for="titre" class="form-label fw-bold">Titre</label>
          <input type="text" class="form-control" id="titre" name="titre" 
                 value="{{ old('titre', $maisons->titre) }}" 
                 placeholder="Ex: Maison 2 chambres à Agoè" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label fw-bold">Description</label>
          <textarea class="form-control" style="text-transform: capitalize;" id="description" name="description" rows="4" required>{{ old('description', $maisons->description) }}</textarea>
        </div>

        <div class="row">
          <div class="col-md-3 mb-3">
            <label for="prix" class="form-label fw-bold">Prix (FCFA/mois)</label>
            <input type="number" class="form-control" id="prix" max="999999999" name="prix" value="{{ old('prix', $maisons->prix) }}" required>
            <small class="form-text text-muted">Inférieur à 999 999 999.</small>
          </div>

          <!-- Section Région dynamique en édition -->
          <div class="col-md-3 mb-3">
            <label for="region" class="form-label fw-bold">Région</label>
            <select required name="region" id="region" class="form-control">
                <option value="" disabled selected>Sélectionnez la région</option>
                <option value="Maritime">Maritime (Grand Lomé)</option>
                <option value="Plateaux">Plateaux</option>
                <option value="Centrale">Centrale</option>
                <option value="Kara">Kara</option>
                <option value="Savanes">Savanes</option>
            </select>
          </div>

          <!-- Section Ville dynamique en édition -->
          <div class="col-md-3 mb-3">
            <label for="ville" class="form-label fw-bold">Ville</label>
            <select required name="ville" id="ville" class="form-control" disabled>
                <option value="" disabled selected>Choisissez d'abord une région</option>
            </select>
          </div>
          
          <div class="col-md-3 mb-3">
            <label for="adresse" class="form-label fw-bold">Quartier</label>
            <input type="text" class="form-control" style="text-transform: capitalize;" id="adresse" name="adresse" value="{{ old('adresse', $maisons->adresse) }}" required>
          </div>
        </div>

        <div class="section-title">Caractéristiques du bien</div>
        <div class="checkbox-group mb-4">
          <div class="row g-3">
            <div class="col-md-4 col-sm-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="immeuble_etage" name="immeuble_etage" value="1" {{ old('immeuble_etage', $maisons->immeuble_etage) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="immeuble_etage">Immeuble à étape</label>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="meuble" name="meuble" value="1" {{ old('meuble', $maisons->meuble) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="meuble">Meublé</label>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="climatise" name="climatise" value="1" {{ old('climatise', $maisons->climatise) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="climatise">Climatisé</label>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="sanitaire" name="sanitaire" value="1" {{ old('sanitaire', $maisons->sanitaire) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="sanitaire">Sanitaire intégré</label>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="adapte_pmr" name="adapte_pmr" value="1" {{ old('adapte_pmr', $maisons->adapte_pmr) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="adapte_pmr">Adapté PMR</label>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="compteur_elec_perso" name="compteur_elec_perso" value="1" {{ old('compteur_elec_perso', $maisons->compteur_elec_perso) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="compteur_elec_perso">Compteur Élec Personnel</label>
              </div>
            </div>
            <div class="col-md-4 col-sm-6">
              <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="compteur_eau_perso" name="compteur_eau_perso" value="1" {{ old('compteur_eau_perso', $maisons->compteur_eau_perso) == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="compteur_eau_perso">Compteur Eau Personnel</label>
              </div>
            </div>
          </div>
        </div>

        <div class="section-title">Conditions Financières & Cautions (Optionnel)</div>
        <div class="row bg-light border rounded p-3 mb-4 mx-0">
          <div class="col-md-6 mb-3">
            <label for="caution_mois" class="form-label fw-semibold">Nombre de mois de caution</label>
            <input type="number" class="form-control" id="caution_mois" name="caution_mois" min="0" value="{{ old('caution_mois', $maisons->caution_mois) }}" placeholder="Ex: 3" />
          </div>
          <div class="col-md-6 mb-3">
            <label for="prepaiement_mois" class="form-label fw-semibold">Nombre de mois d'avance/prépaiement</label>
            <input type="number" class="form-control" id="prepaiement_mois" name="prepaiement_mois" min="0" value="{{ old('prepaiement_mois', $maisons->prepaiement_mois) }}" placeholder="Ex: 2" />
          </div>
          <div class="col-md-6 mb-3">
            <label for="frais_visite" class="form-label fw-semibold">Frais de visite (FCFA)</label>
            <input type="number" class="form-control" id="frais_visite" name="frais_visite" min="0" value="{{ old('frais_visite', $maisons->frais_visite) }}" placeholder="Ex: 5000" />
          </div>
          <div class="col-md-6 mb-3">
            <label for="commission" class="form-label fw-semibold">Commission de l'agence (FCFA)</label>
            <input type="number" class="form-control" id="commission" name="commission" min="0" value="{{ old('commission', $maisons->commission) }}" placeholder="Montant commission" />
          </div>
          <div class="col-md-4 mb-3">
            <label for="caution_elec" class="form-label fw-semibold">Caution Électricité (FCFA)</label>
            <input type="number" class="form-control" id="caution_elec" name="caution_elec" min="0" value="{{ old('caution_elec', $maisons->caution_elec) }}" placeholder="Caution élec" />
          </div>
          <div class="col-md-4 mb-3">
            <label for="caution_eau" class="form-label fw-semibold">Caution Eau (FCFA)</label>
            <input type="number" class="form-control" id="caution_eau" name="caution_eau" min="0" value="{{ old('caution_eau', $maisons->caution_eau) }}" placeholder="Caution eau" />
          </div>
          <div class="col-md-4 mb-3">
            <label for="caution_elec_eau" class="form-label fw-semibold">Caution combinée Élec & Eau (FCFA)</label>
            <input type="number" class="form-control" id="caution_elec_eau" name="caution_elec_eau" min="0" value="{{ old('caution_elec_eau', $maisons->caution_elec_eau) }}" placeholder="Caution globale" />
          </div>
        </div>

        <div class="mb-3 border p-3 rounded bg-light">
          <label for="image" class="form-label"><strong>Photo principale (laisser vide pour ne pas changer)</strong></label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
          
          <div class="row mt-3">
            <div class="col-md-6">
              <p class="small text-muted">Image actuelle :</p>
              @if ($maisons->image)
                <img id="existing-preview" src="{{ asset($maisons->image) }}" class="img-thumbnail" style="max-height: 150px;">
              @else
                <span class="text-danger">Aucune image</span>
              @endif
            </div>
            <div class="col-md-6">
              <p class="small text-muted">Nouvel aperçu :</p>
              <img id="new-preview" src="#" alt="Aperçu" class="img-thumbnail d-none" style="max-height: 150px;">
            </div>
          </div>
        </div>

        <div class="mb-3">
            <label for="images_secondaires" class="form-label">Ajouter des photos secondaires <strong>(Choisissez les nouvelles photos)</strong></label>
            <input type="file" class="form-control" name="images_secondaires[]" id="images_secondaires" multiple accept="image/*">
        </div>

        <div class="row mb-4">
            <p class="small text-muted">Photos secondaires actuelles :</p>
            @foreach($maisons->photos as $photo)
                <div class="col-md-3 text-center mb-2">
                    <img src="{{ asset($photo->chemin) }}" class="img-fluid img-thumbnail" style="max-height: 110px; object-fit: cover;">
                    <a href="{{ route('maisonsSecon.sup', $photo->id) }}" class="btn btn-danger btn-xs mt-1 w-100" style="font-size: 10px; display: block;">Supprimer</a>
                </div>
            @endforeach
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-dark text-white"><strong>Localisation sur la carte</strong></div>
          <div class="card-body">
            <div class="row mb-3">
              <div class="col-md-6">
                <label class="form-label">Latitude</label>
                <input type="text" class="form-control" id="latitude" name="latitude" value="{{ $maisons->latitude }}" readonly required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Longitude</label>
                <input type="text" class="form-control" id="longitude" name="longitude" value="{{ $maisons->longitude }}" readonly required>
              </div>
            </div>
            <div id="map" style="height: 350px;" class="rounded border"></div>
            <button type="button" onclick="resetMap()" class="btn btn-outline-secondary mt-2">Recentrer sur Lomé</button>
          </div>
        </div>

        <div class="text-end mb-5">
          <button type="submit" class="btn btn-success btn-lg px-5">Enregistrer les modifications</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('new-preview');
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.remove('d-none');
      };
      reader.readAsDataURL(input.files[0]);
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    // ---- LOGIQUE CARTOGRAPHIE ----
    const initialLat = {{ $maisons->latitude ?? 6.2 }};
    const initialLng = {{ $maisons->longitude ?? 1.2 }};
    const map = L.map('map').setView([initialLat, initialLng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(map);

    let marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

    map.on('click', function (e) {
      const lat = e.latlng.lat.toFixed(7);
      const lng = e.latlng.lng.toFixed(7);
      document.getElementById('latitude').value = lat;
      document.getElementById('longitude').value = lng;
      marker.setLatLng(e.latlng);
    });

    marker.on('dragend', function () {
      const pos = marker.getLatLng();
      document.getElementById('latitude').value = pos.lat.toFixed(7);
      document.getElementById('longitude').value = pos.lng.toFixed(7);
    });

    window.resetMap = function () { map.setView([6.131, 1.223], 13); };


    // ---- LOGIQUE RÉGIONS ET VILLES DYNAMIQUES ----
    const villesParRegion = {
      "Maritime": ["Lomé", "Tsévié", "Aného", "Tabligbo", "Vogan", "Kévé", "Afagnangan", "Baguida", "Agbodrafo", "Togoville"],
      "Plateaux": ["Atakpamé", "Kpalimé", "Badou", "Notsé", "Anié", "Amlamé", "Danyi Apéyemé", "Elavagnon", "Adéta", "Tohoun"],
      "Centrale": ["Sokodé", "Tchamba", "Sotouboua", "Blitta", "Djarkpanga", "Kambolé", "Ayengré"],
      "Kara": ["Kara", "Bassar", "Niamtougou", "Bafilo", "Pagouda", "Kandé", "Guérin-Kouka", "Kabou", "Kétao"],
      "Savanes": ["Dapaong", "Sansanné-Mango", "Cinkassé", "Mandouri", "Tandjouaré", "Gando", "Bombouaka", "Biankouri"]
    };

    const regionSelect = document.getElementById('region');
    const villeSelect = document.getElementById('ville');

    // Récupération de la valeur de la ville déjà enregistrée (mise en majuscule pour correspondre au format d'origine si besoin)
    // Nous la transformons pour matcher la casse de notre tableau (ex: LOMÉ -> Lomé)
    const villeActuelleRaw = "{{ old('ville', $maisons->ville) }}";
    const villeActuelle = villeActuelleRaw.charAt(0).toUpperCase() + villeActuelleRaw.slice(1).toLowerCase();

    // Trouver automatiquement la région correspondante à la ville actuelle
    let regionInitiale = "";
    for (const [region, villes] of Object.entries(villesParRegion)) {
      if (villes.map(v => v.toLowerCase()).includes(villeActuelle.toLowerCase())) {
        regionInitiale = region;
        break;
      }
    }

    // Fonction de mise à jour des villes
    function updateVilles(regionSelectionnee, villeASelectionner = "") {
      villeSelect.innerHTML = '<option value="" disabled selected>Sélectionnez la ville</option>';
      
      if (regionSelectionnee && villesParRegion[regionSelectionnee]) {
        villeSelect.disabled = false;
        
        villesParRegion[regionSelectionnee].forEach(function(ville) {
          const option = document.createElement('option');
          option.value = ville;
          option.textContent = ville;
          // Pré-sélectionner si elle correspond à la ville de la maison
          if (ville.toLowerCase() === villeASelectionner.toLowerCase()) {
            option.selected = true;
          }
          villeSelect.appendChild(option);
        });
      } else {
        villeSelect.disabled = true;
      }
    }

    // Écouteur de changement manuel
    regionSelect.addEventListener('change', function() {
      updateVilles(this.value);
    });

    // Initialisation automatique au chargement de la page
    if (regionInitiale) {
      regionSelect.value = regionInitiale;
      updateVilles(regionInitiale, villeActuelle);
    } else if (villeActuelleRaw) {
      // Cas de secours si la ville enregistrée n'est pas dans notre liste par défaut
      villeSelect.disabled = false;
      const option = document.createElement('option');
      option.value = villeActuelleRaw;
      option.textContent = villeActuelleRaw;
      option.selected = true;
      villeSelect.appendChild(option);
    }
  });
</script>

</body>
</html>