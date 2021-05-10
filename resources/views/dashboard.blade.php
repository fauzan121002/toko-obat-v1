
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

<div class="row">
		<div class="col-xl-3">
			<div class="card text-white bg-primary ml-auto mr-auto mb-2">
 				<div class="card-header">Total Transaksi</div>
  				<div class="card-body">
   					<h5 class="card-title font-weight-bold">{{ $total_transaksi }}</h5>
  				</div>
			</div>
		</div>
		<div class="col-xl-3">
			<div class="card text-white ml-auto mr-auto bg-warning mb-2">
 				<div class="card-header">Total Pemasukan</div>
  				<div class="card-body">
   					<h5 class="card-title font-weight-bold">Rp.{{ $uang_diterima }},00</h5>
  				</div>
			</div>			
		</div>
		<div class="col-xl-3">
			<div class="card text-white ml-auto mr-auto bg-danger mb-2">
 				<div class="card-header">Jumlah Kasir</div>
  				<div class="card-body">
   					<h5 class="card-title font-weight-bold">{{ $jumlah_kasir }}</h5>
  				</div>
			</div>			
		</div>
		<div class="col-xl-3">
			<div class="card text-white ml-auto mr-auto bg-info mb-2">
 				<div class="card-header">Transaksi Bulan Ini</div>
  				<div class="card-body">
   					<h5 class="card-title font-weight-bold">{{ $transaksi_bulanan }}</h5>
  				</div>
			</div>					
		</div>
	</div>
	<hr/>
	
  <div class="row">
    <div class="col-md-12">

      <div class="card text-white bg-success ml-auto mr-auto mb-2">
        <div class="card-header">Pengumuman</div>
          <div class="card-body">
            <p class="card-title">
            @php
            echo str_replace("\r\n", "<br>", $pengumuman);
            @endphp
            </p>
          </div>
      </div>      
    </div>
  </div>




@endsection

@section('footer')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>

@endsection
