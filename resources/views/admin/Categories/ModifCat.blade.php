<div class="auth-card" style="max-width: 500px; margin: 40px auto;">
    <div class="auth-header">
        <div class="icon-box" style="background: var(--primary-soft); color: var(--primary);">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg>
        </div>
        <h3>Modifier la Catégorie</h3>
        <p>Mettre à jour les informations de la catégorie #{{ $categorie->id }}</p>
    </div>

    @if($errors->any())
        <div class="error-message-box">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <span>Veuillez corriger les erreurs ci-dessous.</span>
        </div>
    @endif

    <form method="POST" action="/admin/categories/{{ $categorie->id }}/update">
        @csrf
        @method('PUT') {{-- Obligatoire dans Laravel pour les mises à jour --}}

        <div class="input-group">
            <label for="nom">Nom de la catégorie</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom', $categorie->nom) }}" required>
            @error('nom')
                <span style="color: #e11d48; font-size: 12px; font-weight: 600; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <label for="description">Description (Optionnel)</label>
            <textarea id="description" required name="description" rows="4" 
                style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid #f1f5f9; background: #f8fafc; font-size: 15px; transition: 0.2s; resize: none; font-family: inherit;">{{ old('description', $categorie->description) }}</textarea>
            @error('description')
                <span style="color: #e11d48; font-size: 12px; font-weight: 600; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <a href="javascript:window.history.back();" class="btn-edit" style="flex: 1; text-align: center; padding: 12px; display: flex; align-items: center; justify-content: center;">Annuler</a>
            <button type="submit" class="auth-btn" style="flex: 2; margin-top: 0;">Mettre à jour</button>
        </div>
    </form>

    <hr style="border: 0; border-top: 1px solid #e2e8f0; margin: 25px 0;">

    <div style="text-align: center;">
        <form method="POST" action="/admin/categories/{{ $categorie->id }}/delete" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ? Cette action est irréversible.');">
            @csrf
            @method('DELETE')
            <button type="submit" style="background: #fff1f2; color: #e11d48; border: 1px solid #ffe4e6; padding: 10px 20px; border-radius: 12px; font-weight: 700; cursor: pointer; font-size: 13px; transition: 0.2s; width: 100%;">
                ⚠️ Supprimer définitivement cette catégorie
            </button>
        </form>
    </div>
</div>