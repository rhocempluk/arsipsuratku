@extends('adminlte::page')

@section('title', 'Dashboard | Selamat Datang')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
  <div class="row">



    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-red">
        <div class="inner">
          <h3>10</h3>
          <p>SURAT MASUK</p>
        </div>
        <div class="icon">
          <i class="	fas fa-envelope-open"></i>
        </div>
        <a href="/user" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

    <div class="col-lg-3 col-xs-6">
      <!-- small box -->
      <div class="small-box bg-green">
        <div class="inner">
          <h3>10</h3>
          <p>SURAT KELUAR</p>
        </div>
        <div class="icon">
          <i class="	fas fa-file-export"></i>
        </div>
        <a href="/user" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div>

   
  </div>


@stop

@section('footer')
    <h1></h1>
@stop