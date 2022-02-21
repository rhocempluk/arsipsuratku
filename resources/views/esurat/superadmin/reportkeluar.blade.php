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
        <h3 class="card-title" >LAPORAN SURAT KELUAR</h3>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
         @endif
    </div>

   

    <div class="card-body">
    <form method="post" id="formreport" action="{{ URL::to('reportkeluar/tampilpdf') }}" target="_blank">
    @csrf
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

    
    $('#btnexport').hide();
    $('#tablerep').hide();

</script>
@stop

@section('footer')
    <h1></h1>
@stop
