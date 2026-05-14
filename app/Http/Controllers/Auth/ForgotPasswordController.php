<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

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
        $request->validate(['email' => 'required|email|exists:utilisateurs,email']);

        // 1. Créer un token unique
        $token = Str::random(64);

        // 2. Stocker dans la table password_reset_tokens
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => $token, // Idéalement haché avec Hash::make()
                'created_at' => Carbon::now()
            ]
        );

        // 3. Envoyer l'email (Tu devras créer une "Mailable" plus tard pour le design)
        // Pour l'instant, on simule ou on utilise une fonction simple
        // Mail::to($request->email)->send(new ResetPasswordMail($token));

        return back()->with('status', 'Nous avons envoyé votre lien de réinitialisation par e-mail !');
    }
}