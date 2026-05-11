<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion - MaisonLoc</title>

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    body {
      background: url('{{ asset('image/6.jpg') }}') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding-top: 70px;
    }

    nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color: #222;
      color: white;
      padding: 15px 30px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      z-index: 1000;
    }

    nav .brand {
      font-weight: bold;
      font-size: 20px;
    }

    nav ul {
      list-style: none;
      display: flex;
      gap: 20px;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-size: 14px;
    }

    nav a:hover {
      text-decoration: underline;
    }

    .login-card {
      background-color: white;
      border-radius: 15px;
      padding: 30px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    }

    .login-card h3 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 15px;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
    }

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .checkbox-row {
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 14px;
      margin-bottom: 15px;
    }

    .btn {
      display: inline-block;
      width: 100%;
      padding: 10px;
      background-color: #007bff;
      border: none;
      border-radius: 5px;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    .btn:hover {
      background-color: #0056b3;
    }

    .alert {
      background-color: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
    }

    .footer-text {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .footer-text a {
      color: #007bff;
      text-decoration: none;
    }

    .footer-text a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav>
    <div class="brand">MaisonLoc</div>
    <ul>
      <li><a href="/">Accueil</a></li>
      <li><a href="/inscription">Inscription</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>

  <!-- Login Card -->
  <div class="login-card">
    <h3>Connexion</h3>

    <form method="POST" action="/login">
      @csrf

      @if($errors->any())
        <div class="alert">
          {{ $errors->first() }}
        </div>
      @endif

      <div class="form-group">
        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" required autofocus>
      </div>

      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="checkbox-row">
        <label>
          <input type="checkbox" name="remember"> Se souvenir de moi
        </label>
        <a href="#" style="font-size: 13px;">Mot de passe oublié ?</a>
      </div>

      <button type="submit" class="btn">Se connecter</button>
    </form>

    <div class="footer-text">
      Pas encore de compte ? <a href="/inscription">S’inscrire</a>
    </div>
  </div>

</body>
</html>
























