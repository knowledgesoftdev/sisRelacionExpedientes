<style>
    * {
        /* Change your font family */
        font-family: sans-serif;
    }

    .content-table {
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        min-width: 400px;
        border-radius: 5px 5px 0 0;
        overflow: hidden;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
        text-align: center;
    }

    .content-table thead tr {
        background-color: #17A2B8;
        color: #ffffff;
        text-align: left;
        font-weight: bold;
    }

    .content-table th,
    .content-table td {
        padding: 12px 15px;
    }

    .content-table tbody tr {
        border-bottom: 1px solid #dddddd;
    }

    .content-table tbody tr:last-of-type {
        border-bottom: 2px solid #009879;
    }

    .content-table tbody tr.active-row {
        font-weight: bold;
        color: #009879;
    }

    .badge {
        padding: 8px;
        border-radius: 5px;
        font-size: 14px;
        color: #fff;
    }

    .bg-success {
        background-color: #28A745;
    }

    .bg-info {
        background-color: #17A2B8;
    }

    .bg-danger {
        background-color: #DC3545;
    }

    .bg-secondary {
        background-color: #6C757D;
    }

    .bg-primary {
        background-color: #007BFF;
    }
</style>

<div>
    <table class="content-table">
        <thead>
            <tr>
                <th style="width: 20%">Número de Casos</th>
                <th style="width: 15%">Fiscal</th>
                <th style="width: 30%">Agraviado</th>
                <th style="width: 30%">Investigado</th>
                <th style="width: 20%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($casos as $caso)
                <tr
                    @if ($caso->status === 'paso juzgado') style="background-color: #CACED1"
                        @elseif ($caso->status === 'pagado')
                        style="background-color: #F5C1C7" @endif>
                    <td style="font-weight: bold">{{ $caso->num_caso }}</td>
                    <td>{{ $caso->fiscal->fiscal_name }}</td>
                    <td>{{ $caso->agraviado }}</td>
                    <td>{{ $caso->investigado }}</td>
                    <td>
                        @if ($caso->status === 'activo')
                            <span class="badge bg-success">{{ strtoupper($caso->status) }}</span>
                        @elseif($caso->status === 'cambio abogado')
                            <span class="badge bg-info">CAM. ABOGADO</span>
                        @elseif($caso->status === 'pagado')
                            <span class="badge bg-danger">CANCELADO</span>
                        @elseif($caso->status === 'paso juzgado')
                            <span class="badge bg-secondary">PAS. JUZGADO</span>
                        @elseif($caso->status === 'concilio')
                            <span class="badge bg-primary">CONCILIÓ</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
