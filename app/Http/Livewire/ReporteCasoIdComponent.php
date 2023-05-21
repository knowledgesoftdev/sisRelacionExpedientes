<?php

namespace App\Http\Livewire;

use App\Models\Casos;
use Livewire\Component;

use PDF;

class ReporteCasoIdComponent extends Component
{
    public function exportarPDFxFiscal($id){
        $fiscal=Casos::where('fiscal_id',$id)->orderby('status','asc')->get();
        $pdf = PDF::loadView('livewire.reporte-caso-id-component', compact('fiscal'));
        $pdf->setPaper('a4','landscape');
        $hora=date('h:i:s');
        $anio=date('Y');
        $mesNumero=date('n');
        $valorNuevo=$hora.'_'.$anio.'_'.$mesNumero;
        return $pdf->download($valorNuevo.'.pdf');
    }
    public function render()
    {
        return view('livewire.reporte-caso-id-component');
    }
}
