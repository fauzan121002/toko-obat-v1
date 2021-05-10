
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Riwayat Pengiriman')
@endsection

@section('content')

<div class="mb-3">{{ $riwayatpengiriman->links('vendor.pagination.bootstrap-4') }}</div>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Nama Supplier</th>
      <th scope="col">Barang Dikirim</th>
      <th scope="col">Jumlah Barang</th>
      <th scope="col">Tanggal Pengiriman</th>
      <th scope="col">Hapus Riwayat</th>
    </tr>
  </thead>
  <tbody>
  	@foreach ($riwayatpengiriman as $data)
    <tr>
       <td>{{ $data->nama_supplier }}</td>
       <td>{{ $data->barang_dikirim }}</td>
       <td>{{ $data->jumlah_dikirim }}</td>
       <td>{{ $data->created_at }}</td>
       <td>
        <form action="/hapusriwayatpengiriman/{{ $data->id_riwayatpengiriman }}" method="POST">
          @method('DELETE')
          @csrf
          <button type="submit" class="btn btn-outline-danger">Hapus</button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>

<div class="mt-3">{{ $riwayatpengiriman->links('vendor.pagination.bootstrap-4') }}</div>

@endsection

@section('footer')
@parent

@endsection