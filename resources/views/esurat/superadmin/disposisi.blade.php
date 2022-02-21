@extends('adminlte::page')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
@stop

@section('title', 'Disposisi Surat')

{{-- @section('content_header') --}}

{{-- @stop --}}


@section('content')
 <div class="card">
    <div class="card-header">
        <h3 class="card-title" >DISPOSISI SURAT</h3>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
         @endif
         <a class="btn btn-primary float-right" id="" href="{{ URL::to('/dispo/pdf') }}" title="Export ke PDF" target="_blank"><i class="fas fa-file-pdf"></i>  Export to PDF</a>
    </div>

    <div class="card-body">
        <table id="tbdisposisi" class="table table-hover">
            <thead>
            <tr>
              <th>No</th>
              <th>Id</th>
              <th>No. Surat</th>
              <th>Tanggal Disposisi</th>
              <th>Isi Disposisi</th>
              <th>Id Surat Masuk</th>
              <th>Aksi</th>
            </tr>
            </thead>

            <tbody id="tbtampildisposisi">
            @php
               $i = 1;
            @endphp
            @foreach($dispo as $dt)
                <tr>
                  <td> {{ $i++ }} </td>
                  <td class="nr" scope="row"> {{ $dt->id }} </td>
                  <td> {{ $dt->suratmasuk->no_surat }} </td>
                  <td> {{ date('d-m-Y', strtotime($dt->tgl_disposisi)) }} </td>
                  <td> {{ $dt->isi}} </td>
                  <td> {{ $dt->id_suratmasuk }} </td>
                  <td>
                      <span class="fa-stack">
                      <a href="" id="btnDetail" title="Detail" ><i class="fa fa-square fa-stack-2x"></i>
                          <i class="fas fa-search-plus fa-stack-1x" style="color: white"></i></a>
                      </span>
                      <span class="fa-stack">
                          <a href="" id="btnCetak" title="Cetak"><i class="fa fa-square fa-stack-2x"></i>
                          <i class="fas fa-print fa-stack-1x" style="color: white"></i></a>
                      </span>
                      <span class="fa-stack">
                          <a href="" id="btnDelete" title="Hapus"><i class="fa fa-square fa-stack-2x"></i>
                          <i class="fas fa-trash-alt fa-stack-1x" style="color: white"></i></a>
                      </span>
                    </td>
                  </tr>
            @endforeach
            </tbody>
          </table>
    </div>
</div>

{{--modal crud--}}
<div id="modaldetail" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titlemodaldetail"> Detail Surat Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-borderless">
          <tbody>
              <tr>
                  <th>No. Surat</th>
                  <td><span id="no_surat"></span></td>
              </tr>
              <tr>
                  <th>Tanggal Surat</th>
                  <td><span id="tgl_surat"></span></td>
              </tr>
              <tr>
                  <th>Tanggal Diterima</th>
                  <td><span id="tgl_diterima"></span></td>
              </tr>
              <tr>
                  <th>Sifat</th>
                  <td><span id="sifat"></span></td>
              </tr>
              <tr>
                  <th>Pengirim</th>
                  <td><span id="pengirim"></span></td>
              </tr>
              <tr>
                  <th>Perihal</th>
                  <td><span id="perihal"></span></td>
              </tr>
              <tr>
                  <th>Lampiran</th>
                  <td><span id="lampiranjudul"></span></td>
              </tr>
              <tr>
                  <th></th>
                  <td><span id="lampiran"></span></td>
              </tr>
              <tr>
                  <th>Disposisi Kepada</th>
                  <td><span id="disposisi"><span class="badge badge-pill badge-danger"></span></span></td>
              </tr>
              <tr>
                  <th>Isi Disposisi</th>
                  <td><span id="isidisposisi"></span></td>
              </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
{{--endmodal--}}




