<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        @page {
            margin: 18mm 14mm;
        }

        body {
            color: #111;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        h1 {
            margin: 0 0 6px;
            font-size: 20px;
        }

        .subtitle,
        .generated-at {
            margin: 0 0 6px;
        }

        .generated-at {
            color: #444;
            font-size: 10px;
        }

        table {
            width: 100%;
            margin-top: 18px;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            border: 1px solid #777;
            text-align: left;
            vertical-align: top;
        }

        th {
            color: #111;
            background: #e8e8e8;
            font-weight: bold;
        }

        tr {
            page-break-inside: avoid;
        }

        .empty {
            color: #444;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>{{ $title }}</h1>
    <p class="subtitle">{{ $subtitle }}</p>
    <p class="generated-at">Generado: {{ $generatedAt }}</p>

    <table>
        <thead>
            <tr>
                @foreach($headers as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
                <tr>
                    @foreach($row as $value)
                        <td>{{ $value }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td class="empty" colspan="{{ count($headers) }}">No hay registros para mostrar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
