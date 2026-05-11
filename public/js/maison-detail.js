let currentSlide = 0;
let slides = [];

document.addEventListener('DOMContentLoaded', () => {
  slides = Array.from(document.querySelectorAll('.carousel-image'));
  showSlide(currentSlide);

  // Initialisation de la carte Leaflet (valeurs dynamiques insérées via attributs HTML data-* )
  const mapDiv = document.getElementById('map');
  const lat = parseFloat(mapDiv.dataset.lat);
  const lng = parseFloat(mapDiv.dataset.lng);

  const map = L.map('map').setView([lat, lng], 15);
  const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
  });
  streetLayer.addTo(map);

  const satelliteLayer = L.tileLayer(
    'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
    {
      attribution: '© ESRI',
      maxZoom: 19
    }
  );

  L.control.layers({
    "Carte Classique": streetLayer,
    "Vue Satellite": satelliteLayer
  }).addTo(map);

  L.marker([lat, lng]).addTo(map).bindPopup("Position enregistrée").openPopup();
});

// Carrousel
function showSlide(index) {
  slides.forEach((slide, i) => {
    slide.classList.toggle('active', i === index);
  });
  currentSlide = index;
}

function nextSlide() {
  currentSlide = (currentSlide + 1) % slides.length;
  showSlide(currentSlide);
}

function prevSlide() {
  currentSlide = (currentSlide - 1 + slides.length) % slides.length;
  showSlide(currentSlide);
}

function setSlide(index) {
  showSlide(index);
}

// Modale image
function openModal(src) {
  const modal = document.getElementById('imageModal');
  const modalImg = document.getElementById('modalImage');
  modal.style.display = "block";
  modalImg.src = src;
  zoomScale = 1;
 // modalImg.style.transform = scale($ {zoomScale});
}

function closeModal() {
  document.getElementById('imageModal').style.display = "none";
}

// Zoom
let zoomScale = 1;
document.addEventListener('wheel', function (e) {
  const modalImg = document.getElementById('modalImage');
  if (!modalImg || !modalImg.closest('.modal')) return;

  e.preventDefault();
  zoomScale += e.deltaY * -0.001;
  zoomScale = Math.min(Math.max(0.5, zoomScale), 5);
//  modalImg.style.transform = scale(${zoomScale});
}, { passive: false });
