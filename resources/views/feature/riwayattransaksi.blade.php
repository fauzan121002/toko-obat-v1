
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Jenis Obat')
@endsection

@section('content')
  {{ $transaksi->links() }}

  <div class="table-responsive">
    <table class="table table-light table-striped">
      <thead>
        <tr>
          <th>Kode Transaksi</th>
          <th>Pesanan</th>
          <th>Jumlah Pesanan</th>
          <th>Uang Diterima</th>
          <th>Kasir</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th>Kode Transaksi</th>
          <th>Pesanan</th>
          <th>Jumlah Pesanan</th>
          <th>Uang Diterima</th>
          <th>Kasir</th>
        </tr>
      </tfoot>
      <tbody>
        @foreach ($transaksi as $data)
        <tr>
          <td>{{ $data->kode_transaksi }}</td>
          <td>{{ $data->nama_pesanan }}</td>
          <td>{{ $data->jumlah_pesanan }}</td>
          <td>{{ $data->uang_diterima }}</td>
          <td>{{ $data->nama_kasir }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $transaksi->links() }}
@endsection

@section('footer')
@parent

@endsection