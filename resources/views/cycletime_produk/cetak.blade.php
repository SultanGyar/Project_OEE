<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Kode QR</title>
    <style>
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <header class="text-center">
        <h2>Kode QR</h2>
    </header>
    <table width="100%" >
        @php $count = 0; @endphp
        @foreach ($dataproduk as $data)
            @if ($count % 4 == 0)
                @if ($count > 0)
                    </tr>
                @endif
                <tr>
            @endif
            <td class="text-center" style="border: 1px solid #333; padding: 10px;">
                @if ($data)
                    <div>{{ $data->daftarproses }}</div>
                    <br>
                    <img src="data:image/svg+xml;base64,{{ base64_encode($data->qr) }}" alt="{{ $data->qr }}" width="100" height="100">
                    <br>
                    {{ $data->kode }}
                @else
                    <!-- Handle the case where $data is null (optional) -->
                    <p>Data not found</p>
                @endif
            </td>
            @php $count++; @endphp
        @endforeach
        @if ($count > 0)
            </tr>
        @endif
    </table>
</body>

</html>