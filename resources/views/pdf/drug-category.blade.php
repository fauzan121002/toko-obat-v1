
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
    <div style="text-align: center;">Laporan Data Kategori Obat</div>
    <div style="text-align: center;">Tanggal : {{ date('d-m-Y h:i') }}</div>
    <hr>

    <table>
        <thead class="table-bordered">
            <tr>    
                <th scope="col">Kode Kategori Obat</th>
                <th scope="col">Nama Kategori Obat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategori as $data)
              <tr>
                <td>{{ $data->kode_kategoriobat }}</td>
                <td>{{ $data->nama_kategoriobat }}</td>
              </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>