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
                <th style="width: 20%">Número de Expediente</th>
                <th style="width: 20%">Número de Caso</th>
                <th style="width: 15%">Fiscal</th>
                <th style="width: 30%">Agraviado</th>
                <th style="width: 30%">Investigado</th>
                <th style="width: 20%">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expedientes as $expediente)
                <tr
                    @if ($expediente->status === 'sentenciado') style="background-color: #F5C1C7" @endif>
                    <td style="font-weight: bold">{{ $expediente->numExpediente }}</td>
                    <td style="font-weight: bold">{{ $expediente->caso->num_caso}}</td>
                    <td>{{ $expediente->caso->fiscal->fiscal_name }}</td>
                    <td>{{ $expediente->caso->agraviado }}</td>
                    <td>{{ $expediente->caso->investigado }}</td>
                    <td>
                        @if ($expediente->status === 'sentenciado')
                            <span class="badge bg-danger">{{ strtoupper($expediente->status) }}</span>
                        @elseif($expediente>status === 'pagado')
                            {{ strtoupper($expediente->status) }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
