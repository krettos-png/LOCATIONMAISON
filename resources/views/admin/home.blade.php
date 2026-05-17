<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Accueil Admin - Location Maisons</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .admin-header {
            background-color: #2c3e50;
            color: white;
            padding: 20px 40px;
            text-align: center;
            margin-top: 55px;
        }

        .admin-header h1 {
            margin: 0;
            font-size: 28px;
        }

        .admin-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 40px 20px;
            gap: 30px;
        }

        .admin-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 25px;
            width: 280px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #333;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .admin-card .icon {
            font-size: 40px;
            margin-bottom: 15px;
            color: #3498db;
        }

        .admin-card h2 {
            font-size: 20px;
            margin: 10px 0;
        }

        .admin-card p {
            font-size: 14px;
            color: #666;
        }

        @media screen and (max-width: 768px) {
            .admin-container {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">MaisonLoc</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="/">Accueil</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Nos maisons</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/inscription">Inscription</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/login">Connection</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</head>
<body>

    <div class="admin-header">
        <h1>Bienvenue dans le panneau d'administration</h1>
    </div>

    <div class="admin-container">
        <a href="/admin/ajouter" class="admin-card">
            <div class="icon">🏡</div>
            <h2>Ajouter une Maison</h2>
            <p>Créer une nouvelle fiche de location.</p>
        </a>

        <a href="/admin/modifier" class="admin-card">
            <div class="icon">🛠</div>
            <h2>Gérer les Maisons</h2>
            <p>Modifier ou supprimer les maisons existantes.</p>
        </a>

        <a href="/admin/table" class="admin-card">
            <div class="icon">📊</div>
            <h2>Tableau de Bord</h2>
            <p>Voir les statistiques et la liste complète.</p>
        </a>
    </div>

</body>
</html>