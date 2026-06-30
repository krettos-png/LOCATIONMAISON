<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MaisonLoc - Administration</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>

    {{-- Bouton de bascule de navigation pour mobile --}}
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
                <a href="#villes" class="nav-item" onclick="switchTab('villes')">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    Villes
                </a>
                <a href="#maisons" class="nav-item" onclick="switchTab('maisons')">
                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                    Maisons
                    @if(isset($totalMaisonsEnAttente) && $totalMaisonsEnAttente > 0)
                        <span class="sidebar-badge-alert" id="sidebar-counter">{{ $totalMaisonsEnAttente }}</span>
                    @endif
                </a>
            </nav>
            <div class="sidebar-footer">
                <a href="{{ route('home') }}" class="back-home">← Retour au site</a>
            </div>
        </aside>

        <main class="main-content">
            <header class="main-header">
                <h1>Tableau de bord</h1>
                <div class="admin-profile">Gestionnaire</div>
            </header>

            <div class="content-body">
                
                {{-- Zone de notification dynamique gérée par JS --}}
                <div id="ajax-alert" class="alert-banner d-none"></div>

                @if(session('success'))
                  <div class="alert-banner alert-success session-alert">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                  <div class="alert-banner alert-danger session-alert">{{ session('error') }}</div>
                @endif
                
                {{-- SECTION UTILISATEURS --}}
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
                                            <a href="{{ route('tttD', $user->id) }}" class="btn-edit">Pubs</a>
                                            <form method="POST" action="{{ route('utilisateurs.supprimer', $user->id) }}" 
                                                onsubmit="return confirm('⚠️ ATTENTION : Supprimer cet utilisateur supprimera ÉGALEMENT toutes ses maisons enregistrées. Confirmer ?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete">Supprimer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- SECTION CATEGORIES --}}
                <section id="tab-categories" class="tab-content">
                    <div class="section-header">
                        <h2>Gestion des Catégories ({{ $totalCategories }})</h2>
                        <a href="{{ route('categories.create') }}" class="btn-add">+ Nouvelle Catégorie</a>
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
                                            <a href="{{ route('categories.edit', $categorie->id) }}" class="btn-edit">Modifier</a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </section>

                {{-- SECTION VILLES --}}
                <section id="tab-villes" class="tab-content">
                    <div class="section-header">
                        <h2>Gestion des Villes</h2>
                        <span class="stat-mini">Total: ({{ count($villes ?? []) }})</span>
                    </div>

                    <div class="grid-villes">
                        <div class="form-card-ville">
                            <h3 id="form-card-title">Ajouter une ville</h3>
                            <form id="ville-form" action="{{ route('villes.store') }}" method="POST">
                                @csrf
                                <div id="method-container"></div>

                                <div class="form-group-ville">
                                    <label for="region_input">Région</label>
                                    <select required name="region" id="region_input">
                                        <option value="" disabled selected>Sélectionnez la région</option>
                                        <option value="Maritime">Maritime (Grand Lomé)</option>
                                        <option value="Plateaux">Plateaux</option>
                                        <option value="Centrale">Centrale</option>
                                        <option value="Kara">Kara</option>
                                        <option value="Savanes">Savanes</option>
                                    </select>
                                </div>

                                <div class="form-group-ville">
                                    <label for="nom_input">Nom de la ville</label>
                                    <input type="text" id="nom_input" name="nom" placeholder="Ex: Atakpamé" required>
                                </div>

                                <div class="form-actions-ville">
                                    <button type="submit" id="btn-submit-ville" class="btn-submit-green">Enregistrer la ville</button>
                                    <button type="button" id="btn-cancel-edit" class="btn-cancel-gray d-none" onclick="resetFormToCreate()">Annuler</button>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom de la ville</th>
                                        <th>Région</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($villes ?? [] as $ville)
                                    <tr>
                                        <td>#{{ $ville->id }}</td>
                                        <td><strong>{{ $ville->nom }}</strong></td>
                                        <td><span class="badge badge-client">{{ $ville->region }}</span></td>
                                        <td>
                                            <div class="actions-btn">
                                                <button type="button" class="btn-edit" 
                                                        onclick="editVille('{{ $ville->id }}', '{{ addslashes($ville->nom) }}', '{{ $ville->region }}')">
                                                    Modifier
                                                </button>
                                                <form action="{{ route('villes.destroy', $ville->id) }}" method="POST" 
                                                      onsubmit="return confirm('Voulez-vous vraiment supprimer la ville : {{ $ville->nom }} ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn-delete">Supprimer</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: var(--text-light); padding: 30px;">
                                            Aucune ville enregistrée pour le moment.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>

                {{-- SECTION MAISONS --}}
                <section id="tab-maisons" class="tab-content">
                    <div class="section-header">
                        <h2>Gestion des Maisons ({{ $totalMaisons }})</h2>
                        <div class="stats-mini-group">
                            <span class="stat-mini text-warning">En Attente: (<span id="stat-attente">{{ $totalMaisonsEnAttente ?? 0 }}</span>)</span>
                            <span class="stat-mini text-success">Louées: ({{ $totalMaisonsLouees }})</span>
                            <span class="stat-mini text-primary">Disponibles: ({{ $totalMaisonsDisponibles }})</span>
                        </div>
                        <a href="/admin/maisons/creer" class="btn-add">+ Ajouter une maison</a>
                    </div>

                    <div class="internal-tabs">
                        <button class="int-tab-btn active" onclick="filterMaisons('toutes')">Toutes</button>
                        <button class="int-tab-btn text-warning" onclick="filterMaisons('attente')">
                            En attente de validation (<span id="filter-attente">{{ $totalMaisonsEnAttente ?? 0 }}</span>)
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Titre / Emplacement</th>
                                    <th>Prix</th>
                                    <th>Statut Logement</th>
                                    <th>Modération</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($maisons as $maison)
                                <tr id="maison-row-{{ $maison->id }}" class="maison-row status-{{ $maison->statut_moderation ?? 'publiee' }}">
                                    <td><img src="{{ asset($maison->image) }}" class="img-thumb" alt="Maison"></td>
                                    <td>
                                        <div class="title-cell">
                                            <strong>{{ $maison->titre }}</strong>
                                            <span>{{ $maison->emplacement }}</span>
                                        </div>
                                    </td>
                                    <td>{{ number_format($maison->prix, 0, ',', ' ') }} F CFA</td>
                                    <td>
                                        <span class="badge {{ $maison->disponible ? 'badge-success' : 'badge-danger' }}">
                                            {{ $maison->est_loue != 1 ? 'Disponible' : 'Loué' }}
                                        </span>
                                    </td>
                                    <td class="moderation-cell">
                                        @if(($maison->statut_moderation ?? 'publiee') === 'en_attente')
                                            <span class="badge badge-warning">En attente</span>
                                        @else
                                            <span class="badge badge-success">Validée</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="actions-btn">
                                            @if(($maison->statut_moderation ?? 'publiee') === 'en_attente')
                                            {{-- Formulaire de validation --}}
                                            <form action="{{ route('admin.maisons.valider', $maison->id) }}" method="POST" class="ajax-moderation-form" id="form-valider-{{ $maison->id }}" data-id="{{ $maison->id }}" data-action="valider" style="display:inline;">
                                                @csrf
                                                @method('PATCH')
                                                {{-- CHANGEMENT ICI : type="button" et onclick --}}
                                                <button type="button" class="btn-action-success" onclick="envoyerModeration({{ $maison->id }}, 'valider')">✓ Valider</button>
                                            </form>
                                            
                                            {{-- Formulaire de rejet --}}
                                            <form action="{{ route('admin.maisons.rejeter', $maison->id) }}" method="POST" class="ajax-moderation-form" id="form-rejeter-{{ $maison->id }}" data-id="{{ $maison->id }}" data-action="rejeter" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                {{-- CHANGEMENT ICI : type="button" et onclick --}}
                                                <button type="button" class="btn-delete" onclick="envoyerModeration({{ $maison->id }}, 'rejeter')">✕ Rejeter</button>
                                            </form>
                                        @else
                                            <a href="#" class="btn-edit">Modifier</a>
                                        @endif
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
            } else {
                const targetNavLink = document.querySelector(`.nav-menu a[href="#${tabId}"]`);
                if(targetNavLink) targetNavLink.classList.add('active');
            }

            if(window.innerWidth <= 992) {
                document.getElementById('sidebar').classList.remove('open');
                document.getElementById('sidebarOverlay').classList.remove('active');
            }
        }

        function filterMaisons(filter) {
            document.querySelectorAll('.int-tab-btn').forEach(btn => btn.classList.remove('active'));
            if(event) event.currentTarget.classList.add('active');

            const rows = document.querySelectorAll('.maison-row');
            rows.forEach(row => {
                if (filter === 'toutes') {
                    row.style.display = '';
                } else if (filter === 'attente') {
                    if (row.classList.contains('status-en_attente')) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        }

        // --- GESTION DU TRAITEMENT AJAX DES MAISONS (SÉCURITÉ DOUBLE) ---
document.addEventListener("DOMContentLoaded", function() {
    // Faire disparaître automatiquement les messages Flash Blade après 4 secondes
    const sessionAlerts = document.querySelectorAll('.session-alert');
    sessionAlerts.forEach(alert => {
        setTimeout(() => { alert.style.display = 'none'; }, 4000);
    });

    const currentHash = window.location.hash.replace('#', '');
    if(currentHash && document.getElementById('tab-' + currentHash)) {
        switchTab(currentHash);
    }

    // INTERCEPTION CIBLÉE SUR LE CLIC DU BOUTON (Idéal pour les navigateurs mobiles)
    document.addEventListener('click', function(e) {
        // On vérifie si l'élément cliqué est un bouton de validation ou de rejet dans notre formulaire AJAX
        const button = e.target.closest('.ajax-moderation-form button');
        if (!button) return; // Si ce n'est pas un de nos boutons, on ignore

        const form = button.closest('.ajax-moderation-form');
        if (!form) return;

        // ÉTAPE CRUCIALE : On stoppe immédiatement l'action par défaut du bouton et du formulaire
        e.preventDefault();
        e.stopPropagation();

        const formUrl = form.action;
        const formData = new FormData(form);
        const maisonId = form.getAttribute('data-id');
        const actionType = form.getAttribute('data-action');
        const row = document.getElementById(`maison-row-${maisonId}`);

        // Désactiver le bouton temporairement pour éviter les doubles clics sur mobile
        button.disabled = true;

        fetch(formUrl, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
            }
        })
        .then(response => {
            if (!response.ok) throw new Error("Erreur serveur");
            return response.json();
        })
        .then(data => {
            const alertBox = document.getElementById('ajax-alert');
            if (!alertBox) return;
            
            alertBox.classList.remove('d-none', 'alert-success', 'alert-danger');

            if (data.success) {
                alertBox.classList.add('alert-success');
                alertBox.textContent = data.message;

                if (row) {
                    if (actionType === 'valider') {
                        row.classList.remove('status-en_attente');
                        row.classList.add('status-publiee');
                        
                        const modCell = row.querySelector('.moderation-cell');
                        if (modCell) modCell.innerHTML = '<span class="badge badge-success">Validée</span>';
                        
                        const actBtn = row.querySelector('.actions-btn');
                        if (actBtn) actBtn.innerHTML = '<a href="#" class="btn-edit">Modifier</a>';
                    } else {
                        row.style.transition = 'opacity 0.4s ease';
                        row.style.opacity = '0';
                        setTimeout(() => row.remove(), 400);
                    }
                }

                updateCounters(data.totalEnAttente);
            } else {
                alertBox.classList.add('alert-danger');
                alertBox.textContent = data.message || "Une erreur est survenue.";
                button.disabled = false; // Réactiver si échec
            }

            setTimeout(() => { alertBox.classList.add('d-none'); }, 4000);
        })
        .catch(error => {
            console.error('Erreur AJAX:', error);
            button.disabled = false; // Réactiver en cas d'erreur réseau
            const alertBox = document.getElementById('ajax-alert');
            if (alertBox) {
                alertBox.classList.remove('d-none', 'alert-success');
                alertBox.classList.add('alert-danger');
                alertBox.textContent = "Erreur de communication avec le serveur.";
                setTimeout(() => { alertBox.classList.add('d-none'); }, 4000);
            }
        });
    });
});

        function updateCounters(count) {
            const sidebarCounter = document.getElementById('sidebar-counter');
            const statAttente = document.getElementById('stat-attente');
            const filterAttente = document.getElementById('filter-attente');

            if (statAttente) statAttente.textContent = count;
            if (filterAttente) filterAttente.textContent = count;

            if (sidebarCounter) {
                if (count > 0) {
                    sidebarCounter.textContent = count;
                } else {
                    sidebarCounter.remove();
                }
            }
        }

        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleMenu() {
            sidebar.classList.toggle('open');
            sidebarOverlay.classList.toggle('active');
        }

        menuToggle.addEventListener('click', toggleMenu);
        sidebarOverlay.addEventListener('click', toggleMenu);

        // ---- LOGIQUE VILLES ----
        const formVille = document.getElementById('ville-form');
        const cardTitleVille = document.getElementById('form-card-title');
        const btnSubmitVille = document.getElementById('btn-submit-ville');
        const btnCancelVille = document.getElementById('btn-cancel-edit');
        const methodContainerVille = document.getElementById('method-container');
        const inputNomVille = document.getElementById('nom_input');
        const selectRegionVille = document.getElementById('region_input');
        const storeUrlVille = "{{ route('villes.store') }}";

        function editVille(id, nom, region) {
            cardTitleVille.textContent = `Modifier la ville #${id}`;
            btnSubmitVille.textContent = "Mettre à jour";
            btnSubmitVille.className = "btn-submit-blue";
            btnCancelVille.classList.remove('d-none');
            inputNomVille.value = nom;
            selectRegionVille.value = region;
            methodContainerVille.innerHTML = `<input type="hidden" name="_method" value="PUT">`;
            formVille.action = storeUrlVille.replace('/villes', '/villes/' + id);
            document.querySelector('.form-card-ville').scrollIntoView({ behavior: 'smooth' });
        }

        function resetFormToCreate() {
            cardTitleVille.textContent = "Ajouter une ville";
            btnSubmitVille.textContent = "Enregistrer la ville";
            btnSubmitVille.className = "btn-submit-green";
            btnCancelVille.classList.add('d-none');
            formVille.reset();
            methodContainerVille.innerHTML = "";
            formVille.action = storeUrlVille;
        }




        function envoyerModeration(maisonId, actionType) {
    if (actionType === 'rejeter') {
        if (!confirm('Voulez-vous vraiment rejeter et supprimer cette annonce ?')) {
            return;
        }
    }

    const form = document.getElementById(`form-${actionType}-${maisonId}`);
    if (!form) return;

    const formUrl = form.action;
    const formData = new FormData(form);
    const row = document.getElementById(`maison-row-${maisonId}`);

    fetch(formUrl, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        const alertBox = document.getElementById('ajax-alert');
        if (!alertBox) return;
        
        alertBox.classList.remove('d-none', 'alert-success', 'alert-danger');

        if (data.success) {
            alertBox.classList.add('alert-success');
            alertBox.textContent = data.message;

            if (row) {
                if (actionType === 'valider') {
                    row.classList.remove('status-en_attente');
                    row.classList.add('status-publiee');
                    
                    const modCell = row.querySelector('.moderation-cell');
                    if (modCell) modCell.innerHTML = '<span class="badge badge-success">Validée</span>';
                    
                    const actBtn = row.querySelector('.actions-btn');
                    if (actBtn) actBtn.innerHTML = '<a href="#" class="btn-edit">Modifier</a>';
                } else {
                    row.style.transition = 'opacity 0.4s ease';
                    row.style.opacity = '0';
                    setTimeout(() => row.remove(), 400);
                }
            }
            updateCounters(data.totalEnAttente);
        } else {
            alertBox.classList.add('alert-danger');
            alertBox.textContent = data.message || "Une erreur est survenue.";
        }

        setTimeout(() => { alertBox.classList.add('d-none'); }, 4000);
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert("Erreur de communication avec le serveur.");
    });
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
            --success: #10b981;
            --warning: #f59e0b;
            --warning-soft: #fef3c7;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Segoe UI', system-ui, sans-serif; }
        body { background: var(--bg-main); color: var(--text-dark); overflow-x: hidden; }
        .admin-container { display: flex; min-height: 100vh; position: relative; }

        .sidebar { 
            width: 260px; 
            background: #0f172a; 
            color: white; 
            padding: 30px 20px; 
            display: flex; 
            flex-direction: column; 
            shrink: 0; 
            z-index: 1000; 
            transition: transform 0.3s ease; 
        }
        .brand h2 { font-size: 20px; font-weight: 800; margin-bottom: 40px; }
        .brand h2 span { color: var(--primary); }
        .nav-menu { display: flex; flex-direction: column; gap: 8px; flex: 1; }
        .nav-item { 
            display: flex; align-items: center; gap: 12px; color: #94a3b8; padding: 12px 16px; 
            border-radius: 12px; text-decoration: none; font-weight: 600; transition: 0.2s; cursor: pointer;
            position: relative;
        }
        .nav-item:hover, .nav-item.active { background: var(--primary); color: white; }
        .sidebar-badge-alert { position: absolute; right: 15px; background: var(--warning); color: #0f172a; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 10px; }
        .back-home { color: #94a3b8; text-decoration: none; font-size: 14px; }

        .main-content { flex: 1; padding: 40px; min-width: 0; }
        .main-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 15px; }
        .main-header h1 { font-size: 26px; font-weight: 800; }
        .admin-profile { background: var(--bg-card); padding: 8px 16px; border-radius: 20px; font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.05); white-space: nowrap; }

        .tab-content { display: none; }
        .tab-content.active { display: block; animation: fadeIn 0.3s ease-in-out; }

        .section-header { display: flex; flex-direction: column; gap: 15px; background: var(--bg-card); padding: 20px; border-radius: 16px; margin-bottom: 20px; border: 1px solid var(--border); }
        @media (min-width: 768px) { .section-header { flex-direction: row; justify-content: space-between; align-items: center; } }
        
        .section-header h2 { font-size: 18px; font-weight: 700; color: var(--text-dark); }
        .stats-mini-group { display: flex; flex-wrap: wrap; gap: 10px; }
        .stat-mini { background: #f1f5f9; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 600; color: var(--text-light); }
        .stat-mini.text-success { background: #dcfce7; color: #16a34a; }
        .stat-mini.text-primary { background: #dbeafe; color: #2563eb; }
        .stat-mini.text-warning { background: var(--warning-soft); color: #b45309; }

        .internal-tabs { display: flex; gap: 10px; margin-bottom: 15px; }
        .int-tab-btn { background: #e2e8f0; border: none; padding: 8px 16px; font-weight: 700; font-size: 13px; border-radius: 8px; cursor: pointer; transition: 0.2s; }
        .int-tab-btn.active { background: #0f172a; color: white !important; }

        .btn-add { background: var(--primary); color: white; padding: 10px 20px; border-radius: 10px; text-decoration: none; font-weight: 700; font-size: 14px; text-align: center; white-space: nowrap; }
        .btn-add:hover { background: #1d4ed8; }

        .table-responsive { background: var(--bg-card); border-radius: 16px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow-x: auto; border: 1px solid var(--border); -webkit-overflow-scrolling: touch; }
        .data-table { width: 100%; border-collapse: collapse; text-align: left; min-width: 700px; }
        .data-table th { background: #f1f5f9; padding: 16px; font-size: 13px; font-weight: 700; color: var(--text-light); text-transform: uppercase; }
        .data-table td { padding: 16px; border-bottom: 1px solid var(--border); font-size: 15px; vertical-align: middle; }

        .img-thumb { width: 50px; height: 50px; border-radius: 8px; object-fit: cover; }
        .title-cell { display: flex; flex-direction: column; }
        .title-cell span { font-size: 13px; color: var(--text-light); }
        
        .badge { padding: 6px 12px; border-radius: 20px; font-size: 12px; font-weight: 700; display: inline-block; text-align: center; }
        .badge-admin { background: #fee2e2; color: #ef4444; }
        .badge-client { background: #e0f2fe; color: #0369a1; }
        .badge-success { background: #dcfce7; color: #15803d; }
        .badge-danger { background: #ffedd5; color: #c2410c; }
        .badge-warning { background: var(--warning-soft); color: #b45309; }

        .actions-btn { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
        .btn-edit { background: var(--primary-soft); color: var(--primary); padding: 6px 14px; border-radius: 8px; text-decoration: none; font-weight: 700; font-size: 13px; cursor: pointer; border: none; }
        .btn-delete { background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; }
        .btn-action-success { background: #dcfce7; color: #16a34a; border: 1px solid #bbf7d0; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 13px; cursor: pointer; transition: 0.2s; }
        .btn-action-success:hover { background: #16a34a; color: white; }

        .alert-banner { padding: 15px 20px; border-radius: 12px; margin-bottom: 25px; font-weight: 600; font-size: 14px; }
        .alert-success { background: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
        .alert-danger { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

        .grid-villes { display: grid; grid-template-columns: 1fr; gap: 25px; align-items: start; }
        @media (min-width: 992px) { .grid-villes { grid-template-columns: 320px 1fr; } }
        .form-card-ville { background: var(--bg-card); padding: 25px; border-radius: 16px; border: 1px solid var(--border); }
        .form-card-ville h3 { font-size: 16px; font-weight: 700; margin-bottom: 20px; }
        .form-group-ville { margin-bottom: 15px; }
        .form-group-ville label { display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px; }
        .form-group-ville input, .form-card-ville select { width: 100%; padding: 12px; border: 1px solid var(--border); border-radius: 8px; font-size: 14px; background-color: var(--bg-main); outline: none; }
        
        .form-actions-ville { display: flex; flex-direction: column; gap: 10px; margin-top: 20px; }
        .btn-submit-green { background: var(--success); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; }
        .btn-submit-blue { background: var(--primary); color: white; border: none; padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; }
        .btn-cancel-gray { background: #f1f5f9; color: var(--text-light); border: 1px solid var(--border); padding: 12px; border-radius: 8px; font-weight: 700; font-size: 14px; cursor: pointer; }

        .d-none { display: none !important; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        .mobile-nav-toggle { 
            display: none; 
            position: fixed; 
            top: 15px; 
            right: 15px; 
            background: #0f172a; 
            color: white; 
            border: none; 
            padding: 10px; 
            border-radius: 8px; 
            cursor: pointer; 
            z-index: 1010; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
        }
        .sidebar-overlay { 
            display: none; 
            position: fixed; 
            inset: 0; 
            background: rgba(15, 23, 42, 0.4); 
            backdrop-filter: blur(2px); 
            z-index: 999; 
        }

        @media (max-width: 992px) {
            .mobile-nav-toggle { display: block; }
            .sidebar-overlay.active { display: block; }
            
            .sidebar { 
                position: fixed; 
                top: 0; 
                left: 0; 
                bottom: 0; 
                transform: translateX(-100%); 
                transition: transform 0.3s ease; 
            }
            .sidebar.open { transform: translateX(0); }
            
            .main-content { padding: 20px; padding-top: 70px; }
            .main-header h1 { font-size: 20px; }
            .admin-profile { font-size: 13px; padding: 6px 12px; }
        }
    </style>

</body>
</html>