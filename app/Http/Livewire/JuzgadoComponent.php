<?php

namespace App\Http\Livewire;

use App\Models\Casos;
use App\Models\Juzgado;
use Livewire\Component;
use Livewire\WithPagination;

class JuzgadoComponent extends Component
{
    public $search;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function cancelado($juzgado_id)
    {
        $juzgado = Juzgado::find($juzgado_id);
        $juzgado->status = 'cancelado';
        $juzgado->save();
        session()->flash("message_canceled", "El expediente a sido cancelado, correctamente.");
        $this->dispatchBrowserEvent('close-alert');
    }

    public function sentenciado($juzgado_id)
    {
        $juzgado = Juzgado::find($juzgado_id);
        $juzgado->status = 'sentenciado';
        $juzgado->save();
        session()->flash("message_sentenced", "La persona a sido sentenciado.");
        $this->dispatchBrowserEvent('close-alert');
    }

    public function render()
    {
        if($this->search==""){
            $expedientes = Juzgado::orderby('status','asc')->paginate(10);
        }else{
            $expedientes = Juzgado::where('numExpediente', 'like', '%'.$this->search.'%')->paginate(10);
        }
        return view('livewire.juzgado-component', ['expedientes' => $expedientes])->layout('livewire.layout.app');
    }
}
