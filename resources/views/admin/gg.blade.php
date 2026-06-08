<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Back-Office Développeur - MaisonLoc</title>
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
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
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
            color: #d2dae2;
            font-size: 1rem;
            margin-bottom: 0;
        }

        /* Statistiques */
        .stats-container {
            max-width: 1300px;
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

        /* Conteneur Principal */
        .main-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px 50px 20px;
        }

        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
            margin-bottom: 25px;
        }

        .nav-tabs .nav-link {
            color: #7f8c8d;
            font-weight: 600;
            border: none;
            padding: 12px 20px;
            transition: all 0.2s;
        }

        .nav-tabs .nav-link.active {
            color: #1e3c72;
            background: transparent;
            border-bottom: 3px solid #1e3c72;
        }

        .card-table {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.04);
            border: none;
            padding: 20px;
        }

        .table img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 8px;
        }

        .table th {
            font-weight: 600;
            color: #34495e;
            border-bottom-width: 1px;
        }

        .table td {
            vertical-align: middle;
        }

        .badge-role {
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="fa-solid fa-screwdriver-wrench me-2"></i>MaisonLoc - Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/" target="_blank">
                            <i class="fa-solid fa-globe me-1"></i> Voir le site
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <header>
        <h1>Tableau de Bord Développeur</h1>
        <p>Gestion globale de la plateforme : Utilisateurs, Catégories et Propriétés.</p>
    </header>

    <div class="stats-container">
        <div class="row g-3">
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $utilisateurs->count() }}</h3>
                        <p>Utilisateurs Inscrits</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-users" style="color: #3498db;"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $categories->count() }}</h3>
                        <p>Catégories de Maison</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-tags" style="color: #e67e22;"></i>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="stat-details">
                        <h3>{{ $maisons->count() }}</h3>
                        <p>Total Maisons Publiées</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fa-solid fa-house" style="color: #27ae60;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <main class="main-container">
        
        <ul class="nav nav-tabs" id="adminTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button" role="tab"><i class="fa-solid fa-users me-2"></i>Utilisateurs</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab"><i class="fa-solid fa-tags me-2"></i>Catégories</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="houses-tab" data-bs-toggle="tab" data-bs-target="#houses" type="button" role="tab"><i class="fa-solid fa-house me-2"></i>Maisons</button>
            </li>
        </ul>

        <div class="tab-content" id="adminTabsContent">
            
            <div class="tab-pane fade show active" id="users" role="tabpanel">
                <div class="card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="m-0">Liste des Utilisateurs</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom / Prénom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilisateurs as $user)
                                <tr>
                                    <td>#{{ $user->id }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role == 'admin')
                                            <span class="badge bg-danger badge-role">Admin</span>
                                        @elseif($user->role == 'proprietaire')
                                            <span class="badge bg-primary badge-role">Propriétaire</span>
                                        @else
                                            <span class="badge bg-secondary badge-role">Client</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="/admin/users/{{ $user->id }}/edit" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-pen"></i></a>
                                            <form action="/admin/users/{{ $user->id }}" method="POST" onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="categories" role="tabpanel">
                <div class="card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="m-0">Catégories Disponibles</h4>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                            <i class="fa-solid fa-plus me-1"></i> Nouvelle Catégorie
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Nom de la catégorie</th>
                                    <th>Slug / Code</th>
                                    <th>Nombre de maisons</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $categorie)
                                <tr>
                                    <td>#{{ $categorie->id }}</td>
                                    <td><strong>{{ $categorie->nom }}</strong></td>
                                    <td><code>{{ $categorie->slug }}</code></td>
                                    <td>{{ $categorie->maisons_count ?? 0 }} maisons</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <form action="/admin/categories/{{ $categorie->id }}" method="POST" onsubmit="return confirm('Supprimer cette catégorie ?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="houses" role="tabpanel">
                <div class="card-table">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="m-0">Toutes les Maisons du site</h4>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Titre</th>
                                    <th>Propriétaire</th>
                                    <th>Prix (FCFA)</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maisons as $maison)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $maison->image) }}" alt="">
                                    </td>
                                    <td>
                                        <strong>{{ Str::limit($maison->titre, 25) }}</strong><br>
                                        <small class="text-muted"><i class="fa-solid fa-location-dot me-1"></i>{{ $maison->adresse }}</small>
                                    </td>
                                    <td>{{ $maison->user->name ?? 'Inconnu' }}</td>
                                    <td><span class="text-danger fw-bold">{{ number_format($maison->prix, 0, ',', ' ') }}</span></td>
                                    <td>
                                        @if($maison->est_loue)
                                            <span class="badge bg-danger">Loué</span>
                                        @else
                                            <span class="badge bg-success">Disponible</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="/maison/{{ $maison->id }}" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-eye"></i></a>
                                            <form action="/admin/maison/{{ $maison->id }}/toggle-status" method="POST">
                                                @csrf @method('PATCH')
                                                <button class="btn btn-sm {{ $maison->est_loue ? 'btn-outline-success' : 'btn-outline-warning' }}" title="Changer le statut">
                                                    <i class="fa-solid {{ $maison->est_loue ? 'fa-lock-open' : 'fa-lock' }}"></i>
                                                </button>
                                            </form>
                                            <form action="/admin/maison/{{ $maison->id }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette annonce ?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter une nouvelle catégorie</h5>
                    <button type="button" class="btn-close" data-bs-shadow="none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/admin/categories" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nom" class="form-label">Nom de la catégorie</label>
                            <input type="text" class="form-control" id="nom" name="nom" placeholder="Ex: Villa, Appartement, Studio" required>
                        </div>
                        <div class="mb-3">
                            <label for="slug" class="form-label">Code / Slug (Optionnel)</label>
                            <input type="text" class="form-control" id="slug" name="slug" placeholder="Ex: villa, appartement">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>