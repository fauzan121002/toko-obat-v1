
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
    <div style="text-align: center;">Laporan Data Alat Kesehatan</div>
    <div style="text-align: center;">Tanggal : {{ date('d-m-Y h:i') }}</div>
    <hr>

    <table>
        <thead>
            <tr>
                <th scope="col">Kode Alat Kesehatan</th>
                <th scope="col">Foto Alat Kesehatan</th>
                <th scope="col">Nama Alat Kesehatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($alatkesehatan as $data)
              <tr>
                <td>{{ $data->kode_alatkesehatan }}</td>
                <td><img src="{{ $data->foto_alatkesehatan }}" alt="{{ $data->foto_alatkesehatan }}" width="auto" height="100px" class="img-fluid"></td>
                <td>{{ $data->nama_alatkesehatan }}</td> 
              </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>