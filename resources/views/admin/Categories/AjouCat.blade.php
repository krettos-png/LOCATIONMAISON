<div class="auth-card" style="max-width: 500px; margin: 40px auto;">
    <div class="auth-header">
        <div class="icon-box" style="background: var(--primary-soft); color: var(--primary);">
            <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
            </svg>
        </div>
        <h3>Nouvelle Catégorie</h3>
        <p>Ajouter une catégorie pour classer les maisons</p>
    </div>

    @if($errors->any())
        <div class="error-message-box">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
            </svg>
            <span>Veuillez corriger les erreurs ci-dessous.</span>
        </div>
    @endif

    <form method="POST" action="{{ route('categories.store') }}">
        @csrf

        <div class="input-group">
            <label for="nom">Nom de la catégorie</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" required placeholder="Ex: Appartement, Villa, Chambre...">
            @error('nom')
                <span style="color: #e11d48; font-size: 12px; font-weight: 600; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div class="input-group">
            <label for="description">Description (Optionnel)</label>
            <textarea id="description" name="description" rows="4" required placeholder="Description de ce type de logement..." 
                style="width: 100%; padding: 12px 16px; border-radius: 12px; border: 2px solid #f1f5f9; background: #f8fafc; font-size: 15px; transition: 0.2s; resize: none; font-family: inherit;">{{ old('description') }}</textarea>
            @error('description')
                <span style="color: #e11d48; font-size: 12px; font-weight: 600; margin-top: 4px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: flex; gap: 12px; margin-top: 20px;">
            <a href="javascript:window.history.back();" class="btn-edit" style="flex: 1; text-align: center; padding: 12px; display: flex; align-items: center; justify-content: center;">Annuler</a>
            <button type="submit" class="auth-btn" style="flex: 2; margin-top: 0;">Enregistrer la catégorie</button>
        </div>
    </form>
</div>