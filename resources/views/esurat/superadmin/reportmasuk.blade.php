@extends('adminlte::page')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
   -->
    
@stop

@section('title', 'Laporan Surat')

{{-- @section('content_header') --}}

{{-- @stop --}}


@section('content')
 <div class="card">
    <div class="card-header">
        <h3 class="card-title" >LAPORAN SURAT MASUK</h3>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
         @endif
    </div>

   

    <div class="card-body">
    <form method="post" id="formreport" action="{{ URL::to('reportmasuk/tampilpdf') }}" target="_blank">
    @csrf
    <div class="form-group row">
      
        <label for="inputPassword3" class="col-sm-2 col-form-label">Unit Bagian</label>
        <div class="col-sm-4">

            <select class="form-control" id="bagian" name="bagian">
              
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Tanggal</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" id="tglawal" name="tglawal">
        </div>
        <label for="inputPassword3" class="col-sm-2 col-form-label">Sampai Tanggal</label>
        <div class="col-sm-4">
            <input type="date" class="form-control" id="tglakhir" name="tglakhir">
        </div>
    </div>
    <div class="form-group row">
        <input type="submit" name="btnreport" value="Cetak Laporan" class="btn btn-primary">
    </div>
    </form>
    </div>
</div>


@stop
@section('js')
<!-- <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script> -->
  
<script>
   $(function(){
    let header ='';
    let isi ='';


    $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
    });

    showbagian();
    
    $('#btnexport').hide();
    $('#tablerep').hide();

    // $('#btnreport').click(function (e) { 
    //     e.preventDefault();
      
    //     $('#tablerep').show();
    //     $('#btnexport').show();

    //     let bagian =$('#bagian').val();
    //     let tglawal =$('#tglawal').val();
    //     let tglakhir =$('#tglakhir').val();
    //     let url = "/laporansuratmasuk/"+bagian+"/"+tglawal+"/"+tglakhir;
    //     //console.log(url);

    //     $('#tablerep').DataTable({
    //         searching: false,
    //         bDestroy:true,
            
    //             ajax: {
    //             url:url,
    //             dataSrc: "data",
    //             processing: true,
    //             contentType: "application/json"

    //             },
    //             columns:[
    //                 {"data": "no_surat"},
    //                 {"data": "tgl_surat"},
    //                 {"data": "pengirim"}
    //             ]
        
    //     });

    // });


    $('#btnexport').click(function (e) { 
        e.preventDefault();
        let bagian = $('#bagian').val();
        let tglawal = $('#tglawal').val();
        let tglakhir = $('#tglakhir').val();

        $.ajax({
            type: "POST",
            url: "/reportmasuk/pdf?bagian=semua",
            data: {
                bagian : bagian,
                tglawal : tglawal,
                tglakhir : tglakhir

            },
            success: function (response) {
                console.log('ini ambil dr form');
                console.log(response);
                let url="/reportmasuk/tampilpdf?tglawal="+response.tglawal+"&tglakhir="+response.tglakhir;
                //window.location = '/reportmasuk/tampilpdf';
                console.log(url);

                // $.ajax({
                //     type: "GET",
                //     url: url,
                //     dataType: "JSON",
                //     success: function (response) {
                //         console.log(response);
                //     }
                // });
            }
        });
        
    });
        
    function showbagian(){
           const url = 'http://localhost:8000/showbagian';
           let isi = '';
           let semua = `<option value="Semua Bagian"> Semua Bagian </option>`;

           $.ajax({
               type: "GET",
               url: url,
               dataType: "JSON",
               success: function (response) {
               console.log(response);
               $.each(response, function (idx, val) {
                  isi += `
                      <option value="${val.nama_bagian}">${val.nama_bagian}</option> 
                  `;
               });
               $('#bagian')
                      .empty()
                      .append(semua)
                      .append(isi);
                      
               }
           });
    };


   });
</script>
@stop

@section('footer')
    <h1></h1>
@stop
