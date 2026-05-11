<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Maison;
use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;





class MaisonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function home()
{
    $maisons = Maison::all(); // ou Maison::with('photos')->get();
    
    return view('welcome', compact('maisons')); // transmet la variable à la vue
}


public function home2()
{
    $maisons = Maison::all(); // ou Maison::with('photos')->get();
    
    return view('Maison', compact('maisons')); // transmet la variable à la vue
}




public function index2($id){
     $maisons = Maison::with(['photos'])->findOrFail($id);
        return view('Maison-info', compact('maisons'));
}



public function indexModifier()


{
    $utilisateur = Auth::user(); // Récupère l'utilisateur connecté


    $maisons = $utilisateur->maisons; // Toutes ses maisons

    return view('/admin.modifier', compact('maisons')); // transmet la variable à la vue

    
}





public function indexModifierR()


{
    $utilisateur = Auth::user(); // Récupère l'utilisateur connecté


    $maisons = $utilisateur->maisons; // Toutes ses maisons

    return view('/admin.pagemodification', compact('maisons')); // transmet la variable à la vue

    
}



public function indexadmininfo($id){
     $maisons = Maison::with(['photos'])->findOrFail($id);
        return view('admin/infomaison', compact('maisons'));
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
            'categorie_id' => 'required|exists:categories,id',
        'titre' => 'required',
        'description' => 'required',
        'prix' => 'required|numeric',
        'adresse' => 'required',
        'image' => 'nullable|image|max:2048',
        'latitude' => 'required|numeric|between:-90,90',
        'longitude' => 'required|numeric|between:-180,180',
        'images_secondaires.*' => 'nullable|image|max:2048'
    ]);

   $utilisateur = Auth::user(); // Récupérer l'utilisateur connecté

    // Enregistrer la maison
    $maison = new Maison();
    $maison->utilisateur_id = $utilisateur->id;
    $maison->categorie_id = $request->categorie_id;
    $maison->titre = $request->titre;
    $maison->description = $request->description;
    $maison->prix = $request->prix;
    $maison->adresse = $request->adresse;


  

    
    //$maison->utilisateur_id = $utilisateur->id;


    if ($request->hasFile('image')) {
        $maison->image = $request->file('image')->store('maisons/principales', 'public');
    }

    $maison->latitude = $request->latitude;
    $maison->longitude = $request->longitude;

    $maison->save();

    // Enregistrer les photos secondaires
    if ($request->hasFile('images_secondaires')) {
        foreach ($request->file('images_secondaires') as $photo) {
            $chemin = $photo->store('maisons/secondaires', 'public');
            $maison->photos()->create(['chemin' => $chemin]);
        }
    }

     $maisons = Maison::all(); // ou Maison::with('photos')->get();
    
    return view('/admin/maisonadmin', compact('maisons')); // transmet la variable à la vue

    
   // return view('admin/Maisonadmin');
}
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    //public function update(Request $request, string $id)
    //{
        //
    //}
public function update(Request $request, $id)
{
    // 1. Trouver la maison
    $maison = Maison::findOrFail($id);

    // 2. Validation
    $request->validate([
        'titre' => 'required',
        'prix' => 'required|numeric',
        'image' => 'nullable|image|max:2048',
        'images_secondaires.*' => 'nullable|image|max:2048'
    ]);

    // 3. Préparer les données de base
    $data = $request->only(['titre', 'description', 'prix', 'adresse', 'latitude', 'longitude']);

    // 4. Gestion de l'image principale (remplacement)
    if ($request->hasFile('image')) {
        // Optionnel : Storage::disk('public')->delete($maison->image); 
        $data['image'] = $request->file('image')->store('maisons/principales', 'public');
    }

    // 5. Mise à jour des champs de la maison
    $maison->update($data);

    // 6. Gestion des photos secondaires (Remplacement total)
    if ($request->hasFile('images_secondaires')) {
        // a. Supprimer les anciennes relations en base de données
        $maison->photos()->delete();

        // b. Ajouter les nouvelles photos
        foreach ($request->file('images_secondaires') as $photo) {
            $chemin = $photo->store('maisons/secondaires', 'public');
            $maison->photos()->create(['chemin' => $chemin]);
        }
    }

    // 7. Redirection avec les données à jour
    $maisons = Maison::all(); 
    return redirect('/admin/modifier');


    //return view('admin.maisonadmin', compact('maisons'))->with('success', 'Mise à jour réussie');


}
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{

    $photo = Photo::findOrFail($id);
    //dd($photo->chemin);


    // Vérifier que le fichier existe avant de tenter la suppression
    if (Storage::disk('public')->exists($photo->chemin)) {
        Storage::disk('public')->delete($photo->chemin);
    }

    // Supprimer l'entrée de la base de données
    $photo->delete();

    // Redirection avec un message de succès
    //return redirect()->route('hhh')->with('success', 'Photo supprimée.');
    return redirect()->back()->with('success', 'Photo supprimée.');
}



    public function recherche(Request $request)
    {
        $search = $request->input('search');

        $maisons = Maison::query()
            ->when($search, function ($query, $search) {
                $query->where('titre', 'like', "%{$search}%")
                    ->orWhere('adresse', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orwhere('prix', 'like', "%{$search}%");
            })
            ->get();

        return view('Maison', compact('maisons'));
    }



        public function rechercheA(Request $request)
    {
        $search = $request->input('search');

        $maisons = Maison::query()
            ->when($search, function ($query, $search) {
                $query->where('titre', 'like', "%{$search}%")
                    ->orWhere('adresse', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orwhere('prix', 'like', "%{$search}%");
            })
            ->get();


        

        return view('admin.Maisonadmin', compact('maisons'));
    }












}
