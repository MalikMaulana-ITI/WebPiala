<?php

namespace App\Livewire;

use App\Models\Trophy;
use App\Models\TrophyMaterial;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogPage extends Component
{
    use WithPagination;


    public $search = '';
    public $selectedMaterials = [];
    public $minPrice;
    public $maxPrice;
    public $selectedColors = [];

    public $allMaterials;
    public $allColors;

    public function mount()
    {

        $this->allMaterials = TrophyMaterial::orderBy('material_name')->get();

        $this->allColors = Trophy::query()
            ->select('color')
            ->whereNotNull('color')
            ->where('color', '!=', '')
            ->distinct()
            ->orderBy('color')
            ->pluck('color');
    }


    public function updatingSelectedMaterials()
    {

        $this->resetPage();
    }

    public function updatingMinPrice()
    {
        $this->resetPage();
    }

    public function updatingMaxPrice()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function applyFilters()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['selectedMaterials', 'minPrice', 'maxPrice', 'search', 'selectedColors']);
        $this->resetPage();
    }

    public function updateSearch($search)
    {
        $this->search = $search;
        $this->resetPage();
    }

    public function toggleColor($color)
    {
    
        if (in_array($color, $this->selectedColors)) {
            $this->selectedColors = array_diff($this->selectedColors, [$color]);
        } else {
            $this->selectedColors[] = $color;
        }
        $this->resetPage();
    }

    public function render()
    {
        $query = Trophy::query()->with('trophyMaterial');


        if (!empty($this->search)) {
            $query->where('name', 'like', '%' . $this->search . '%');
        }

        if (!empty($this->selectedMaterials)) {

            $materials = is_array($this->selectedMaterials) ? $this->selectedMaterials : [$this->selectedMaterials];
            $query->whereIn('material_id', $materials);
        }   

        if (!empty($this->selectedColors)) {
            $query->whereIn('color', $this->selectedColors);
        }

        if (!empty($this->minPrice)) {
            $query->where('price', '>=', $this->minPrice);
        }

        if (!empty($this->maxPrice)) {
            $query->where('price', '<=', $this->maxPrice);
        }


        $trophies = $query->paginate(8);

        return view('livewire.catalog-page', [
            'trophies' => $trophies
        ]);
    }
}
