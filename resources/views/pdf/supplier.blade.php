
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PDF</title>
    <style>
        .custom
        {
            color: #ef5350;
        }

        table
        {
            border-collapse: collapse;
            margin: 0px auto;
            width: 100%;
        }

        table tr th, table tr td
        {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="custom" style="text-align: center;">Smartpharmacy</div>
    <div style="text-align: center;">Laporan Data Obat</div>
    <div style="text-align: center;">Tanggal : {{ date('d-m-Y h:i') }}</div>
    <hr>

    <table>
        <thead>
            <tr>
                <th scope="col">Kode Supplier</th>
                <th scope="col">Nama Supplier</th>
                <th scope="col">Status Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach($supplier as $data)
              <tr class="detail" data-id="{{ $data->id_supplier }}">
                <td>{{ $data->kode_supplier }}</td>
                <td>{{ $data->nama_supplier }}</td>
                <td>{{ $data->status }}</td>
              </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>