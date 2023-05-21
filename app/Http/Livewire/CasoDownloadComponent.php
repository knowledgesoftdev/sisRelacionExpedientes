<?php

namespace App\Http\Livewire;

use App\Models\Casos;
use Livewire\Component;
use PDF;


class CasoDownloadComponent extends Component
{

    public function exportarPDF(){
        $casos = Casos::orderby('status','asc')->get();
        $pdf = PDF::loadView('livewire.caso-download-component', compact('casos'));
        $pdf->setPaper('a4','landscape');
        $hora=date('h:i:s');
        $anio=date('Y');
        $mesNumero=date('n');
        $valorNuevo=$hora.'_'.$anio.'_'.$mesNumero;
        return $pdf->download($valorNuevo.'.pdf');
    }

    public function render()
    {
        return view('livewire.caso-download-component');
    }
}
