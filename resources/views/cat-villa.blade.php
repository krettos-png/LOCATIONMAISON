<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaisonLoc - Administration</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>


    <div class="admin-container">
        <aside class="sidebar">
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
                        <h2>Gestion des Utilisateurs       ({{ $totalUtilisateurs }})</h2>
                        <h2>Propriétaires ({{ $totalUtilisateursadmin }})</h2>
                        <h2>Clients ({{ $totalUtilisateursclient }})</h2>
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
                                    <div class="actions-btn" style="display: flex; gap: 8px; align-items: center;">
                                        <a href="/dev/{{ $user->id }}" class="btn-edit">Pubs</a>
                                        
                                        <form method="POST" action="/admin/utilisateurs/{{ $user->id }}/delete" 
                                            onsubmit="return confirm('⚠️ ATTENTION : Supprimer cet utilisateur supprimera ÉGALEMENT toutes ses maisons enregistrées. Confirmer ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; transition: 0.2s;">
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
                        <h2>Gestion des Maisons Total: ({{ $totalMaisons }})</h2>
                        <h2>Total des Maisons louées: ({{ $totalMaisonsLouees }})</h2>
                        <h2>Total des Maisons disponibles: ({{ $totalMaisonsDisponibles }})</h2>
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
            // Supprimer la classe active de tous les onglets
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(item => item.classList.remove('active'));
            
            // Activer le bon contenu et le bon bouton
            document.getElementById('tab-' + tabId).classList.add('active');
            event.currentTarget.classList.add('active');
        }
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
body { background: var(--bg-main); color: var(--text-dark); }

.admin-container { display: flex; min-height: 100vh; }

/* SIDEBAR */
.sidebar { width: 260px; background: #0f172a; color: white; padding: 30px 20px; display: flex; flex-direction: column; }
.brand h2 { font-size: 20px; font-weight: 800; margin-bottom: 40px; }
.brand h2 span { color: var(--primary); }
.nav-menu { display: flex; flex-direction: column; gap: 8px; flex: 1; }
.nav-item { 
  display: flex; align-items: center; gap: 12px; color: #94a3b8; padding: 12px 16px; 
  border-radius: 12px; text-decoration: none; font-weight: 600; transition: 0.2s; 
}
.nav-item:hover, .nav-item.active { background: var(--primary); color: white; }
.back-home { color: #94a3b8; text-decoration: none; font-size: 14px; }

/* CONTENU PRINCIPAL */
.main-content { flex: 1; padding: 40px; max-width: calc(100vw - 260px); }
.main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
.main-header h1 { font-size: 26px; font-weight: 800; }
.admin-profile { background: var(--bg-card); padding: 8px 16px; border-radius: 20px; font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.05); }

/* SECTIONS & ONGLETS */
.tab-content { display: none; }
.tab-content.active { display: block; animation: fadeIn 0.3s ease-in-out; }

.section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
.btn-add { background: var(--primary); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; }
.btn-add:hover { background: #1d4ed8; }

/* TABLEAUX DE DONNÉES */
.table-responsive { background: var(--bg-card); border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; border: 1px solid var(--border); }
.data-table { width: 100%; border-collapse: collapse; text-align: left; }
.data-table th { background: #f1f5f9; padding: 16px; font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; }
.data-table td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 15px; vertical-align: middle; }
.data-table tr:last-child td { border-bottom: none; }

/* ÉLÉMENTS DE TABLEAU */
.img-thumb { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; }
.title-cell { display: flex; flex-direction: column; }
.title-cell span { font-size: 13px; color: var(--text-light); }
.badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; }
.badge-admin { background: #fee2e2; color: #ef4444; }
.badge-client { background: #e0f2fe; color: #0369a1; }
.badge-success { background: #dcfce7; color: #15803d; }
.badge-danger { background: #ffedd5; color: #c2410c; }

.btn-edit { background: var(--primary-soft); color: var(--primary); padding: 6px 14px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 13px; transition: 0.2s; }
.btn-edit:hover { background: var(--primary); color: white; }

@keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    </style>







</body>
</html>