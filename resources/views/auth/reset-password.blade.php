<div class="auth-container">
    <div class="auth-card">
        <h3>Nouveau mot de passe 🔒</h3>
        <p>Saisissez votre nouveau mot de passe ci-dessous pour sécuriser votre compte.</p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            {{-- Jeton de réinitialisation masqué --}}
            <input type="hidden" name="token" value="{{ $token }}">

            {{-- Champ Adresse E-mail (lecture seule) --}}
            <div class="input-group">
                <label>Votre adresse e-mail</label>
                <input type="email" name="email" value="{{ $email ?? old('email') }}" required readonly class="input-readonly">
                @error('email')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Champ Nouveau mot de passe --}}
            <div class="input-group">
                <label>Nouveau mot de passe</label>
                <input type="password" name="password" placeholder="••••••••" required autofocus>
                @error('password')
                    <span style="color: #ef4444; font-size: 12px; margin-top: 5px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Champ Confirmation du mot de passe --}}
            <div class="input-group">
                <label>Confirmer le mot de passe</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" required>
            </div>

            <button type="submit" class="auth-btn">Mettre à jour le mot de passe</button>
        </form>

        <a href="{{ route('login') }}" class="back-to-login">← Annuler et se connecter</a>
    </div>
</div>

<style>
/* Style identique à ta première vue */
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8fafc;
    padding: 20px;
    font-family: 'Poppins', sans-serif;
}

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
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

/* Style pour le champ e-mail en lecture seule */
.input-readonly {
    background-color: #f1f5f9;
    color: #64748b;
    cursor: not-allowed;
}

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