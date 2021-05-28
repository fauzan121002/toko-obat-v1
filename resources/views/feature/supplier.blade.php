
@extends('layouts.main-app')

@section('header')
@parent
@section('judul','Supplier')
@endsection

@section('content')

<div class="loadingmodal"></div>
 <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
     <a class="btn btn-outline-light ml-auto mr-1" href="{{ route('report.supplier') }}" target="_blank"><i class="fas fa-print text-white"></i></a>
     <li class="breadcrumb-item active" aria-current="page"><button class="btn btn-outline-light" data-toggle="modal" data-target="#exampleModal">+</button></form>
    </ol>
  </nav>


<div class="mb-3">{{ $supplier->links('vendor.pagination.bootstrap-4') }}</div>
  <div class="table-responsive">
<table class="table table-hover">
  <thead class="table-bordered">
      <tr>
        <th scope="col">Kode Supplier</th>
        <th scope="col">Nama Supplier</th>
        <th scope="col">Status Supplier</th>
      </tr>
  </thead>
  <tbody>

    @php
      $kodes = ($kodesupplier !== null) ? $kodesupplier->kode_supplier : "SPL000";
      $noUrut = substr($kodes,3);
      $noUrut++;
      $char = "SPL";
      $kode = $char.sprintf("%03s",$noUrut);
    @endphp
    @foreach($supplier as $data)
      <tr class="detail" data-id="{{ $data->id_supplier }}">
        <td>{{ $data->kode_supplier }}</td>
        <td>{{ $data->nama_supplier }}</td>
        	@if ($data->status == "Aktif")
        	 	@php
        	 		echo "<td><span class='badge badge-primary'>$data->status</span></td>";
        	 	@endphp
			@else
				@php
					echo "<td><span class='badge badge-danger'>$data->status</span></td>";
				@endphp
        	@endif 	


      </tr>
    @endforeach
  </tbody>
</table>
</div>

<div class="mt-3">{{ $supplier->links('vendor.pagination.bootstrap-4') }}</div>

 <div class="modaldetail"></div>
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg mr-auto" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Supplier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <form class="form-prevent" action="{{ route('supplier.store') }}" method="POST">
                      @csrf
                      Kode Supplier <input type="text" class="form-control" name="kode_supplier" value="{{ $kode }}" readonly="">
                      Nama Supplier <input type="text" class="form-control" name="nama_supplier">
                      Deskripsi Supplier <textarea class="form-control" name="deskripsi_supplier" cols="30" rows="10"></textarea>
                  </div>
                  <div class="modal-footer">
                    <button type="submit" class="btn btn-primary button-prevent">Tambah!</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>  
</div>

@endsection

@section('footer')
@parent

<script> 
  
  $(document).ready(function(){
  prevent();

    $('.detail').click(function(){
      $('.loadingmodal').append(`Loading...`);

      $.ajax({
        type:'GET',
        url:'/supplier/detail',
        dataType:'json',
        data:{
          "id":$(this).data('id')
        },
        success:function(result){
          var data = result[0];



	           $('.modaldetail').html(`
             <div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabell111" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">`+data.nama_supplier+`</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <form class="form-prevent" action="/supplier/`+data.id_supplier+`" method="POST">
                                  @method('PUT')
                                  @csrf
                                 Kode Jenis obat <input value="`+data.kode_supplier+`" type="text" name="kode_supplier" class="form-control" readonly="">
                                 Nama Jenis obat <input value="`+data.nama_supplier+`" type="text" name="nama_supplier" class="form-control">
                                 Deskripsi Jenis obat <textarea class="form-control mb-3" name="deskripsi_supplier" cols="30" rows="10">`+data.deskripsi_supplier+`</textarea>
                              	 Jumlah Pengiriman <input class="form-control" type="text" name="jumlah_pengiriman" value="`+data.jumlah_pengiriman+`" readonly/>
                                 Status <select class="form-control mb-3" name="status">
									<option disabled selected value="">-- Pilih Status --</option>
									<option value="Aktif">Aktif</option>
									<option value="Tidak Aktif">Tidak Aktif</option>
                                 </select>  
                                   <button type="submit" class="btn btn-warning button-prevent">Ubah Data</button>
                                 </form>
                                 
                                 <form class="form-prevent" action="/supplier/`+data.id_supplier+`" method="POST">
                                 @method('DELETE') 
                                 @csrf 
                                 <button type="submit" class="btn btn-danger button-prevent">Hapus Data</button>
                                 </form>

                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                  </div>
                                
                            <div class="modal-footer">
                              
                            </div>
                          </div>
                        </div>
                      </div>
                  `);

           $(".loadingmodal").html('');
           $("#modalDetail").modal('show');
           $("select[name=status]").val(data.status).change();
           $("#modalDetail").on("hide.bs.modal", function () {
              $(".modaldetail").html('');
              $(".modal-backdrop").remove();
              $("#modalDetail").modal('hide');
           });
          
           prevent();
        }

    });
    });

    function prevent(){
      $(".form-prevent").on("submit",function(){

        $(".button-prevent").attr('disabled','true');
      
      });
    }
    
  });





</script>

@endsection