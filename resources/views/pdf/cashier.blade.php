
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
    <div style="text-align: center;">Laporan Data Kasir</div>
    <div style="text-align: center;">Tanggal : {{ date('d-m-Y h:i') }}</div>
    <hr>

    <table>
        <thead class="table-bordered">
            <tr>
                <th>Kode Kasir</th>
                <th>Foto Kasir</th>
                <th>Nama Kasir</th>
                <th>Jumlah Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kasir as $data)
                <tr>
                    <td>{{ $data->kode_kasir }}</td>
                    <td><img src="{{ $data->foto_kasir }}" width="auto" height="100px" class="img-fluid" alt="{{ $data->foto_kasir }}"></td>
                    <td>{{ $data->nama_kasir }}</td>
                    <td>{{ $data->jumlah_transaksi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>