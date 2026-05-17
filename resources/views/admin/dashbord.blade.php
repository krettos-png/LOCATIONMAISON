<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Tableau de bord - Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f3f5f8;
      margin: 0;
      padding: 0;
    }

    .header {
      background: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
    }

    .header h1 {
      margin: 0;
      font-size: 26px;
    }

    .dashboard {
      padding: 30px 20px;
      max-width: 1100px;
      margin: auto;
    }

    .cards {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 40px;
    }

    .card {
      background: white;
      flex: 1 1 250px;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .card h2 {
      margin: 10px 0 5px;
      font-size: 24px;
      color: #3498db;
    }

    .card p {
      margin: 0;
      font-size: 14px;
      color: #777;
    }

    .section-title {
      font-size: 20px;
      margin-bottom: 10px;
      color: #333;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    th, td {
      padding: 14px 16px;
      text-align: left;
      border-bottom: 1px solid #eee;
    }

    th {
      background-color: #f9fafb;
      color: #333;
      font-size: 15px;
    }

    tr:hover {
      background-color: #f1f5f9;
    }

    @media (max-width: 768px) {
      .cards {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  <div class="header">
    <h1>Tableau de Bord Administrateur</h1>
  </div>

  <div class="dashboard">

    <div class="cards">
      <div class="card">
        <h2>12</h2>
        <p>Maisons publiées</p>
      </div>
      <div class="card">
        <h2>28</h2>
        <p>Réservations</p>
      </div>
      <div class="card">
        <h2>4</h2>
        <p>Maisons secondaires</p>
      </div>
    </div>

    <h3 class="section-title">Dernières maisons ajoutées</h3>

    <table>
      <thead>
        <tr>
          <th>Titre</th>
          <th>Emplacement</th>
          <th>Prix (€)</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
       
        <tr>
          <td>Villa Saphir</td>
          <td>Abidjan</td>
          <td>150 000</td>
          <td>04/06/2025</td>
        </tr>
        <tr>
          <td>Studio Cocody</td>
          <td>Cocody</td>
          <td>75 000</td>
          <td>03/06/2025</td>
          <a href="/admin/table">t</a>
        </tr>
        <tr>
          <td>Résidence Lagune</td>
          <td>Bassam</td>
          <td>200 000</td>
          <td>01/06/2025</td>
        </tr>
        
      </tbody>
    </table>
  </div>

</body>
</html>