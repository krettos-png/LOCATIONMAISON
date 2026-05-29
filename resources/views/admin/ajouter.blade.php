<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Ajouter une Maison</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <link rel="stylesheet" href="{{ asset('css/ajouter.css') }}">
</head>
<body>
  <div class="container">


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

<style>
  .form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccd1d9;
  border-radius: 6px;
  font-size: 14px;
  margin-bottom: 10px;

  }
</style>




      <div class="form-group">
        <label for="titre">Titre de la maison</label>
        <input type="text" id="titre" name="titre" placeholder="Que voulez-vous mettre en location ?" required />
      </div>

      <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" style="text-transform: capitalize;" id="description" name="description" rows="4" placeholder="Decrivez votre bien y compris toutes les informations à savoir Presence d'electricite, climatisation, eau, caution etc. " required></textarea>
      </div>

      <div class="form-group">
        <label for="prix">Prix (FCFA)</label>
        <input type="number" id="prix" name="prix" max="999999999" placeholder="Entrez le prix mensuel de la maison " required />
        <small class="form-text text-muted">Le prix doit être inférieur à 999 999 999 FCFA.</small>
      </div>



      <div class="form-group">
        <label for="ville">Ville</label>
        <input type="text" style="text-transform: uppercase;" id="ville" name="ville" placeholder="Entrez la ville où se trouve la maison" required />
      </div>

      <div class="form-group">
        <label for="adresse">Quartier</label>
        <input type="text" style="text-transform: capitalize;" id="adresse"  name="adresse" placeholder="Entrez le quartier où se trouve la maison" required />
      </div>









      <div class="form-group">
        <label for="image">Image principale</label>
        <input type="file" id="image" name="image" accept="image/*" onchange="previewImage(event)" />
        <img id="preview" class="preview" alt="Aperçu de l'image" />
      </div>

      <div class="form-group">
        <label for="images_secondaires">Images secondaires</label>
        <input type="file" id="images_secondaires" name="images_secondaires[]" accept="image/*" multiple />
      </div>

      <!-- Carte -->
      <div class="card">
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
</body>
</html>
