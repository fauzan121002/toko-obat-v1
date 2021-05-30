
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
        <thead class="table-bordered">
            <tr>
                <th scope="col">Kode Obat</th>
                <th scope="col">Foto Obat</th>
                <th scope="col">Nama Obat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($obat as $data)
              <tr>
                <td>{{ $data->kode_obat }}</td>
                <td><img src="{{ $data->foto_obat }}" alt="{{ $data->foto_obat }}" width="auto" height="100px" class="img-fluid"></td>
                <td>{{ $data->nama_obat }}</td> 
              </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>