<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info mt-4">
                <div class="card-header">
                    <h3 class="card-title">Casos Fiscales</h3>
                </div>
                <div class="card-body">
                    @if (session()->has('save'))
                        <div id="success-alert" class="alert alert-success text-center" role="alert">
                            {{ session('save') }}
                        </div>
                    @elseif(session()->has('update'))
                        <div id="warning-alert" class="alert alert-warning text-center" role="alert">
                            {{ session('update') }}
                        </div>
                    @elseif(session()->has('updateAbogado'))
                        <div id="info-alert" class="alert alert-info text-center" role="alert">
                            {{ session('updateAbogado') }}
                        </div>
                    @elseif(session()->has('updatePago'))
                        <div id="danger-alert" class="alert alert-danger text-center" role="alert">
                            {{ session('updatePago') }}
                        </div>
                    @elseif(session()->has('pasoJuzgado'))
                        <div id="secondary-alert" class="alert alert-secondary text-center" role="alert">
                            {{ session('pasoJuzgado') }}
                        </div>
                    @elseif(session()->has('conciliaron'))
                        <div id="primary-alert" class="alert alert-primary text-center" role="alert">
                            {{ session('conciliaron') }}
                        </div>
                    @elseif(session()->has('delete'))
                        <div id="danger-alert" class="alert alert-danger text-center" role="alert">
                            {{ session('delete') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <div class="mb-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" wire:model='search' class="form-control" type="text"
                                placeholder="Caso #0000-0000-0000">
                        </div>
                        <div class="d-flex justify-content-end mb-4">
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addCasosFiscal">Agregar</button>

                            <a target="_blank" href="{{ url('download-pdf-casos') }}"
                                class="btn btn-danger ml-2">Exportar PDF</a>
                        </div>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 15%">Número de Caso</th>
                                    <th scope="col" style="width: 15%">Fiscal</th>
                                    <th scope="col" style="width: 20%">Agraviado</th>
                                    <th scope="col" style="width: 25%">Investigado</th>
                                    <th scope="col" style="width: 10%">Estado</th>
                                    <th scope="col" style="width: 15%">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($casos->count() > 0)
                                    @foreach ($casos as $caso)
                                        <tr @if ($caso->status === 'paso juzgado') style="background-color:#A8ADB1" @endif>
                                            <td>{{ $caso->num_caso }}</td>
                                            <td>{{ $caso->fiscal->fiscal_name }}</td>
                                            <td>{{ $caso->agraviado }}</td>
                                            <td>{{ $caso->investigado }}</td>
                                            <td>
                                                @if ($caso->status === 'activo')
                                                    <span
                                                        class="badge bg-success">{{ strtoupper($caso->status) }}</span>
                                                @elseif($caso->status === 'cambio abogado')
                                                    <span class="badge bg-info">CAM. ABOGADO</span>
                                                @elseif($caso->status === 'pagado')
                                                    <span class="badge bg-danger">CANCELADO</span>
                                                @elseif($caso->status === 'paso juzgado')
                                                    <span class="badge bg-secondary">PAS. JUZGADO</span>
                                                @elseif($caso->status === 'concilio')
                                                    <span
                                                        class="badge bg-primary">{{ strtoupper($caso->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click="editFiscal({{ $caso->id }})"
                                                    class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editCasoFiscal"><i
                                                        class="fa-solid fa-e"></i></button>

                                                <button wire:click="ediCambioAbogadoFiscal({{ $caso->id }})"
                                                    class="btn btn-info btn-sm"><i class="fa-solid fa-c"></i></button>

                                                <button wire:click="editPagoFiscal({{ $caso->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-p"></i></button>

                                                <button wire:click="pasoJuzgado({{ $caso->id }})"
                                                    class="btn btn-secondary btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#pasoJuzgado"><i class="fa-solid fa-j"></i></button>

                                                <button wire:click="concilio({{ $caso->id }})"
                                                    class="btn btn-primary btn-sm"><i
                                                        class="fa-sharp fa-solid fa-user"></i></button>

                                                <button wire:click="delete({{ $caso->id }})"
                                                    class="btn btn-danger btn-sm"><i
                                                        class="fa-sharp fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="6" class="fw-bold">Ningún dato encontrado.</td>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $casos->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Paso juzgado-->
    <div wire:ignore.self class="modal fade" id="pasoJuzgado" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
                    <button wire:click='resetearCampos' type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='saveCasoJuzgado'>
                        <div class="mb-3">
                            <label for="numExpediente" class="form-label">Número de Expediente</label>
                            <input type="text" wire:model='numExpediente' class="form-control" type="text"
                                placeholder="Ejm: 0000-0000-0000">
                            @error('numExpediente')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Editar-->
    <div wire:ignore.self class="modal fade" id="editCasoFiscal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
                    <button wire:click='resetearCampos' type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='editCasoFiscal'>
                        <div class="mb-3">
                            <label for="numCasoEdit" class="form-label">Número de Caso</label>
                            <input type="text" wire:model='numCasoEdit' class="form-control" type="text">
                            @error('numCasoEdit')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select wire:model='selected_fical' class="form-select"
                                aria-label="Default select example">
                                <option value="SELECCIONAR FISCAL" selected>SELECCIONAR FISCAL</option>
                                @foreach ($fiscales as $fiscal)
                                    <option value="{{ $fiscal->id }}">{{ $fiscal->fiscal_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nameAgraviado" class="form-label">Agraviado</label>
                            <input wire:model='nameAgraviado' class="form-control" id="nameAgraviado"
                                placeholder="Ejm: Fulanito" />
                            @error('nameAgraviado')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nameInvestigado" class="form-label">Investigado</label>
                            <input type="text" wire:model='nameInvestigado' class="form-control"
                                id="nameInvestigado" placeholder="Ejm: Fulanito" />
                            @error('nameInvestigado')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Editar</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Agregar-->
    <div wire:ignore.self class="modal fade" id="addCasosFiscal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
                    <button wire:click='resetearCampos' type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='storeCasoFiscal'>
                        <div class="mb-3">
                            <label for="nameFiscal" class="form-label">Número de Caso</label>
                            <div class="row">
                                <div class="col-4">
                                    <input wire:model='numUno' class="form-control" type="text" id="numUno"
                                        placeholder="Ejm: 0000">
                                </div>
                                <div class="col-4">
                                    <input wire:model='numDos' class="form-control" type="text" id="numDos"
                                        placeholder="Ejm: 0000">
                                </div>
                                <div class="col-4">
                                    <input wire:model='numTres' class="form-control" type="text" id="numTres"
                                        placeholder="Ejm: 0000">
                                </div>
                            </div>
                            @error('numUno')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('numDos')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                            @error('numTres')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <select wire:model='selected_fical' class="form-select"
                                aria-label="Default select example">
                                <option value="SELECCIONAR FISCAL" selected>SELECCIONAR FISCAL</option>
                                @foreach ($fiscales as $fiscal)
                                    <option value="{{ $fiscal->id }}">{{ $fiscal->fiscal_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nameAgraviado" class="form-label">Agraviado</label>
                            <input type="text" wire:model='nameAgraviado' class="form-control" id="nameAgraviado"
                                placeholder="Ejm: Fulanito" />
                            @error('nameAgraviado')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nameInvestigado" class="form-label">Investigado</label>
                            <input wire:model='nameInvestigado' class="form-control" id="nameInvestigado"
                                placeholder="Ejm: Fulanito" />
                            @error('nameInvestigado')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-modal', event => {
            $('#addCasosFiscal').modal('hide');
            $('#editCasoFiscal').modal('hide');
            $('#pasoJuzgado').modal('hide');
        });

        window.addEventListener('open-juzagdo-modal', event => {
            $('#pasoJuzgado').modal('show');
        });

        window.addEventListener('open-edit-modal', event => {
            $('#editCasoFiscal').modal('show');
        });

        window.addEventListener('close-alert', event => {
            function ocultarAlerta(id) {
                var alertElement = document.getElementById(id);
                if (alertElement) {
                    alertElement.style.display = 'none';
                }
            }
            setTimeout(function() {
                ocultarAlerta('success-alert');
                ocultarAlerta('warning-alert');
                ocultarAlerta('info-alert');
                ocultarAlerta('danger-alert');
                ocultarAlerta('secondary-alert');
                ocultarAlerta('primary-alert');
            }, 3000); // 5000 ms = 5 segundos
        })

        window.addEventListener("keydown", e => {
            if (e.key === "Escape") {
                Livewire.emit('resetearCampos');
            }

            if (e.altKey && String.fromCharCode(e.keyCode) == 'Z') {
                $('#addCasosFiscal').modal('show');
            }
        })

        $("#addCasosFiscal").on('shown.bs.modal', function() {
            $("#numUno").focus();
        });

        $('#editCasoFiscal').on('hidden.bs.modal', function() {
            Livewire.emit("resetearCampos");
        });

        $('#pasoJuzgado').on('hidden.bs.modal', function() {
            Livewire.emit("resetearCampos");
        });
    </script>
@endpush
