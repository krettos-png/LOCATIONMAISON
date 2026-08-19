<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class ForgotPasswordController extends Controller
{
    // Affiche la page où on entre l'email
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    // Envoie le lien par mail
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(
            ['email' => 'required|email|exists:utilisateurs,email'],
            [
                'email.required' => 'Veuillez saisir votre adresse e-mail.',
                'email.email' => 'Veuillez saisir une adresse e-mail valide.',
                'email.exists' => 'Aucun compte n\'est associé à cet e-mail.'
            ]
        );

        // 1. Créer un token clair pour le lien et une version hachée pour la BDD
        $rawToken = Str::random(64);

        // 2. Stocker le token haché dans la table password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => Hash::make($rawToken),
                'created_at' => Carbon::now()
            ]
        );

        // 3. Envoyer l'e-mail avec le token brut dans le lien
        Mail::to($request->email)->send(new ResetPasswordMail($rawToken, $request->email));

        return back()->with('status', 'Nous avons envoyé votre lien de réinitialisation par e-mail !');
    }



    // 1. Affiche le formulaire où l'utilisateur saisit son nouveau mot de passe
public function showResetForm(Request $request, $token = null)
{
    return view('auth.reset-password')->with([
        'token' => $token,
        'email' => $request->email
    ]);
}

// 2. Traite la modification effective du mot de passe
public function reset(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email|exists:utilisateurs,email',
        'password' => 'required|min:8|confirmed',
    ], [
        'password.required' => 'Le nouveau mot de passe est obligatoire.',
        'password.min' => 'Le mot de passe doit faire au moins 8 caractères.',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
    ]);

    // Vérification du token en BDD
    $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

    if (!$record || !Hash::check($request->token, $record->token)) {
        return back()->withErrors(['email' => 'Ce jeton de réinitialisation est invalide ou a expiré.']);
    }

    // Mise à jour du mot de passe dans la table utilisateurs
    DB::table('utilisateurs')
        ->where('email', $request->email)
        ->update(['password' => Hash::make($request->password)]);

    // Suppression du token utilisé
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    return redirect()->route('login')->with('status', 'Votre mot de passe a été réinitialisé avec succès !');
}
}