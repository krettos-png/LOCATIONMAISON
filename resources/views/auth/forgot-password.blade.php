<div class="auth-container">
    <div class="auth-card">
        <h3>Mot de passe oublié ? 🔑</h3>
        <p>Pas de panique ! Entrez votre adresse e-mail et nous vous enverrons un lien pour en créer un nouveau.</p>

        @if (session('status'))
            <div class="alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="input-group">
                <label>Votre adresse e-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="exemple@mail.com" required autofocus>
                @error('email')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="auth-btn">Envoyer le lien</button>
        </form>

        <a href="/" class="back-to-login">← Retour à l'accueil</a>
    </div>
</div>



<style>
    /* Container principal pour centrer la carte verticalement et horizontalement */
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8fafc; /* Gris très clair */
    padding: 20px;
    font-family: 'Poppins', sans-serif;
}

/* La carte blanche */
.auth-card {
    background: #ffffff;
    width: 100%;
    max-width: 400px;
    padding: 40px;
    border-radius: 20px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
    text-align: center;
}

.auth-card h3 {
    color: #1e293b;
    font-size: 24px;
    margin-bottom: 10px;
    font-weight: 700;
}

.auth-card p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.5;
    margin-bottom: 30px;
}

/* Groupes d'entrée */
.input-group {
    text-align: left;
    margin-bottom: 20px;
}

.input-group label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 8px;
}

.input-group input {
    width: 100%;
    padding: 12px 16px;
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    font-size: 14px;
    transition: all 0.3s ease;
    outline: none;
}

.input-group input:focus {
    border-color: #3b82f6; /* Couleur primaire */
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

/* Bouton principal */
.auth-btn {
    width: 100%;
    background-color: #3b82f6;
    color: white;
    border: none;
    padding: 14px;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.3s ease;
}

.auth-btn:hover {
    background-color: #2563eb;
}

/* Alertes de succès */
.alert-success {
    background-color: #f0fdf4;
    color: #16a34a;
    padding: 12px;
    border-radius: 10px;
    font-size: 13px;
    margin-bottom: 20px;
    border: 1px solid #bbf7d0;
}

/* Lien de retour */
.back-to-login {
    display: block;
    margin-top: 20px;
    font-size: 13px;
    color: #64748b;
    text-decoration: none;
}

.back-to-login:hover {
    color: #3b82f6;
}
</style>