
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Dashboard')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
@endsection

@section('content')
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-fluid">
    <div class="row mt-3">
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card text-white border-danger text-danger ml-auto mr-auto mb-2">
                <div class="card-header">Total Transaksi</div>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">{{ $total_transaksi }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card text-white ml-auto mr-auto border-danger text-danger mb-2">
                <div class="card-header">Total Pemasukan</div>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">Rp.{{ $uang_diterima }},00</h5>
                </div>
            </div>			
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card text-white ml-auto mr-auto border-danger text-danger mb-2">
                <div class="card-header">Jumlah Kasir</div>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">{{ $jumlah_kasir }}</h5>
                </div>
            </div>			
        </div>
        <div class="col-xl-3 col-md-6 col-sm-12">
            <div class="card text-white ml-auto mr-auto border-danger text-danger mb-2">
                <div class="card-header">Transaksi Bulan Ini</div>
                <div class="card-body">
                    <h5 class="card-title font-weight-bold">{{ $transaksi_bulanan }}</h5>
                </div>
            </div>					
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">

            <div class="card text-white bg-success ml-auto mr-auto mb-2">
            <div class="card-header">Pengumuman</div>
                <div class="card-body">
                <p>{{ $pengumuman->updated_at ? "Terakhir diubah : $pengumuman->updated_at" : "" }}</p>
                <p class="card-title">
                @php
                echo str_replace("\r\n", "<br>", $pengumuman->isi_pengumuman);
                @endphp
                </p>
                </div>
            </div>      
        </div>
    </div>
</div>

@endsection