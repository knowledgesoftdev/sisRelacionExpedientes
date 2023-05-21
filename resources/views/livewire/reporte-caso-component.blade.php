<div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-info mt-4">
                <div class="card-header">
                    <h3 class="card-title">Casos Fiscales</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div class="mb-3">
                            <label for="search" class="form-label">Buscar</label>
                            <select wire:model='searchSelect' class="form-control">
                                <option value="SELECCIONAR FISCAL" selected>SELECCIONAR FISCAL</option>
                                @foreach ($fiscales as $fiscal)
                                    <option value="{{ $fiscal->id }}">{{ $fiscal->fiscal_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex justify-content-end mb-4">
                            @if ($searchSelect !== null && $searchSelect !== 'SELECCIONAR FISCAL')
                            <a target="_blank" href="{{ url('download-pdf-casosxfiscal/'.$searchSelect) }}" class="btn btn-danger">Exportar
                                PDF</a>
                            @endif
                        </div>
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col" style="width: 15%">Número de Caso</th>
                                    <th scope="col" style="width: 15%">Fiscal</th>
                                    <th scope="col" style="width: 20%">Agraviado</th>
                                    <th scope="col" style="width: 25%">Investigado</th>
                                    <th scope="col" style="width: 10%">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($casos !== null && $casos->count() > 0)
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
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="6" class="fw-bold">Ningún dato encontrado.</td>
                                @endif
                            </tbody>
                        </table>
                        @if ($casos !== null && $casos->count() > 0)
                        <div class="d-flex justify-content-center">
                            {{ $casos->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
