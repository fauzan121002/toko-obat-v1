
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Custom Struk')
@stop

@section('content')
<form action="">
	<div class="form-group">
		<label for="foto_struk">Foto Struk</label>
		<input type="file" name="foto_struk" id="foto_struk" class="form-control h-auto">
	</div>
	<div class="form-group">
		<label for="nama_toko">Nama Toko</label>
		<input type="text" name="nama_toko" class="form-control" id="nama_toko">
			<small class="d-block text-muted">
				Nama Toko Harus kurang dari 30 huruf.
			</small>
	</div>
	<div class="form-group">	
		<div class="input-group">
		<div class="input-group-prepend">
			<div class="input-group-text">Provinsi</div>
		</div>
		<select name="provinsi" class="form-control">
			<option value="" disabled selected>--- select ---</option>
		</select>
		</div>
	</div>
	<div class="form-group">
		<div class="input-group">
		<div class="input-group-prepend">
			<div class="input-group-text">Kota</div>
		</div>
		<select name="kota" class="form-control">
			<option value="" disabled selected>--- select ---</option>
		</select>
		</div>
	</div>
	<div class="form-group">	
		<div class="input-group">
		<div class="input-group-prepend">
			<div class="input-group-text">Kecamatan</div>
		</div>
		<select name="Kecamatan" class="form-control">
			<option value="" disabled selected>--- select ---</option>
		</select>
		</div>
	</div>	
	<div class="form-group">
		<label for="alamat">Alamat Lengkap (Desa/Kampung,Jalan,RT RW,No Rumah)</label>
		<input type="text" name="alamat" id="alamat" class="form-control">
	</div>
</form>
@stop

@section('footer')
@parent

@stop