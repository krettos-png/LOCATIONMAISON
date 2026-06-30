<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ajouter une Maison</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="{{ asset('css/ajouter.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<style>
  .navbar {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  .form-control {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccd1d9;
    border-radius: 6px;
    font-size: 14px;
    margin-bottom: 10px;
  }
  /* Style harmonieux pour les sections de cases à cocher */
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
    
  <div class="container" style="margin-top: 80px; margin-bottom: 50px;">

  @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
  @endif

  @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
  @endif

    <h1>Ajouter une Maison</h1>
    <form action="{{ route('enre') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label for="categorie">Catégorie</label>
        <select required name="categorie_id" id="categorie" class="form-control">
            <option value="" disabled selected>Sélectionnez la catégorie de votre bien ici</option>
            <option value="1">Habitation</option>
            <option value="2">Bureau</option>
            <option value="3">Boutique/Magasin</option>
        </select>
      </div>

      <div class="form-group">
        <label for="titre">Titre de la maison</label>
        <input type="text" id="titre" name="titre" placeholder="Que voulez-vous mettre en location ?" required />
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" style="text-transform: capitalize;" id="description" name="description" rows="4" placeholder="Décrivez les atouts majeurs du bien..." required></textarea>
      </div>

      <div class="form-group">
        <label for="prix">Prix du loyer (FCFA / mois)</label>
        <input type="number" id="prix" name="prix" max="999999999" placeholder="Entrez le prix mensuel de la maison" required />
        <small class="form-text text-muted">Le prix doit être inférieur à 999 999 999 FCFA.</small>
      </div>

      <div class="row">
        <div class="col-md-6 form-group">
          <label for="region">Région</label>
          <select required name="region" id="region" class="form-control">
              <option value="" disabled selected>Sélectionnez la région</option>
              <option value="Maritime">Maritime (Grand Lomé)</option>
              <option value="Plateaux">Plateaux</option>
              <option value="Centrale">Centrale</option>
              <option value="Kara">Kara</option>
              <option value="Savanes">Savanes</option>
          </select>
        </div>

        <div class="col-md-6 form-group">
          <label for="ville">Ville</label>
          <select required name="ville" id="ville" class="form-control" disabled>
              <option value="" disabled selected>Veuillez d'abord choisir une région</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label for="adresse">Quartier</label>
        <input type="text" style="text-transform: capitalize;" id="adresse" name="adresse" placeholder="Entrez le quartier où se trouve la maison" required />
      </div>

      <div class="section-title">Caractéristiques du bien</div>
      <div class="checkbox-group mb-4">
        <div class="row g-3">
          <div class="col-md-4 col-sm-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="immeuble_etage" name="immeuble_etage" value="1">
              <label class="form-check-label" for="immeuble_etage">Immeuble à étage</label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="meuble" name="meuble" value="1">
              <label class="form-check-label" for="meuble">Meublé</label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="climatise" name="climatise" value="1">
              <label class="form-check-label" for="climatise">Climatisé</label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="sanitaire" name="sanitaire" value="1">
              <label class="form-check-label" for="sanitaire">Sanitaire intégré</label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="adapte_pmr" name="adapte_pmr" value="1">
              <label class="form-check-label" for="adapte_pmr">Adapté PMR</label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="compteur_elec_perso" name="compteur_elec_perso" value="1">
              <label class="form-check-label" for="compteur_elec_perso">Compteur d'Électricité Personnel</label>
            </div>
          </div>
          <div class="col-md-4 col-sm-6">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="compteur_eau_perso" name="compteur_eau_perso" value="1">
              <label class="form-check-label" for="compteur_eau_perso">Compteur d'Eau Personnel</label>
            </div>
          </div>
        </div>
      </div>

      <div class="section-title">Conditions Financières & Cautions (Optionnel)</div>
      <div class="row">
        <div class="col-md-6 form-group">
          <label for="caution_mois">Nombre de mois de caution</label>
          <input type="number" id="caution_mois" name="caution_mois" min="0" placeholder="Ex: 3" />
        </div>
        <div class="col-md-6 form-group">
          <label for="prepaiement_mois">Nombre de mois d'avance/prépaiement</label>
          <input type="number" id="prepaiement_mois" name="prepaiement_mois" min="0" placeholder="Ex: 2" />
        </div>
        <div class="col-md-6 form-group">
          <label for="frais_visite">Frais de visite (FCFA)</label>
          <input type="number" id="frais_visite" name="frais_visite" min="0" placeholder="Ex: 5000" />
        </div>
        <div class="col-md-6 form-group">
          <label for="commission">Commission de l'agence (FCFA)</label>
          <input type="number" id="commission" name="commission" min="0" placeholder="Montant de la commission" />
        </div>
        <div class="col-md-4 form-group">
          <label for="caution_elec">Caution Électricité (FCFA)</label>
          <input type="number" id="caution_elec" name="caution_elec" min="0" placeholder="Montant caution élec" />
        </div>
        <div class="col-md-4 form-group">
          <label for="caution_eau">Caution Eau (FCFA)</label>
          <input type="number" id="caution_eau" name="caution_eau" min="0" placeholder="Montant caution eau" />
        </div>
        
      </div>

      <div class="form-group mt-3">
        <label for="image">Image principale</label>
        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" />
        <img id="preview" class="preview" alt="Aperçu de l'image" />
      </div>

      <div class="form-group">
        <label for="images_secondaires">Images secondaires</label>
        <input type="file" id="images_secondaires" name="images_secondaires[]" accept="image/*" multiple />
      </div>

      <div class="card my-4">
        <div class="card-header">Localisation précise sur la carte</div>
        <div class="card-body">
          <div class="row">
            <div class="col">
              <label for="latitude">Latitude</label>
              <input type="text" id="latitude" value='6.565' name="latitude" readonly required />
            </div>
            <div class="col">
              <label for="longitude">Longitude</label>
              <input type="text" id="longitude" value='5.555' name="longitude" readonly required />
            </div>
          </div>

          <div id="map"></div>

          <button type="button" onclick="resetMap()" class="btn-outline">Recentrer sur Lomé</button>
        </div>
      </div>

      <button type="submit" class="btn-ajouter">Ajouter la maison</button>
      
    </form>

    <a href="/admin/table" class="back-link">← Retour à l'accueil admin</a>
  </div>

  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
  <script src="{{ asset('js/ajouter.js') }}"></script>

  <script>
    const villesParRegion = {
      "Maritime": ["Lomé", "Tsévié", "Aného", "Tabligbo", "Vogan", "Kévé", "Afagnangan", "Baguida", "Agbodrafo", "Togoville"],
      "Plateaux": ["Atakpamé", "Kpalimé", "Badou", "Notsé", "Anié", "Amlamé", "Danyi Apéyemé", "Elavagnon", "Adéta", "Tohoun"],
      "Centrale": ["Sokodé", "Tchamba", "Sotouboua", "Blitta", "Djarkpanga", "Kambolé", "Ayengré"],
      "Kara": ["Kara", "Bassar", "Niamtougou", "Bafilo", "Pagouda", "Kandé", "Guérin-Kouka", "Kabou", "Kétao"],
      "Savanes": ["Dapaong", "Sansanné-Mango", "Cinkassé", "Mandouri", "Tandjouaré", "Gando", "Bombouaka", "Biankouri"]
    };

    const regionSelect = document.getElementById('region');
    const villeSelect = document.getElementById('ville');

    regionSelect.addEventListener('change', function() {
      const regionSelectionnee = this.value;
      
      // Vider le menu des villes
      villeSelect.innerHTML = '<option value="" disabled selected>Sélectionnez la ville</option>';
      
      if (regionSelectionnee && villesParRegion[regionSelectionnee]) {
        // Activer le select des villes
        villeSelect.disabled = false;
        
        // Ajouter les villes correspondantes
        villesParRegion[regionSelectionnee].forEach(function(ville) {
          const option = document.createElement('option');
          option.value = ville;
          option.textContent = ville;
          villeSelect.appendChild(option);
        });
      } else {
        villeSelect.disabled = true;
      }
    });
  </script>
</body>
</html>