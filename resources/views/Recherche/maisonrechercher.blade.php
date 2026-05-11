
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   
{{-- resources/views/houses/index.blade.php --}}

<form action="" method="GET" class="mb-4 p-4 bg-light rounded shadow-sm">
    <div class="row g-3">
        
        {{-- Critère 1: Nombre de Chambres --}}
        <div class="col-md-4">
            <label for="bedrooms" class="form-label">Min. Chambres</label>
            <input type="number" 
                   class="form-control" 
                   id="bedrooms" 
                   name="bedrooms" 
                   min="1" 
                   value="{{ request('bedrooms') }}">
        </div>

        {{-- Critère 2: Nombre de Salons --}}
        <div class="col-md-4">
            <label for="living_rooms" class="form-label">Min. Salons</label>
            <input type="number" 
                   class="form-control" 
                   id="living_rooms" 
                   name="living_rooms" 
                   min="0" 
                   value="{{ request('living_rooms') }}">
        </div>

        {{-- Critère 3: Zone (Recherche par texte dans l'adresse/ville) --}}
        <div class="col-md-4">
            <label for="zone" class="form-label">Zone / Ville</label>
            <input type="text" 
                   class="form-control" 
                   id="zone" 
                   name="zone" 
                   placeholder="Ex: Paris, Montagne, Centre-ville"
                   value="{{ request('zone') }}">
        </div>
        
    </div>

    <div class="mt-3">
        <button type="submit" class="btn btn-primary w-100">
            Rechercher 
        </button>
        {{-- Bouton pour effacer les filtres si des critères sont appliqués --}}
        @if(request()->hasAny(['bedrooms', 'living_rooms', 'zone']))
            <a href="{{ route('houses.index') }}" class="btn btn-outline-secondary mt-2 w-100">
                Réinitialiser les filtres
            </a>
        @endif
    </div>
</form>

{{-- Ici, vous afficherez les résultats des maisons --}}