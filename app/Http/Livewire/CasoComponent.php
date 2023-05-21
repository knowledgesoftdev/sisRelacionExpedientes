<?php

namespace App\Http\Livewire;

use App\Models\Casos;
use App\Models\Fiscal;
use App\Models\Juzgado;
use Livewire\Component;
use Livewire\WithPagination;

class CasoComponent extends Component
{
    public $search, $numExpediente, $numCasoEdit, $numUno, $numDos, $numTres, $selected_fical, $nameAgraviado, $nameInvestigado, $status, $caso_id;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function updated($campos)
    {
        $this->validateOnly($campos, [
            'numUno' => 'required|min:1',
            'numDos' => 'required|min:1',
            'numTres' => 'required|min:1',
            'selected_fical' => 'required|not_in:SELECCIONAR FISCAL',
            'nameAgraviado' => 'required|string|min:3',
            'nameInvestigado' => 'required|string|min:3',
            'numExpediente' => 'required|string|min:3'
        ]);
    }

    public function resetearCampos()
    {
        $this->numUno = "";
        $this->numDos = "";
        $this->numTres = "";
        $this->nameAgraviado = "";
        $this->nameInvestigado = "";
        $this->caso_id = "";
        $this->selected_fical = "SELECCIONAR FISCAL";
        $this->numExpediente = "";
    }

    public function storeCasoFiscal()
    {
        $this->validate([
            'numUno' => 'required|min:1',
            'numDos' => 'required|min:1',
            'numTres' => 'required|min:1',
            'nameAgraviado' => 'required|string|min:3',
            'nameInvestigado' => 'required|string|min:3',
        ]);

        $casos = new Casos();
        $casosNumCompleto = strtoupper("#" . $this->numUno . '-' . $this->numDos . '-' . $this->numTres);
        $casos->num_caso = $casosNumCompleto;
        $casos->fiscal_id = $this->selected_fical;
        $casos->agraviado = mb_strtoupper($this->nameAgraviado);
        $casos->investigado = mb_strtoupper($this->nameInvestigado);
        $casos->save();

        session()->flash("save", "Caso almacenado, exitosamente");

        $this->resetearCampos();

        $this->dispatchBrowserEvent("close-modal");
        $this->dispatchBrowserEvent("close-alert");
    }

    public function editFiscal($casoEdit_id)
    {
        $casoSearch = Casos::Find($casoEdit_id);
        $this->caso_id = $casoSearch->id;
        $this->nameAgraviado = $casoSearch->agraviado;
        $this->nameInvestigado = $casoSearch->investigado;
        $this->selected_fical = $casoSearch->fiscal_id;
        $this->numCasoEdit = $casoSearch->num_caso;
        $this->dispatchBrowserEvent("open-edit-modal");
    }

    public function editCasoFiscal()
    {
        $this->validate([
            'numCasoEdit' => 'required|string|min:3',
            'nameAgraviado' => 'required|string|min:3',
            'nameInvestigado' => 'required|string|min:3',
        ]);
        $casoSearch = Casos::Find($this->caso_id);
        $casoSearch->num_caso = $this->numCasoEdit;
        $casoSearch->agraviado = mb_strtoupper($this->nameAgraviado);
        $casoSearch->investigado = mb_strtoupper($this->nameInvestigado);
        $casoSearch->fiscal_id = $this->selected_fical;
        $casoSearch->save();
        session()->flash("update", "Caso actualizado, exitosamente");
        $this->resetearCampos();
        $this->dispatchBrowserEvent("close-modal");
        $this->dispatchBrowserEvent("close-alert");
    }

    public function ediCambioAbogadoFiscal($caso_id)
    {
        $casoSearch = Casos::Find($caso_id);
        $casoSearch->status = "cambio abogado";
        $casoSearch->save();
        session()->flash("updateAbogado", "Caso, cambio de abogado");
        $this->resetearCampos();
        $this->dispatchBrowserEvent("close-alert");
    }

    public function editPagoFiscal($caso_id)
    {
        $casoSearch = Casos::Find($caso_id);
        $casoSearch->status = "pagado";
        $casoSearch->save();
        session()->flash("updatePago", "El caso a sido pagado, correctamente.");
        $this->resetearCampos();
        $this->dispatchBrowserEvent("close-alert");
    }

    public function pasoJuzgado($caso_id)
    {
        $casoSearch = Casos::Find($caso_id);
        $this->caso_id = $casoSearch->id;

        $this->dispatchBrowserEvent("open-juzagdo-modal");
    }

    public function concilio($caso_id)
    {
        $casoSearch = Casos::Find($caso_id);
        $casoSearch->status = "concilio";
        $casoSearch->save();
        session()->flash("conciliaron", "Han conciliado.");
        $this->resetearCampos();
        $this->dispatchBrowserEvent("close-alert");
    }

    public function saveCasoJuzgado()
    {
        $this->validate([
            'numExpediente' => 'required|string|min:3'
        ]);
        $casoSearch = Casos::Find($this->caso_id);
        $casoSearch->status = "paso juzgado";
        $casoSearch->save();

        $juzgado = new Juzgado();
        $juzgado->numExpediente = "#" . $this->numExpediente;
        $juzgado->caso_id = $casoSearch->id;
        $juzgado->save();
        session()->flash("pasoJuzgado", "El caso a pasado a juzgado.");
        $this->resetearCampos();
        $this->dispatchBrowserEvent("close-modal");
        $this->dispatchBrowserEvent("close-alert");
    }

    public function delete($caso_id){
        $casoSearch = Casos::Find($caso_id);
        $casoSearch->delete();
        session()->flash("delete", "El caso a sido eliminado.");
        $this->resetearCampos();
        $this->dispatchBrowserEvent("close-alert");
    }

    protected $listeners = ['resetearCampos' => 'resetearCampos'];

    public function render()
    {
        $title = "Casos";
        $fiscales = Fiscal::all();

        if (empty($this->search)) {
            $casos = Casos::orderby('id','desc')->paginate(10);
        } else {
            $casos = Casos::where('num_caso', 'like', '%' . $this->search . '%')->paginate(10);
        }
        return view('livewire.caso-component', ["title" => $title, "fiscales" => $fiscales, "casos" => $casos])->layout('livewire.layout.app');
    }
}
