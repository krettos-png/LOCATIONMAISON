<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\Maison;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * 
     * 
     */

    public function home()
{



    $maisons = Maison::all(); // ou Maison::with('photos')->get();
    
    return view('/admin/maisonadmin', compact('maisons')); // transmet la variable à la vue
}



    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'contact' => 'required',
            'email' => 'required|email|unique:utilisateurs,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:oui,non',
        ]);

        $role = $request->role === 'oui' ? 'admin' : 'client'; // 👈 logique du rôle
    
        // Enregistrer l'utilisateur
        $utilisateur = new Utilisateur();
        $utilisateur->name = $request->nom;
        $utilisateur->prenom = $request->prenom;
        $utilisateur->contact = $request->contact;
        $utilisateur->email = $request->email;
        $utilisateur->password = Hash::make($request->password); // HASH DU MOT DE PASSE
        $utilisateur->role=$role;
        $utilisateur->save();

        return redirect('/login');

    }

    /**
     * Display the specified resource.
     */
    //public function show(string $id)
    //{
        //
    //}


    public function show(string $id)
        {
            $maisons = Maison::with('photos')->findOrFail($id);
            return view('admin.pagemodification', compact('maisons'));
        }




    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $utilisateur = Utilisateur::where('email', $request->email)->first();

        if (!$utilisateur || !Hash::check($request->password, $utilisateur->password)) {
            return back()->withErrors(['email' => 'Identifiants incorrects veuillez reessayer']);
        }

        Auth::login($utilisateur);

        // Redirection selon le rôle
        if ($utilisateur->role === 'admin') {
            return redirect()->route('jj');
        } else {
            return redirect()->route('home2');
            
        }
        return view('login');
    }

    public function showLoginForm()
{
    if (auth()->check()) {
        return redirect('/home');
    }

    return view('auth.login');
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    //public function destroy(string $id)
    //{
        //
    //}



    public function destroy($id)
{
    $maison = Maison::with('photos')->findOrFail($id);

    // Supprimer les fichiers photo du disque
    foreach ($maison->photos as $photo) {
        if (Storage::exists($photo->chemin)) {
            Storage::delete($photo->chemin);
        }
        $photo->delete(); // Supprime la ligne de la BDD
    }

    // Supprimer la maison
    $maison->delete();

    $utilisateur = Auth::user(); // Récupère l'utilisateur connecté

    $maisons = $utilisateur->maisons; // Toutes ses maisons

    return view('admin.modifier', compact('maisons')); // transmet la variable à la vue


}
}
