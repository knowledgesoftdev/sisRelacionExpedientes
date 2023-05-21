<?php

namespace App\Http\Livewire;

use App\Models\Casos;
use App\Models\Fiscal;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteCasoComponent extends Component
{
    public $searchSelect;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $fiscales = Fiscal::orderby('fiscal_name', 'asc')->get();
        if ($this->searchSelect === "SELECCIONAR FISCAL") {
            $casos = null;
        } else {
            $casos = Casos::orderby('id', 'desc')->where('fiscal_id', $this->searchSelect)->paginate(10);
        }
        return view('livewire.reporte-caso-component', ["casos" => $casos, 'fiscales' => $fiscales])->layout('livewire.layout.app');
    }
}
