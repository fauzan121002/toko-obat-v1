
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Transaksi Sukses !</title>
	<link rel="stylesheet" href="{{ asset('uikit/css/uikit.min.css') }}">
    <script src="{{ asset('uikit/js/uikit.min.js') }}"></script>
   	<script src="{{ asset('uikit/js/uikit-icons.min.js') }}"></script>
</head>
<body>

<div class="uk-background-secondary uk-background-blend-color-burn uk-light uk-padding uk-panel">
<img src="{{ asset('favicon.ico') }}" alt="N/A">
<div class="uk-text-bold uk-text-danger">SMARTPHARMACY</div> 
<div class="uk-margin-top uk-align-left uk-width-auto uk-text-small">
	Nama Toko : Pharmasia Indonesia
	<br>
	Alamat Toko : Jl.Pharmasia , Kota Bandundbbbbbbbbbbbbbbb<br>bbbbbbbbbbbbbbbbbbbbbbbbbbbg , Jddddddddddddddddddddddddddddddddddddd<br>ddddddddddddddddddddddddddddddddddddddSSSawa Barat. Kode POS 40000 , No 13
	Kec Ciharua		
	<br>
	Kasir : {{ Session::get('kode_kasir') }} - {{ Session::get('nama_kasir') }}
	<br>
	Tanggal Transaksi : {{ $tanggal_transaksi }}
</div>
</div>



<table class="uk-table uk-sortable">
    <caption class="uk-margin-left uk-table-middle uk-text-primary">Informasi Transaksi</caption>
    <thead class="table-bordered">
        <tr>
            <th>Nama Pesanan</th>
            <th>Jumlah Pesanan</th>
            <th>Uang Diterima</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>{{ $nama_pesanan }}</td>
            <td>{{ $jumlah_pesanan }}</td>
            <td>{{ $uang_diterima }}</td>
        </tr>

        <tr>
            <td></td>
            <td>Total Uang Diterima</td>
            <td>{{ $uang_diterima }}</td>
        </tr>      
    </tbody>
</table>

<hr/>

<div class="uk-alert"> Terimakasih Telah Memesan di Pharmasia Indonesia</div>
<div class="uk-text-center uk-width-auto">
<img src="data:image/png;base64,{{DNS1D::getBarcodePNG($kode_transaksi, 'C93')}}" alt="barcode" /><br>
{{ $kode_transaksi }}	
</div>

<script>
	document.title = "";
	window.print();
</script>

<script src="{{ asset('js/jquery.min.js') }}"></script>
@if ($barang === "obat")
    <script>
        setTimeout(window.location.replace("{{ route('drug.index') }}"),100);            
    </script>
@endif

@if ($barang === "suplemen")
    <script>
        setTimeout(window.location.replace("{{ route('supplement.index') }}"),100);        
    </script>
@endif

@if ($barang === "alatkesehatan")
    <script>
        setTimeout(window.location.replace("{{ route('medical-device.index') }}"),100);        
    </script>
@endif

</body>
</html>