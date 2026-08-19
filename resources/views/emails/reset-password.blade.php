<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Réinitialisation de mot de passe</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2>Bonjour,</h2>
    <p>Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation de mot de passe pour votre compte.</p>
    <p style="margin: 30px 0;">
        <a href="{{ $url }}" style="background-color: #2d3748; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block;">
            Réinitialiser le mot de passe
        </a>
    </p>
    <p>Ce lien de réinitialisation expirera dans 60 minutes.</p>
    <p>Si vous n'avez pas demandé de réinitialisation de mot de passe, aucune autre action n'est requise.</p>
    <p>By G.Tag MaisonLoc</p>
    <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
    <p style="font-size: 12px; color: #777;">Si vous rencontrez des problèmes en cliquant sur le bouton, copiez et collez l'URL ci-dessous dans votre navigateur Web :<br><a href="{{ $url }}">{{ $url }}</a></p>
</body>
</html>