@stop
@section('js')
  <script>
   $(function () {
    $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
    });

    function generateObjek(obj) {
        for (let key in obj) {
            if (obj.hasOwnProperty(key) && (typeof obj[key] === "object")) {
                generateObjek(obj[key])
            } else {
                //console.log(key + " -> " + obj[key]);
                if (key == 'no_surat') {
                       $('#no_surat').text( obj[key] ); 
                }
                if (key == 'tgl_surat') {
                       $('#tgl_surat').text( obj[key] ); 
                }
                if (key == 'tgl_diterima') {
                       $('#tgl_diterima').text( obj[key] ); 
                }
                if (key == 'sifat') {
                       $('#sifat').text( obj[key] ); 
                }
                if (key == 'pengirim') {
                       $('#pengirim').text( obj[key] ); 
                }
                if (key == 'perihal') {
                       $('#perihal').text( obj[key] ); 
                }
                if (key == 'lampiran') {
                       $('#lampiranjudul').text( obj[key] );
                       $('#lampiran').html("<a href='{{ URL::to('/') }}/upload/" + obj[key] + "' target='_blank'><img src={{ URL::to('/') }}/image/document-icon.png width='70' class='img-thumbnail' /></a><br>Silahkan klik untuk melihat "); 
                }
                if (key == 'status_dispo') {
                       $('#disposisi').text( obj[key] ); 
                }
                if (key == 'isi') {
                       $('#isidisposisi').text( obj[key] ); 
                }
                   
            }
        }
    }

    $(document).ready(function() {
        var table = $('#tbdisposisi').DataTable();
        table.column(1).visible( false );
        table.column(5).visible( false );
        
    });

    $(document).on("click", "#tbdisposisi tbody tr td #btnDetail", function (e) {
      e.preventDefault();
      $('#modaldetail').modal('show');
      $('#titlemodaldetail').html("DETAIL DISPOSISI" + "<br><span class='badge badge-danger'>Closed</span>");
      //showjenissurat();
    
      
      var table = $('#tbdisposisi').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
    
      let url ='tampildispo/' + data[1];
      console.log(url);

      $.ajax({
        type: "GET",
        url: url,
        dataType: "JSON",
        success: function (response) {
          //console.log(response);
          let len=0;
          let isi;
         //var no_surat = $(this).data(no_surat);

          if(response != null){
            len = response.lenght;
          }
          console.log(response);
          generateObjek(response);
        }
      });
    });


    $(document).on("click", "#tbdisposisi tbody tr td #btnCetak", function (e) {
      e.preventDefault();
      var table = $('#tbdisposisi').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
    
      let url ='cetaklembardispo/' + data[1];
      console.log(url);
      //$(location).attr('href', 'http://localhost:8000/' + url);
      window.open('http://localhost:8000/' + url, '_blank'); 
    });


    $(document).on("click", "#tbdisposisi tbody tr td #btnDelete", function (e) {
      e.preventDefault();
      var table = $('#tbdisposisi').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
    
      Swal.fire({
        title: 'Yakin hapus data ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.isConfirmed) {
            
            let url = 'disposisi/' + data[1];
            //console.log(url);
            $.ajax({
            type: "DELETE",
            url: url,
            cache: false,
            data: $('#deleteform').serialize(),
            success: function (response) {
                console.log(response);
                Swal.fire({
                    icon: 'success',
                    title: 'Data berhasil dihapus',
                    showConfirmButton: false,
                    timer: 1700
                }).then(function(){
                    location.reload();
                });

            },
            error: function(error){
                console.log(error);
            }
            });

        }
        });

        //ubah status surat masuk
        let idubah = data[5];
        let url = "rubahstatus/" + idubah + "/edit";
        //alert( 'Clicked row id '+ url);
        console.log(data);

        $.ajax({
            type: "POST",
            data:{
              id_suratmasuk : idubah,
              //status_dispo : selectedText
            },
            url: url,
            success: function (response) {
               console.log(response);
            }
        });

    });


});
</script>
@stop

@section('footer')
    <h1></h1>
@stop