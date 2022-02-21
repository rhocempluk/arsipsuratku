@extends('adminlte::page')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
@stop

@section('title', 'Laporan Surat')

{{-- @section('content_header') --}}

{{-- @stop --}}


@section('content')
 <div class="card">
    <div class="card-header">
        <h3 class="card-title" >LAPORAN SURAT MASUK dan SURAT KELUAR</h3>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
         @endif
    </div>

    <div class="card-body">
    <form method="post" id="formreport">
    @csrf
    <div class="form-group row">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Kategori</label>
        <div class="col-sm-4">
            <select class="form-control" id="kategori" name="kategori">
                <option value="Surat Masuk">Surat Masuk</option>
                <option value="Surat Keluar">Surat Keluar</option>
            </select>
        </div>
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
        <button class="btn btn-success" id="btnreport" name="btnreport"> Tampilkan</button>
    </div>
    </form>
    </div>

    {{--modal report--}}
        <div id="modalreport" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ttlform">LAPORAN SURAT</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <table id="tbsurat" class="table table-hover">
                    <thead>

                    </thead>
                    <tbody>
                  
                    </tbody>
                </table>
                        <!-- <input type="submit" id="btnsimpandispo" value="Simpan" name="simpan" class="btn btn-primary" > -->
                </div>
                <div class="modal-footer">
                <a class="btn btn-primary float-right" id="" href="{{ URL::to('/getreport/pdf/1') }}" title="Cetak PDF" target="_blank"><i class="fas fa-file-pdf"></i>  Cetak PDF</a>
                </div>
            </div>
        </div>
        </div>
        {{--end modal report--}}

</div>



@stop
@section('js')
<script>
   $(function(){
    let header ='';
    let isi ='';


    $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
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
                      <option value=" ${val.nama_bagian} "> ${val.nama_bagian}  </option> 
                  `;
                 });
                 $('#bagian')
                      .empty()
                      .append(semua)
                      .append(isi);
                      
               }
           });
    };

    showbagian();

    function generateObjek(obj) {
        for (let key in obj) {
            if (obj.hasOwnProperty(key) && (typeof obj[key] === "object")) {
                generateObjek(obj[key])
            } else {
                //console.log(key + " -> " + obj[key]);
                if (key == 'no_surat') {
                    isi += `<td> ${obj['no_surat']} </td>`;
                }
                if (key == 'tgl_surat') {
                    isi += `<td> ${obj['tgl_surat']} </td>`;
                }
                if (key == 'pengirim') {
                    isi += `<td> ${obj['pengirim']} </td>`;
                }
                if (key == 'perihal') {
                    isi += `<td> ${obj['perihal']} </td> </tr> <tr>`;
                }
            }
        }
    }

    function generateObjek2(obj) {
        for (let key in obj) {
            if (obj.hasOwnProperty(key) && (typeof obj[key] === "object")) {
                generateObjek2(obj[key])
            } else {
                //console.log(key + " -> " + obj[key]);
                if (key == 'no_suratkeluar') {
                    isi += `<td> ${obj['no_suratkeluar']} </td>`;
                }
                if (key == 'tgl_surat') {
                    isi += `<td> ${obj['tgl_surat']} </td>`;
                }
                if (key == 'kepada') {
                    isi += `<td> ${obj['kepada']} </td>`;
                }
                if (key == 'perihal') {
                    isi += `<td> ${obj['perihal']} </td> </tr> <tr>`;
                }
                
            }
        }
    }


    $('#formreport').on('submit', function(e){
        e.preventDefault();

        let url     = 'http://localhost:8000/report/tampil';
        let data    = new FormData(this);

        $.ajax({
        type: "POST",
        url: url,
        data: data,
        processData: false,
        contentType: false,
        success: function (response) {
            $('#tbsurat thead').empty();
            $('#tbsurat tbody').empty();
            isi="";
           
            if (response.title === 'suratmasuk'){
                console.log(response);
                    header = `
                    <tr>
                        <td> No.Surat </td>
                        <td> Tanggal Surat Masuk</td>
                        <td> Pengirim </td>
                        <td> Perihal</td>
                    </tr>
                    `;
                $('#tbsurat > thead').append(header);
                isi +='<tr>';
                generateObjek(response);
                $('#tbsurat').append(isi);
            }else{
                console.log(response);
                    header = `
                    <tr>
                        <td> No.Surat </td>
                        <td> Tanggal Surat Keluar</td>
                        <td> Kepada </td>
                        <td> Perihal </td>
                    </tr>
                    `;
                $('#tbsurat > thead').append(header);
                isi +='<tr>';
                generateObjek2(response);
                $('#tbsurat').append(isi);
            };
        } 
        });
        $('#modalreport').modal('show');
    });

    $('#kategori').change(function(e){
        e.preventDefault();
        if($('#kategori').val() === "Surat Masuk"){
            $('#bagian').prop('disabled',false);
        }else{
            $('#bagian').prop('disabled',true);
        }
    });
   
});
</script>
@stop

@section('footer')
    <h1></h1>
@stop
