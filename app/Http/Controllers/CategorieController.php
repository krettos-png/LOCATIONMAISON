<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    // 1. Afficher le formulaire de création
    public function create()
    {
        return view('admin.Categories.AjouCat');
    }

    // 2. Traiter et enregistrer la catégorie en BDD
    public function store(Request $request)
    {
        // Validation des données entrantes
        $request->validate([
            'nom' => 'required|string|max:250|unique:categories,nom',
            'description' => 'nullable|string|max:1000',
        ], [
            'nom.required' => 'Le nom de la catégorie est obligatoire.',
            'nom.unique' => 'Cette catégorie existe déjà.',
        ]);

        // Insertion sécurisée grâce au $fillable du modèle
        Categorie::create([
            'nom' => $request->nom,
            'description' => $request->description,
        ]);

        // Redirection vers le dashboard avec un message de succès
        return redirect('/admin/dev')->with('success', 'La catégorie a été créée avec succès !');
    }

    // 3. Afficher le formulaire de modification
public function edit($id)
{
    $categorie = Categorie::findOrFail($id);
    return view('admin.categories.ModifCat', compact('categorie'));
}

// 4. Mettre à jour la catégorie révisée
public function update(Request $request, $id)
{
    $categorie = Categorie::findOrFail($id);

    $request->validate([
        // Permet de garder le même nom si on ne le modifie pas, mais bloque si un autre a déjà ce nom
        'nom' => 'required|string|max:250|unique:categories,nom,' . $id,
        'description' => 'nullable|string|max:1000',
    ], [
        'nom.required' => 'Le nom de la catégorie est obligatoire.',
        'nom.unique' => 'Ce nom de catégorie est déjà utilisé.',
    ]);

    $categorie->update([
        'nom' => $request->nom,
        'description' => $request->description,
    ]);

    return redirect('/admin/dev')->with('success', 'La catégorie a été modifiée avec succès !');
}

// 5. Supprimer la catégorie
public function destroy($id)
{
    $categorie = Categorie::findOrFail($id);
    
    // Optionnel : Vérifier si la catégorie contient des maisons avant de supprimer
    if ($categorie->maisons()->count() > 0) {
        return redirect('/admin/dev')->with('error', 'Impossible de supprimer cette catégorie car elle contient des maisons.');
    }

    $categorie->delete();

    return redirect('/admin/dev')->with('success', 'La catégorie a été supprimée.');
}




}