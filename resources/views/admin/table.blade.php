<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord Propriétaire - MaisonLoc</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: #f4f6f9;
            color: #2c3e50;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        header {
            margin-top: 56px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 35px 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        header h1 {
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        header p {
            color: #bdc3c7;
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Statistiques */
        .stats-container {
            max-width: 1200px;
            margin: -20px auto 30px auto;
            padding: 0 20px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon {
            font-size: 2.3rem;
            opacity: 0.8;
        }

        .stat-details h3 {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: #2c3e50;
        }

        .stat-details p {
            margin: 0;
            color: #7f8c8d;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Grille Principale */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px 50px 20px;
        }

        .section-title {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
            border-left: 4px solid #3498db;
            padding-left: 10px;
        }


        .houses {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        /* Style de la Carte de base */
        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.04);
            overflow: hidden;
            border: none;
            height: 100%;
            min-height: 440px; /* Légèrement augmenté pour laisser de la place aux boutons */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        /* STYLE LOGIQUE VERROUILLÉE / LOUÉE */
        .card.house-locked {
            background: #fdfefe;
            border: 1px solid #e5e8e8;
        }
        
        .card.house-locked .image-container img {
            filter: grayscale(40%) blur(1px); /* Rend l'image un peu grise/floutée */
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 200px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        /* Badges d'état */
        .status-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: bold;
            backdrop-filter: blur(5px);
            z-index: 2;
        }
        .bg-available { background: rgba(39, 174, 96, 0.9); }
        .bg-locked { background: rgba(231, 76, 60, 0.95); }

        .card-body-content {
            padding: 18px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card h2 {
            margin: 0 0 10px 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #2c3e50;
            line-height: 1.4;
        }
        
        /* Grisage du titre si verrouillé */
        .house-locked h2 { color: #7f8c8d; }

        .card p.description {
            margin: 0 0 15px 0;
            font-size: 0.9rem;
            color: #7f8c8d;
            line-height: 1.5;
        }

        .price-tag {
            font-size: 1.15rem;
            color: #e74c3c;
            font-weight: 700;
            margin-bottom: 0;
        }

        .price-tag span {
            font-size: 0.8rem;
            color: #95a5a6;
            font-weight: normal;
        }

        /* Actions */
        .card-actions {
            padding: 0 18px 18px 18px;
            display: flex;
            gap: 10px;
        }

        .btn-modify {
            background: #2563eb;
            color: white;
            border: none;
            padding: 10px 15px;
            flex-grow: 1;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .btn-modify:hover { background: #0f38ec; color: white; }

        /* Style du Bouton désactivé/verrouillé */
        .btn-modify.disabled-lock {
            background: #bdc3c7 !important;
            color: #ffffff !important;
            cursor: not-allowed;
            pointer-events: none; /* Empêche le clic */
        }

        .btn-view {
            background: #f0f3f4;
            color: #7f8c8d;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-view:hover { background: #e5e8e8; color: #2c3e50; }

        .fab-add {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #3498db;
            color: white;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.4);
            font-size: 1.5rem;
            text-decoration: none;
            z-index: 1000;
        }
    </style>
</head>
<body>

    <!-- Barre de Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-house-chimney me-2"></i>MaisonLoc</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">
                            <i class="fa-solid fa-arrow-left me-1"></i> Retour
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- En-tête -->
    <header>
        <h1>Mon Tableau de Bord</h1>
        <p>Gérez vos biens et verrouillez les maisons déjà occupées.</p>
    </header>

    <!-- Section Statistiques (KPI) -->
    <div class="stats-container">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->count() }}</h3>
                        <p>Total Propriétés</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-building" style="color: #3498db;"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('est_loue', true)->count() }}</h3>
                        <p>Maisons Louées (Verrouillées)</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-lock" style="color: #e74c3c;"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ number_format($maisons->sum('prix'), 0, ',', ' ') }}</h3>
                        <p>Revenu Mensuel (FCFA)</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-wallet" style="color: #27ae60;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Conteneur Principal -->
    <main class="main-container">
        <h2 class="section-title">Mes Maisons Enregistrées</h2>
        
        <section class="houses">
            @foreach($maisons as $maison)
            
            <div class="card {{ $maison->est_loue ? 'house-locked' : '' }}">
                
                <!-- Image avec badge d'état dynamique -->
                <div class="image-container">
                    <img src="{{ asset($maison->image) }}" alt="{{ $maison['titre'] }}">
                    
                    @if($maison->est_loue)
                        <span class="status-badge bg-locked"><i class="fa-solid fa-lock me-1"></i> Loué / Verrouillé</span>
                    @else
                        <span class="status-badge bg-available"><i class="fa-solid fa-circle-check me-1"></i> Disponible</span>
                    @endif
                </div>
                
                <!-- Corps textuel de la carte -->
                <div class="card-body-content">
                    <div>
                        <h2>{{ Str::limit($maison['titre'], 20, '...') }}</h2>
                        <p class="description">{{ Str::limit($maison['description'], 50, '...') }}</p>
                    </div>
                    
                    <p class="price-tag">
                        <strong>{{ number_format($maison['prix'], 0, ',', ' ') }}</strong> <span>FCFA/mois</span>
                    </p>
                </div>

                <!-- Boutons d'actions avec possibilité de (Dé)Verrouiller -->
                <div class="card-actions d-flex flex-column gap-2">
                    
                    <div class="d-flex gap-2 w-100">
                        @if($maison->est_loue)
                            <!-- Si loué : Bouton de modification bloqué -->
                            <button class="btn-modify disabled-lock flex-grow-1" title="Cette maison est louée et verrouillée." type="button">
                                <i class="fa-solid fa-lock"></i> Verrouillé
                            </button>
                        @else
                            <!-- Si disponible : Lien de modification normal -->
                            <a href="{{ route('maisons.show', $maison->id) }}" class="btn-modify flex-grow-1" onclick="bookNow('{{ $maison['adresse'] }}')">
                                <i class="fa-solid fa-pen-to-square"></i> Modifier
                            </a>
                        @endif
                        
                        <a href="{{ route('maisons.infoA', $maison->id) }}" class="btn-view" title="Aperçu">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>

                    <!-- FORMULAIRE POUR CHANGER LE STATUT (LOUÉ / DISPONIBLE) -->
                    <form action="{{ route('maisons.toggleLoue', $maison->id) }}" method="POST" class="w-100 m-0">
                        @csrf
                        @method('PATCH')
                        @if($maison->est_loue)
                            <button type="submit" class="btn btn-sm btn-outline-success w-100">
                                <i class="fa-solid fa-lock-open me-1"></i> Rendre Disponible
                            </button>
                        @else
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                <i class="fa-solid fa-lock me-1"></i> Marquer comme Loué
                            </button>
                        @endif
                    </form>

                </div>
            </div>
            @endforeach
        </section>
    </main>

    <!-- Bouton Flottant -->
    <a href="{{ route('admin.ajouter') }}" class="fab-add" title="Ajouter un nouveau bien">
        <i class="fa-solid fa-plus"></i>
    </a>

    <script src="{{ asset('js/script.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function bookNow(adresse) {
            console.log("Modification de la maison à l'adresse :", adresse);
        }
    </script>
</body>
</html>