function previewImage(event) {
  const reader = new FileReader();
  reader.onload = function () {
    const output = document.getElementById('preview');
    output.src = reader.result;
    output.style.display = 'block';
  };
  reader.readAsDataURL(event.target.files[0]);
}

document.addEventListener('DOMContentLoaded', function () {
  const loméCoords = [6.2, 1.2];

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
    center: loméCoords,
    zoom: 13,
    layers: [streetLayer]
  });

  const baseLayers = {
    'Carte Classique': streetLayer,
    'Vue Satellite': satelliteLayer
  };
  L.control.layers(baseLayers).addTo(map);

  let marker;

  map.on('click', function (e) {
    const lat = e.latlng.lat.toFixed(7);
    const lng = e.latlng.lng.toFixed(7);

    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;

    if (marker) {
      marker.setLatLng(e.latlng);
    } else {
      marker = L.marker(e.latlng, { draggable: true }).addTo(map);
    }

    marker.on('dragend', function () {
      const pos = marker.getLatLng();
      document.getElementById('latitude').value = pos.lat.toFixed(7);
      document.getElementById('longitude').value = pos.lng.toFixed(7);
    });
  });

  window.resetMap = function () {
    map.setView(loméCoords, 13);
  };
});
