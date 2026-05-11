<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inscription - MaisonLoc</title>

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
      padding-top: 80px;
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

    .register-card {
      background-color: white;
      border-radius: 15px;
      padding: 30px;
      width: 100%;
      max-width: 450px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      margin-top: 60px;
    }

    h3 {
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

    input[type="text"],
    input[type="number"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border-radius: 5px;
      border: 1px solid #ccc;
    }

    .radio-group {
      margin-bottom: 15px;
    }

    .radio-group label {
      margin-right: 20px;
      font-weight: normal;
    }

    .text-primary {
      color: #007bff;
    }

    .text-success {
      color: #28a745;
    }

    .text-danger {
      color: #dc3545;
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

    .text-error {
      color: red;
      font-size: 14px;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav>
    <div class="brand">MaisonLoc</div>
    <ul>
      <li><a href="/">Accueil</a></li>
      <li><a href="/login">Connexion</a></li>
      <li><a href="#">Contact</a></li>
    </ul>
  </nav>

  <!-- Formulaire d'inscription -->
  <div class="register-card">
    <h3>Créer un compte</h3>

    <form method="POST" action="/enregistrer/store" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label class="text-primary"><h5>Avez-vous des maisons à louer ?</h5></label>
        <div class="radio-group">
          <label><input type="radio" name="role" value="oui" required> <span class="text-success">Oui</span></label>
          <label><input type="radio" name="role" value="non" required> <span class="text-danger">Non</span></label>
        </div>
      </div>

      <div class="form-group">
        <label for="name">Nom</label>
        <input type="text" id="name" name="nom" placeholder="Entrer votre nom" required>
      </div>

      <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" placeholder="Entrer votre prénom" required>
      </div>

      <div class="form-group">
        <label for="contact">Contact</label>
        <input type="number" id="contact" name="contact" placeholder="Entrer votre contact" min="0" step="1" required>
      </div>

      <div class="form-group">
        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" required>
      </div>

      @if ($errors->has('password'))
        <div class="text-error">
          {{ $errors->first('password') }}
        </div>
      @endif

      <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
      </div>

      <div class="form-group">
        <label for="password_confirmation">Confirmer le mot de passe</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
      </div>

      <button type="submit" class="btn">S'inscrire</button>
    </form>

    <div class="footer-text">
      Déjà inscrit ? <a href="/connection">Se connecter</a>
    </div>
  </div>

</body>
</html>
