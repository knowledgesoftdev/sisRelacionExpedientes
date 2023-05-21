<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info mt-4">
                <div class="card-header">
                    <h3 class="card-title">Casos Fiscales -> Juzgado</h3>
                </div>
                <div class="card-body">
                    @if (session()->has('message_canceled'))
                        <div id="info-alert" class="alert alert-info text-center" role="alert">
                            {{ session('message_canceled') }}
                        </div>
                    @elseif(session()->has('message_sentenced'))
                        <div id="danger-alert" class="alert alert-danger text-center" role="alert">
                            {{ session('message_sentenced') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <div class="mb-3">
                            <label for="search" class="form-label">Buscar</label>
                            <input type="text" wire:model='search' class="form-control" type="text"
                                placeholder="Expediente #0000-0000-0000">
                        </div>
                        <div class="d-flex justify-content-end mb-4">
                            <a target="_blank" href="{{ url('download-pdf-expedientes') }}"
                                class="btn btn-danger ml-2">Exportar PDF</a>
                        </div>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 15%">Número de Expediente</th>
                                    <th scope="col" style="width: 15%">Número de Caso</th>
                                    <th scope="col" style="width: 15%">Fiscal</th>
                                    <th scope="col" style="width: 20%">Agraviado</th>
                                    <th scope="col" style="width: 25%">Investigado</th>
                                    <th scope="col" style="width: 10%">Estado</th>
                                    <th scope="col" style="width: 15%">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($expedientes->count() > 0)
                                    @foreach ($expedientes as $expediente)
                                        <tr @if ($expediente->status==="sentenciado")
                                            style="background-color:#F5C1C7"
                                        @endif>
                                            <td>{{ $expediente->numExpediente }}</td>
                                            <td>{{ $expediente->caso->num_caso }}</td>
                                            <td>{{ $expediente->caso->fiscal->fiscal_name }}</td>
                                            <td>{{ $expediente->caso->agraviado }}</td>
                                            <td>{{ $expediente->caso->investigado }}</td>
                                            <td>
                                                @if ($expediente->status === 'activo')
                                                    <span
                                                        class="badge bg-success">{{ strtoupper($expediente->status) }}</span>
                                                @elseif($expediente->status === 'cancelado')
                                                    <span
                                                        class="badge bg-info">{{ strtoupper($expediente->status) }}</span>
                                                @elseif($expediente->status === 'sentenciado')
                                                    <span
                                                        class="badge bg-danger">{{ strtoupper($expediente->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button wire:click="cancelado({{ $expediente->id }})"
                                                    class="btn btn-info btn-sm"><i class="fa-solid fa-c"></i></button>
                                                <button wire:click="sentenciado({{ $expediente->id }})"
                                                    class="btn btn-danger btn-sm"><i class="fa-solid fa-s"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr class="text-center">
                                        <td colspan="6" class="fw-bold">Ningún dato encontrado.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $expedientes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('close-alert', event => {
            function ocultarAlerta(id) {
                var alertElement = document.getElementById(id);
                if (alertElement) {
                    alertElement.style.display = 'none';
                }
            }
            setTimeout(function() {
                ocultarAlerta('info-alert');
                ocultarAlerta('danger-alert');
            }, 3000); // 5000 ms = 5 segundos
        })
    </script>
@endpush
