<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DétailADMINCHANGE - Chambre Meublée à Lomé</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
</head>
<body>

 <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MaisonLoc</a>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="/">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

<div class="container mt-5" >
  <div class="card shadow-lg" style="margin-top: 75px;">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
      <h4 class="mb-0"><i class="bi bi-house-add-fill me-2"></i>Modifier une maison à louer</h4>
      
      <form action="{{ route('maisons.sup', $maisons->id) }}" method="POST" onsubmit="return confirm('Voulez-vous vraiment supprimer cette maison ?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger btn-sm">Supprimer la maison</button>
      </form>
    
    </div>

    <div class="card-body">
      <form action="/admin/{{ $maisons->id }}/tt" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
    <label for="categorie">Catégorie</label>
    <select required name="categorie_id" id="categorie" class="form-control">
        <option value="" disabled selected>Sélectionnez une catégorie</option>
        <option value="1">Habitation</option>
        <option value="2">Bureau</option>
        <option value="3">Boutique/Magasin</option>

    </select>
</div>
<br>
        <div class="mb-3">
          <label for="titre" class="form-label">Titre</label>
          <input type="text" class="form-control" id="titre" name="titre" 
                 value="{{ old('titre', $maisons->titre) }}" 
                 placeholder="Ex: Maison 2 chambres à Agoè" required>
        </div>

        <div class="mb-3">
          <label for="description" class="form-label">Description</label>
          <textarea class="form-control" style="text-transform: uppercase;" id="description" name="description" rows="4" required>{{ old('description', $maisons->description) }}</textarea>
        </div>

        <div class="row">
          <div class="col-md-6 mb-3">
            <label for="prix" class="form-label">Prix (FCFA/mois)</label>
            <input type="number" class="form-control" id="prix" max="999999999" name="prix" value="{{ $maisons->prix }}" required>
            <small class="form-text text-muted">Le prix doit être inférieur à 999 999 999 FCFA.</small>
          </div>

            <div class="col-md-6 mb-3">
              <label for="ville" class="form-label">Ville</label>
              <input type="text" class="form-control" style="text-transform: uppercase;" id="ville" name="ville" value="{{ $maisons->ville }}" required>
            </div>
          

          <div class="col-md-6 mb-3">
            <label for="adresse" class="form-label">Quartier</label>
            <input type="text" class="form-control" style="text-transform: capitalize;" id="adresse" name="adresse" value="{{ $maisons->adresse }}" required>
          </div>
        </div>

        <div class="mb-3 border p-3 rounded bg-light">
          <label for="image" class="form-label"><strong>Photo principale (laisser vide pour ne pas changer)</strong></label>
          <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(event)">
          
          <div class="row mt-3">
            <div class="col-md-6">
              <p class="small text-muted">Image actuelle :</p>
              @if ($maisons->image)
                <img id="existing-preview" src="{{ asset('storage/' . $maisons->image) }}" class="img-thumbnail" style="max-height: 150px;">
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
            <label for="images_secondaires" class="form-label">Ajouter des photos secondaires <strong>¨(Choisissez les nouvelles photos)</strong> </label>
            <input type="file" class="form-control" name="images_secondaires[]" id="images_secondaires" multiple accept="image/*">
        </div>

        <div class="row mb-4">
            <p class="small text-muted">Photos secondaires actuelles :</p>
            @foreach($maisons->photos as $photo)
                <div class="col-md-3 text-center mb-2">
                    <img src="{{ asset('storage/' . $photo->chemin) }}" class="img-fluid img-thumbnail">
                    <a href="/maison/{{$photo->id}}/sup" class="btn btn-danger btn-xs mt-1" style="font-size: 10px;">Supprimer</a>
                </div>
            @endforeach
        </div>

        <div class="card mb-4 shadow-sm">
          <div class="card-header bg-danger text-white"><strong>Localisation sur la carte</strong></div>
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
          <button type="submit" class="btn btn-success btn-lg">Enregistrer les modifications</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  // Script Aperçu Image
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

  // Script Carte
  document.addEventListener('DOMContentLoaded', function () {
    const initialLat = {{ $maisons->latitude ?? 6.2 }};
    const initialLng = {{ $maisons->longitude ?? 1.2 }};
    const map = L.map('map').setView([initialLat, initialLng], 15);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

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

    window.resetMap = function () { map.setView([6.2, 1.2], 13); };
  });
</script>
</body>
</html>