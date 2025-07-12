<?php

namespace App\Livewire;

use App\Models\Trophy;
use App\Models\TrophyMaterial;
use Livewire\Component;
use Illuminate\Support\Collection;

class ProductCard extends Component
{
    public Trophy $trophy;

    public $selectedMaterialId;

    public Collection $allMaterials;

    public function mount(Trophy $trophy, Collection $allMaterials)
    {
        $this->trophy = $trophy;
        $this->allMaterials = $allMaterials;

        if ($this->trophy->material_id) {
            $this->selectedMaterialId = $this->trophy->material_id;
        } elseif ($allMaterials->isNotEmpty()) {
            $this->selectedMaterialId = $allMaterials->first()->id;
        }
    }

    public function getCalculatedPriceProperty()
    {
        $basePrice = $this->trophy->price;
        $materialPrice = 0;

        $selectedMaterial = $this->allMaterials->firstWhere('id', $this->selectedMaterialId);

        if ($selectedMaterial) {
            $materialPrice = $selectedMaterial->price;
        }


        return $basePrice + $materialPrice;
    }

    public function buyNow()
    {

        $selectedMaterial = $this->allMaterials->firstWhere('id', $this->selectedMaterialId);

        $selectedMaterialName = $selectedMaterial ? $selectedMaterial->material_name : 'Tidak Diketahui';
        session([
            'selected_product' => [
                'id' => $this->trophy->id,
                'name' => $this->trophy->name,
                'image' => $this->trophy->image,
                'base_price' => $this->trophy->price,
                'selected_material_id' => $this->selectedMaterialId,
                'selected_material_name' => $selectedMaterial ? $selectedMaterial->material_name : 'Default',
                'selected_material_price' => $selectedMaterial ? $selectedMaterial->price : 0,
                'final_price' => $this->calculatedPrice,
                'text' => $this->trophy->text,
                'color' => $this->trophy->color,
                'isCustomize' => false,
            ]
        ]);

        return redirect()->route('product-overview');
    }

    public function render()
    {
        return view('livewire.product-card');
    }
}
