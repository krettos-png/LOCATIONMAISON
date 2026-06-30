<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VilleController extends Controller
{
    /**
     * Afficher la page de gestion (Liste + Formulaire)
     */
    public function index()
    {
        // Récupère toutes les villes triées par région, puis par nom
        $villes = DB::table('villes')
                    ->orderBy('region', 'asc')
                    ->orderBy('nom', 'asc')
                    ->get();

        return view('admin.villes', compact('villes'));
    }

    /**
     * Enregistrer une nouvelle ville (Action du formulaire en création)
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:villes,nom',
            'region' => 'required|string|max:50',
        ], [
            'nom.unique' => 'Cette ville existe déjà dans la base de données.',
            'nom.required' => 'Le nom de la ville est obligatoire.',
            'region.required' => 'La région est obligatoire.',
        ]);

        try {
            DB::table('villes')->insert([
                'nom' => trim($request->nom),
                'region' => $request->region,
                'created_at' => now(),
            ]);

            return redirect()->back()->with('success', 'La ville a été ajoutée avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'ajout.');
        }
    }

    /**
     * Mettre à jour une ville existante (Action du formulaire en édition via PUT)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:100|unique:villes,nom,' . $id,
            'region' => 'required|string|max:50',
        ], [
            'nom.unique' => 'Ce nom de ville est déjà utilisé par une autre ligne.',
            'nom.required' => 'Le nom de la ville est obligatoire.',
            'region.required' => 'La région est obligatoire.',
        ]);

        try {
            DB::table('villes')->where('id', $id)->update([
                'nom' => trim($request->nom),
                'region' => $request->region,
            ]);

            return redirect()->back()->with('success', 'La ville a été mise à jour avec succès !');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Une erreur est survenue lors de la modification.');
        }
    }

    /**
     * Supprimer une ville de la base de données
     */
    public function destroy($id)
    {
        try {
            DB::table('villes')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'La ville a été supprimée définitivement.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Impossible de supprimer cette ville.');
        }
    }
}