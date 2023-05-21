<?php

namespace App\Http\Livewire;

use App\Models\Fiscal;
use Illuminate\Http\Request;
use Livewire\Component;

class FiscalComponent extends Component
{
    public $nameFiscal, $nameEspecialidad, $fiscal_id;

    public function updated($campos)
    {

        $this->validateOnly($campos, [
            'nameFiscal' => 'required|min:10',
            'nameEspecialidad' => 'required|min:10'
        ]);
    }

    public function resetearCampos()
    {
        $this->nameFiscal = "";
        $this->nameEspecialidad = "";
        $this->fiscal_id = "";
    }

    public function storeFiscal()
    {

        $this->validate([
            'nameFiscal' => 'required|min:10',
            'nameEspecialidad' => 'required|min:10'
        ]);

        $fiscal = new Fiscal();
        $fiscal->fiscal_name = mb_strtoupper($this->nameFiscal);
        $fiscal->especialidades = mb_strtoupper($this->nameEspecialidad);
        $fiscal->save();

        session()->flash("message", "Datos del fiscal almacenados, correctamente.");

        $this->resetearCampos();

        $this->dispatchBrowserEvent('close-modal');
    }

    public function editFiscal($fiscal_id)
    {
        $fiscal = Fiscal::find($fiscal_id);
        $this->fiscal_id = $fiscal->id;
        $this->nameFiscal = $fiscal->fiscal_name;
        $this->nameEspecialidad = $fiscal->especialidades;
        $this->dispatchBrowserEvent('open-edit-modal');
        $this->dispatchBrowserEvent('close-alert');
    }

    public function editFiscalData()
    {
        $this->validate([
            'nameFiscal' => 'required|min:10',
            'nameEspecialidad' => 'required|min:10',
        ]);
        $fiscal = Fiscal::find($this->fiscal_id);
        $fiscal->fiscal_name = mb_strtoupper($this->nameFiscal);
        $fiscal->especialidades = mb_strtoupper($this->nameEspecialidad);
        $fiscal->save();
        session()->flash("message_edit", "Datos del fiscal editados, correctamente.");
        $this->resetearCampos();
        $this->dispatchBrowserEvent('close-modal');
        $this->dispatchBrowserEvent('close-alert');
    }

    public function suspFiscal($fiscal_id)
    {
        $fiscal = Fiscal::find($fiscal_id);
        $fiscal->status = 'suspendido';
        $fiscal->save();
        session()->flash("message_suspend", "Fiscal suspendido, correctamente.");
        $this->resetearCampos();
        $this->dispatchBrowserEvent('close-alert');
    }

    public function delete($fiscal_id)
    {
        $fiscal = Fiscal::find($fiscal_id);
        $fiscal->status = 'baja';
        $fiscal->save();
        session()->flash("message_delete", "Fiscal dado(a) de baja, correctamente.");
        $this->resetearCampos();
        $this->dispatchBrowserEvent('close-alert');
    }

    protected $listeners = ['resetearCampos' => 'resetearCampos'];

    public function render()
    {
        $title = "Fiscal";
        $fiscals = Fiscal::all();
        return view('livewire.fiscal-component', ['title' => $title, "fiscals" => $fiscals])->layout('livewire.layout.app');
    }
}
