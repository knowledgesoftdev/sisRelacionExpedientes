<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info mt-4">
                <div class="card-header">
                    <h3 class="card-title">Fiscales</h3>
                </div>
                <div class="card-body">
                    @if (session()->has('message'))
                        <div id="success-alert" class="alert alert-success text-center" role="alert">
                            {{ session('message') }}
                        </div>
                    @elseif(session()->has('message_edit'))
                        <div id="warning-alert" class="alert alert-warning text-center" role="alert">
                            {{ session('message_edit') }}
                        </div>
                    @elseif(session()->has('message_suspend'))
                        <div id="info-alert" class="alert alert-info text-center" role="alert">
                            {{ session('message_suspend') }}
                        </div>
                    @elseif(session()->has('message_delete'))
                        <div id="danger-alert" class="alert alert-danger text-center" role="alert">
                            {{ session('message_delete') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <div class="d-flex justify-content-end mb-4">
                            <button class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#addFiscal">Agregar</button>
                        </div>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Datos Fiscal</th>
                                    <th scope="col">Especialidad</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($fiscals->count() > 0)
                                    @foreach ($fiscals as $fiscal)
                                        <tr>
                                            <td>{{ $fiscal->fiscal_name }}</td>
                                            <td>{{ $fiscal->especialidades }}</td>
                                            <td>
                                                @if ($fiscal->status === 'activo')
                                                    <span
                                                        class="badge text-bg-success badge-sm">{{ strtoupper($fiscal->status) }}</span>
                                                @elseif($fiscal->status === 'suspendido')
                                                    <span
                                                        class="badge text-bg-info">{{ strtoupper($fiscal->status) }}</span>
                                                @else
                                                    <span
                                                        class="badge text-bg-danger">{{ strtoupper($fiscal->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click="editFiscal({{ $fiscal->id }})"
                                                    class="btn btn-warning btn-sm" data-bs-toggle="modal"
                                                    data-bs-target="#editFiscal"><i class="fa-solid fa-e"></i></button>
                                                <button wire:click="suspFiscal({{ $fiscal->id }})"
                                                    class="btn btn-info btn-sm"><i class="fa-solid fa-s"></i></button>
                                                <button wire:click='delete({{ $fiscal->id }})'
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-b"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="4" class="fw-bold">Ningún(a) fiscal encontrada</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Editar-->
    <div wire:ignore.self class="modal fade" id="editFiscal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
                    <button wire:click='resetearCampos' type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='editFiscalData'>
                        <div class="mb-3">
                            <label for="nameFiscal" class="form-label">Editar datos del Fiscal</label>
                            <input wire:model='nameFiscal' class="form-control" type="text" id="nameFiscal"
                                placeholder="Ejm: Nombres y Apellidos">
                            @error('nameFiscal')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nameEspecialidad" class="form-label">Especialidad</label>
                            <input wire:model='nameEspecialidad' class="form-control" type="text"
                                id="nameEspecialidad" placeholder="Ejm: Fiscales Supremos">
                            @error('nameEspecialidad')
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
    <div wire:ignore.self class="modal fade" id="addFiscal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $title }}</h1>
                    <button wire:click='resetearCampos' type="button" class="btn-close" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit.prevent='storeFiscal'>
                        <div class="mb-3">
                            <label for="nameFiscal" class="form-label">Datos del Fiscal</label>
                            <input wire:model='nameFiscal' class="form-control" type="text" id="nameFiscal"
                                placeholder="Ejm: Nombres y Apellidos">
                            @error('nameFiscal')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nameEspecialidad" class="form-label">Especialidad</label>
                            <input wire:model='nameEspecialidad' class="form-control" type="text"
                                id="nameEspecialidad" placeholder="Ejm: Fiscales Supremos">
                            @error('nameEspecialidad')
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
            $('#addFiscal').modal('hide');
            $('#editFiscal').modal('hide');
        });

        window.addEventListener('open-edit-modal', event => {
            $('#editFiscal').modal('show');
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
            }, 3000); // 5000 ms = 5 segundos
        })

        window.addEventListener("keydown", e => {
            if (e.key === "Escape") {
                Livewire.emit('resetearCampos');
            }

            if (e.altKey && String.fromCharCode(e.keyCode) == 'Z') {
                $('#addFiscal').modal('show');
            }
        })

        $("#addFiscal").on('shown.bs.modal', function() {
            $("#nameFiscal").focus();
        });

        $('#editFiscal').on('hidden.bs.modal', function() {
            Livewire.emit("resetearCampos");
        });
    </script>
@endpush
