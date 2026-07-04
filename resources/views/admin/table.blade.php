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
        :root {
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-soft: #eff6ff;
            --text-dark: #111827;
            --text-light: #4b5563;
            --text-muted: #9ca3af;
            --bg-light: #f4f7fb;
            --bg-card: #ffffff;
            --border-color: #e5e7eb;
        }

        /* Variables pour le Mode Sombre */
        body.dark-theme {
            --bg-light: #0f172a;
            --bg-card: #1e293b;
            --text-dark: #f8fafc;
            --text-light: #cbd5e1;
            --text-muted: #64748b;
            --primary-soft: #1e293b;
            --border-color: #334155;
        }

        /* --- CORRECTION DES COULEURS AVEC LES VARIABLES --- */
        body {
            margin: 0;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            background: var(--bg-light); /* Modifié */
            color: var(--text-dark);     /* Modifié */
            transition: background 0.3s ease, color 0.3s ease;
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        header {
            margin-top: 56px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 35px 20px 55px 20px;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        header p {
            color: #bdc3c7;
            font-size: 0.95rem;
            margin-bottom: 0;
        }

        /* Statistiques Responsives */
        .stats-container {
            max-width: 1200px;
            margin: -25px auto 30px auto;
            padding: 0 15px;
        }

        .stat-card {
            background: var(--bg-card); /* Modifié */
            border-radius: 12px;
            padding: 15px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid var(--border-color); /* Modifié */
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 100%;
        }

        .stat-icon {
            font-size: 1.8rem;
            opacity: 0.8;
        }

        .stat-details h3 {
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            color: var(--text-dark); /* Modifié */
        }

        .stat-details p {
            margin: 0;
            color: var(--text-muted); /* Modifié */
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Grille Principale */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px 80px 15px;
        }

        .section-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 20px;
            color: var(--text-dark); /* Modifié */
            border-left: 4px solid var(--primary); /* Modifié */
            padding-left: 10px;
        }

        .houses {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        /* Style de la Carte */
        .card {
            background: var(--bg-card); /* Modifié */
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.04);
            overflow: hidden;
            border: 1px solid var(--border-color); /* Modifié */
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            position: relative;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .card.house-locked {
            background: var(--bg-light); /* Modifié */
            border: 1px solid var(--border-color);
        }
        
        .card.house-locked .image-container img,
        .card.house-pending .image-container img {
            filter: grayscale(40%) blur(1px);
        }

        .image-container {
            position: relative;
            width: 100%;
            height: 180px;
            overflow: hidden;
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .status-badge {
            position: absolute;
            top: 12px;
            right: 12px;
            color: white;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: bold;
            backdrop-filter: blur(5px);
            z-index: 2;
        }
        .bg-available { background: rgba(39, 174, 96, 0.9); }
        .bg-locked { background: rgba(231, 76, 60, 0.95); }
        .bg-pending { background: rgba(245, 158, 11, 0.95); }

        .card-body-content {
            padding: 15px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card h2 {
            margin: 0 0 8px 0;
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-dark); /* Modifié */
            line-height: 1.4;
        }
        
        .house-locked h2, .house-pending h2 { color: var(--text-muted); }

        .card p.description {
            margin: 0 0 12px 0;
            font-size: 0.85rem;
            color: var(--text-light); /* Modifié */
            line-height: 1.5;
        }

        .price-tag {
            font-size: 1.1rem;
            color: #e74c3c;
            font-weight: 700;
            margin-bottom: 0;
        }

        .price-tag span {
            font-size: 0.75rem;
            color: var(--text-muted); /* Modifié */
            font-weight: normal;
        }

        .card-actions {
            padding: 0 15px 15px 15px;
        }

        .btn-modify {
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px;
            flex-grow: 1;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            font-size: 0.85rem;
        }

        .btn-modify:hover { background: var(--primary-hover); color: white; }

        .btn-modify.disabled-lock {
            background: #bdc3c7 !important;
            color: #ffffff !important;
            cursor: not-allowed;
            pointer-events: none;
        }

        .btn-view {
            background: var(--primary-soft); /* Modifié */
            color: var(--text-light);        /* Modifié */
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .btn-view:hover { background: var(--border-color); color: var(--text-dark); }

        .fab-add {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: var(--primary);
            color: white;
            width: 55px;
            height: 55px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.4);
            font-size: 1.3rem;
            text-decoration: none;
            z-index: 1000;
        }

        @media (min-width: 576px) {
            header h1 { font-size: 2rem; }
            .houses { grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); }
        }

        @media (min-width: 768px) {
            .stats-container { margin: -20px auto 30px auto; }
            .stat-details h3 { font-size: 1.6rem; }
            .houses { grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); }
            .image-container { height: 200px; }
        }
    </style>
</head>
<body>

<script>
    (function () {
        const currentTheme = localStorage.getItem('theme');
        if (currentTheme === 'dark') {
            document.body.classList.add('dark-theme');
        }
    })();
</script>

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

    <header>
        <h1>Mon Tableau de Bord</h1>
        <p>Gérez vos biens et suivez la modération de vos annonces.</p>
    </header>

    <div class="stats-container">
        <div class="row g-3 row-cols-1 row-cols-sm-2 row-cols-md-4">
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('statut_moderation', 'publiee')->count() }}</h3>
                        <p>Total Propriétés Publiées</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-building" style="color: #3498db;"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('statut_moderation', 'en_attente')->count() }}</h3>
                        <p>En attente de validation</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-hourglass-half" style="color: #f59e0b;"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->where('est_loue', true)->count() }}</h3>
                        <p>Maisons Louées</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-lock" style="color: #e74c3c;"></i>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ number_format($maisons->where('statut_moderation', 'publiee')->sum('prix'), 0, ',', ' ') }}</h3>
                        <p>Revenu Mensuel (FCFA)</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-wallet" style="color: #27ae60;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="main-container">
        <h2 class="section-title">Mes Maisons Enregistrées</h2>
        
        <section class="houses">
            @foreach($maisons as $maison)
            @php
                $isPending = ($maison->statut_moderation ?? 'publiee') === 'en_attente';
            @endphp
            <div class="card {{ $maison->est_loue ? 'house-locked' : '' }} {{ $isPending ? 'house-pending' : '' }}">
                
                <div class="image-container">
                    <img src="{{ asset($maison->image) }}" alt="{{ $maison['titre'] }}">
                    @if($isPending)
                        <span class="status-badge bg-pending"><i class="fa-solid fa-hourglass-half me-1"></i> En attente</span>
                    @elseif($maison->est_loue)
                        <span class="status-badge bg-locked"><i class="fa-solid fa-lock me-1"></i> Loué</span>
                    @else
                        <span class="status-badge bg-available"><i class="fa-solid fa-circle-check me-1"></i> Disponible</span>
                    @endif
                </div>
                
                <div class="card-body-content">
                    <div>
                        <h2>{{ Str::limit($maison['titre'], 20, '...') }}</h2>
                        <p class="description">{{ Str::limit($maison['description'], 50, '...') }}</p>
                    </div>
                    <p class="price-tag">
                        <strong>{{ number_format($maison['prix'], 0, ',', ' ') }}</strong> <span>FCFA/mois</span>
                    </p>
                </div>

                <div class="card-actions d-flex flex-column gap-2">
                    <div class="d-flex gap-2 w-100">
                        @if($isPending)
                            <button class="btn-modify disabled-lock flex-grow-1" title="Cette annonce est en cours d'examen par l'admin." type="button">
                                <i class="fa-solid fa-ban"></i> En cours d'examen
                            </button>
                        @elseif($maison->est_loue)
                            <button class="btn-modify disabled-lock flex-grow-1" title="Cette maison est louée et verrouillée." type="button">
                                <i class="fa-solid fa-lock"></i> Verrouillé
                            </button>
                        @else
                            <a href="{{ route('maisons.show', $maison->id) }}" class="btn-modify flex-grow-1" onclick="bookNow('{{ $maison['adresse'] }}')">
                                <i class="fa-solid fa-pen-to-square"></i> Modifier
                            </a>
                        @endif
                        
                        <a href="{{ route('maisons.infoA', $maison->id) }}" class="btn-view" title="Aperçu">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>

                    @if(!$isPending)
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
                    @else
                        <button class="btn btn-sm btn-light w-100" disabled style="font-size: 0.75rem; color: var(--text-light);">
                            Indisponible au public tant qu'en attente
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </section>
    </main>

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