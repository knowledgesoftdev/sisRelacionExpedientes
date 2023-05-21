<?php

namespace App\Http\Livewire;

use App\Models\Juzgado;
use Livewire\Component;
use PDF;

class ReporteExpedienteComponent extends Component
{
    public function exportarPDF(){
        $expedientes = Juzgado::orderby('status','asc')->get();
        $pdf = PDF::loadView('livewire.reporte-expediente-component', compact('expedientes'));
        $pdf->setPaper('a4','landscape');
        $hora=date('h:i:s');
        $anio=date('Y');
        $mesNumero=date('n');
        $valorNuevo=$hora.'_'.$anio.'_'.$mesNumero;
        return $pdf->stream($valorNuevo.'.pdf');
    }

    public function render()
    {
        return view('livewire.reporte-expediente-component');
    }
}
