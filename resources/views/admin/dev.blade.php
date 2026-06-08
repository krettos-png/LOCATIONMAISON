<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaisonLoc - Administration</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    <button class="mobile-nav-toggle" id="menuToggle" aria-label="Ouvrir le menu">
        <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
            <line x1="3" y1="12" x2="21" y2="12"></line>
            <line x1="3" y1="6" x2="21" y2="6"></line>
            <line x1="3" y1="18" x2="21" y2="18"></line>
        </svg>
    </button>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-container">
        <aside class="sidebar" id="sidebar">
            <div class="brand">
                <h2>MaisonLoc <span>Admin</span></h2>
            </div>
            <nav class="nav-menu">
                <a href="#utilisateurs" class="nav-item active" onclick="switchTab('utilisateurs')">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Utilisateurs
                </a>
                <a href="#categories" class="nav-item" onclick="switchTab('categories')">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    Catégories
                </a>
                <a href="#maisons" class="nav-item" onclick="switchTab('maisons')">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Maisons
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="/" class="back-home">← Retour au site</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Tableau de bord</h1>
                <div class="admin-profile">Gestionnaire</div>
            </header>

            <div class="content-body">
                
                <section id="tab-utilisateurs" class="tab-content active">
                    <div class="section-header">
                        <h2>Gestion des Utilisateurs ({{ $totalUtilisateurs }})</h2>
                        <div class="stats-mini-group">
                            <span class="stat-mini">Propriétaires ({{ $totalUtilisateursadmin }})</span>
                            <span class="stat-mini">Clients ({{ $totalUtilisateursclient }})</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Nom & Prénom</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Rôle</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($utilisateurs as $user)
                                <tr>
                                    <td><strong>{{ $user->name }}</strong> {{ $user->prenom }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->contact }}</td>
                                    <td><span class="badge {{ $user->role === 'admin' ? 'badge-admin' : 'badge-client' }}">{{ $user->role }}</span></td>
                                    <td>
                                        <div class="actions-btn">
                                            <a href="/dev/{{ $user->id }}" class="btn-edit">Pubs</a>
                                            <form method="POST" action="/admin/utilisateurs/{{ $user->id }}/delete" 
                                                onsubmit="return confirm('⚠️ ATTENTION : Supprimer cet utilisateur supprimera ÉGALEMENT toutes ses maisons enregistrées. Confirmer ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="tab-categories" class="tab-content">
                    <div class="section-header">
                        <h2>Gestion des Catégories ({{ $totalCategories }})</h2>
                        <a href="/admin/categories/creer" class="btn-add">+ Nouvelle Catégorie</a>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom de la catégorie</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $categorie)
                                <tr>
                                    <td>#{{ $categorie->id }}</td>
                                    <td><strong>{{ $categorie->nom }}</strong></td>
                                    <td>
                                        <div class="actions-btn">
                                            <a href="/admin/categories/{{ $categorie->id }}/modifier" class="btn-edit">Modifier</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="tab-maisons" class="tab-content">
                    <div class="section-header">
                        <h2>Gestion des Maisons ({{ $totalMaisons }})</h2>
                        <div class="stats-mini-group">
                            <span class="stat-mini text-success">Louées: ({{ $totalMaisonsLouees }})</span>
                            <span class="stat-mini text-primary">Disponibles: ({{ $totalMaisonsDisponibles }})</span>
                        </div>
                        <a href="/admin/maisons/creer" class="btn-add">+ Ajouter une maison</a>
                    </div>
                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Titre / Emplacement</th>
                                    <th>Prix</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maisons as $maison)
                                <tr>
                                    <td><img src="{{ asset('storage/' . $maison->image) }}" class="img-thumb" alt="Maison"></td>
                                    <td>
                                        <div class="title-cell">
                                            <strong>{{ $maison->titre }}</strong>
                                            <span>{{ $maison->emplacement }}</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($maison->prix, 0, ',', ' ') }} F CFA</td>
                                    <td><span class="badge {{ $maison->disponible ? 'badge-success' : 'badge-danger' }}">{{ $maison->est_loue!=1 ? 'Disponible' : 'Loué' }}</span></td>
                                    <td>
                                        <div class="actions-btn">
                                            <a href="#" class="btn-edit">Modifier</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

            </div>
        </main>
    </div>

    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            
            document.getElementById('tab-' + tabId).classList.add('active');
            
            if(event && event.currentTarget) {
                event.currentTarget.classList.add('active');
            }

            // Ferme automatiquement le menu mobile après sélection d'un onglet
            if(window.innerWidth <= 992) {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('active');
            }
        }

        // Logique de gestion du menu mobile
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleMenu() {
            sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('active');
        }

        menuToggle.addEventListener('click', toggleMenu);
        sidebarOverlay.addEventListener('click', toggleMenu);
    </script>

    <style>
        :root {
            --primary: #2563eb;
            --primary-soft: #eff6ff;
            --text-dark: #1e293b;
            --text-light: #64748b;
            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --border: #e2e8f0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background: var(--bg-main); color: var(--text-dark); overflow-x: hidden; }

        .admin-container { display: flex; min-height: 100vh; position: relative; }

        /* SIDEBAR COMPATIBLE BUREAU */
        .sidebar { width: 260px; background: #0f172a; color: white; padding: 30px 20px; display: flex; flex-direction: column; shrink: 0; z-index: 1000; transition: transform 0.3s ease; }
        .brand h2 { font-size: 20px; font-weight: 800; margin-bottom: 40px; }
        .brand h2 span { color: var(--primary); }
        .nav-menu { display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .nav-item { 
            display: flex; align-items: center; gap: 12px; color: #94a3b8; padding: 12px 16px; 
            border-radius: 12px; text-decoration: none; font-weight: 600; transition: 0.2s; 
        }
        .nav-item:hover, .nav-item.active { background: var(--primary); color: white; }
        .back-home { color: #94a3b8; text-decoration: none; font-size: 14px; }

        /* TOGGLE MOBILE */
        .mobile-nav-toggle { display: none; position: fixed; top: 15px; right: 15px; background: #0f172a; color: white; border: none; padding: 10px; border-radius: 8px; cursor: pointer; z-index: 1010; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); backdrop-filter: blur(2px); z-index: 999; }

        /* CONTENU PRINCIPAL */
        .main-content { flex: 1; padding: 40px; min-width: 0; }
        .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 15px; }
        .main-header h1 { font-size: 26px; font-weight: 800; }
        .admin-profile { background: var(--bg-card); padding: 8px 16px; border-radius: 20px; font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.05); white-space: nowrap; }

        /* SECTIONS & CONTENEURS */
        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s ease-in-out; }

        .section-header { display: flex; flex-direction: column; gap: 15px; background: var(--bg-card); padding: 20px; border-radius: 16px; margin-bottom: 20px; border: 1px solid var(--border); }
        @media (min-width: 768px) {
            .section-header { flex-direction: row; justify-content: space-between; align-items: center; }
        }
        
        .section-header h2 { font-size: 18px; font-weight: 700; color: var(--text-dark); }
        .stats-mini-group { display: flex; flex-wrap: wrap; gap: 10px; }
        .stat-mini { background: #f1f5f9; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--text-light); }
        .stat-mini.text-success { background: #dcfce7; color: #16a34a; }
        .stat-mini.text-primary { background: #dbeafe; color: #2563eb; }

        .btn-add { background: var(--primary); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; text-align: center; white-space: nowrap; }
        .btn-add:hover { background: #1d4ed8; }

        /* CONTENANT DE TABLEAU SÉCURISÉ POUR LE MOBILE */
        .table-responsive { background: var(--bg-card); border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow-x: auto; border: 1px solid var(--border); -webkit-overflow-scrolling: touch; }
        .data-table { width: 100%; border-collapse: collapse; text-align: left; min-width: 700px; }
        .data-table th { background: #f1f5f9; padding: 16px; font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; white-space: nowrap; }
        .data-table td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 15px; vertical-align: middle; }
        .data-table tr:last-child td { border-bottom: none; }

        /* ÉLÉMENTS DE TABLEAU */
        .img-thumb { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; }
        .title-cell { display: flex; flex-direction: column; }
        .title-cell span { font-size: 13px; color: var(--text-light); }
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; text-align: center; }
        .badge-admin { background: #fee2e2; color: #ef4444; }
        .badge-client { background: #e0f2fe; color: #0369a1; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-danger { background: #ffedd5; color: #c2410c; }

        .actions-btn { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .btn-edit { background: var(--primary-soft); color: var(--primary); padding: 6px 14px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 13px; transition: 0.2s; text-align: center; }
        .btn-edit:hover { background: var(--primary); color: white; }
        .btn-delete { background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; transition: 0.2s; }
        .btn-delete:hover { background: #ffe4e6; }

        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        /* MEDIA QUERIES RESPONSIVE COMPACT */
        @media (max-width: 992px) {
            .mobile-nav-toggle { display: block; }
            .sidebar-overlay.active { display: block; }
            
            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                transform: translateX(-100%);
                z-index: 1005;
                box-shadow: 10px 0 30px rgba(15, 23, 42, 0.15);
            }
            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                padding: 80px 20px 40px 20px;
            }
        }

        @media (max-width: 576px) {
            .main-header h1 { font-size: 20px; }
            .admin-profile { font-size: 13px; padding: 6px 12px; }
            .section-header { padding: 15px; }
        }
    </style>

</body>
</html>