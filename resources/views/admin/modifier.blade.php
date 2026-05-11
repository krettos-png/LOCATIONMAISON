<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modification Maison</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>









<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MaisonLoc</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="/espaceadmin">Retour</a>
          </li>
          
        </ul>
      </div>
    </div>
  </nav>
















    <header>
        <h1>Maisons à Modifier</h1>
        
    </header>

    <section class="houses">
        @foreach($maisons as $maison)
        <a href="/maison/{{ $maison->id }}/info3" style="text-decoration: none; color: inherit;">
            <div class="card">
                <img src="{{ asset('storage/' . $maison->image) }}" alt="{{ $maison['TITRE'] }}">
                <h2>{{ $maison['titre'] }}</h2>
                <p>{{ $maison['description'] }}</p>
                <p><strong>{{ $maison['prix'] }} FCFA/mois</strong></p>
                <button onclick="bookNow('{{ $maison['adresse'] }}')">Modifier</button>
            </div>
         </a>
        @endforeach
    </section>

    <script src="{{ asset('js/script.js') }}"></script>



    <style>
        body {
    margin: 0;
    font-family: 'Segoe UI', sans-serif;
    background: #f5f7fa;
    color: #333;
}

header {
    margin-top :55px;
    background: #2c3e50;

    color: white;
    padding: 20px;
    text-align: center;
}

.houses {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    padding: 20px;
    gap: 20px;
}

.card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    overflow: hidden;
    width: 300px;
    transition: transform 0.3s ease;
}

.card:hover {
    transform: scale(1.03);
}

.card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.card h2 {
    margin: 10px;
    font-size: 1.2em;
}

.card p {
    margin: 10px;
    font-size: 0.9em;
}

.card button {
    background: #27ae60;
    color: white;
    border: none;
    padding: 10px;
    margin: 10px;
    width: calc(100% - 20px);
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.card button:hover {
    background: #219150;
}
    </style>
</body>
</html>