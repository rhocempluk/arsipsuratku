@extends('adminlte::page')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
@stop

@section('title', 'Surat Keluar')

{{-- @section('content_header') --}}

{{-- @stop --}}


@section('content')
 <div class="card">
    <div class="card-header">
        <h3 class="card-title" >DATA SURAT KELUAR</h3>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
         @endif
        <a class="btn btn-primary float-right" id="btntambah" href="" title="Tambah Surat Keluar"><i class="fa fa-plus-circle"> </i> Tambah Surat Keluar</a>
    </div>

    <div class="card-body">
        <table id="tbsuratkeluar" class="table table-hover">
            <thead>
            <tr>
              <th>No</th>
              <th>Id</th>
              <th>No. Surat Keluar</th>
              <th>Tanggal Surat Keluar</th>
              <th>Kepada</th>
              <th>Perihal</th>
              <th>Sifat</th>
              <th>Aksi</th>
            </tr>
            </thead>

            <tbody id="dynamictable">
            @php
               $i = 1;
            @endphp
            @foreach($suratkeluar as $dt)
                <tr>
                  <td> {{ $i++ }} </td>
                  <td class="nr" scope="row"> {{ $dt->id }} </td>
                  <td> {{ $dt->no_suratkeluar }} </td>
                  <td> {{ date('d-m-Y', strtotime($dt->tgl_surat)) }}  </td>
                  <td> {{ $dt->kepada}} </td>
                  <td> {{ $dt->perihal}} </td>
                  <td> {{ $dt->sifat}} </td>
                  <td>
                      <span class="fa-stack">
                      <a href="" id="btnDetail" title="Detail" ><i class="fa fa-square fa-stack-2x"></i>
                          <i class="fas fa-search-plus fa-stack-1x" style="color: white"></i></a>
                      </span>
                      <span class="fa-stack">
                      <a href="" id="btnEdit" title="Ubah" ><i class="fa fa-square fa-stack-2x"></i>
                          <i class="fas fa-edit fa-stack-1x" style="color: white"></i></a>
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
<div id="mdlform" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ttlform"> Tambah Surat Keluar</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="formtambah">
            @csrf
          
            <input type="hidden" name="idsuratkeluar" id="idsuratkeluar">
                  <label>No. Surat</label>
                  <div class="form-group" id="formremove">
                      <input class="form-control" type="text" id="nosuratedit" name="nosuratedit">
                  </div>
                  <div class="row g-4" id="formtampil">
                        <div class="col-sm-4">
                          <select class="form-control" name="kode_surat" id="kode_surat">
                          </select>
                        </div>
                        <div class="col-sm">
                          <input type="text" class="form-control" name="nourut" id="nourut">
                        </div>
                        <div class="col-sm">
                          <input type="text" class="form-control" name="kodeinstansi" id="kodeinstansi">
                        </div>
                        <div class="col-sm">
                          <input type="text" class="form-control" name="thnsurat" id="thnsurat">
                        </div>
                  </div>
                  <div class="form-group">
                      <label>Tanggal Surat</label>
                      <input class="form-control" type="date" id="tgl_surat" name="tgl_surat">
                  </div>
                  <div class="form-group">
                        <label>Pengirim</label>
                        <input class="form-control" type="text" id="pengirim" name="pengirim">
                  </div>
                  <div class="form-group">
                        <label>Sifat</label>
                          <select class="form-control" id="sifat" name="sifat">
                          <option value="">- Pilih -</option>
                          <option>Biasa</option>
                          <option>Segera</option>
                          <option>Penting</option>
                          <option>Rahasia</option>
                          <option>Perhatian Batas Waktu</option>
                          <option>Perlu Perhatian Khusus</option>
                        </select>
                  </div>
                  <div class="form-group">
                        <label>Kepada</label>
                        <input type="text" class="form-control" id="kepada" name="kepada">
                  </div>
                  <div class="form-group">
                        <label>Perihal</label>
                        <input type="text" class="form-control" id="perihal" name="perihal">
                  </div>
                  <div class="form-group">
                        <label>Isi Surat</label>
                        <textarea class="form-control" id="isi_surat" name="isi_surat" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                        <label>Alamat Pengiriman</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                        <label>Ekspedisi</label>
                        <input type="text" class="form-control" id="ekspedisi" name="ekspedisi">
                  </div>
                  <div class="form-group">
                        <label>Lampiran File</label><br>
                        <span id="lampiran"></span>
                  </div>
                  <div class="form-group">
                      <input type="file" class="form-control" id="gbrlampiran" name="gbrlampiran">
                </div>
              <input type="submit" id="btnsave" value="Simpan" name="simpan" class="btn btn-primary" >
            </form>
        </div>
      </div>
    </div>
</div>
{{--endmodal--}}

{{--modal detail--}}
<div id="modaldetail" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="titlemodaldetail"> Detail Surat Keluar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body table-responsive">
        <table class="table table-borderless">
          <tbody>
              <tr>
                  <th>No. Surat</th>
                  <td><span id="no_surat1"></span></td>
              </tr>
              <tr>
                  <th>Tanggal Surat</th>
                  <td><span id="tgl_surat1"></span></td>
              </tr>
              <tr>
                  <th>Pengirim</th>
                  <td><span id="pengirim1"></span></td>
              </tr>
              <tr>
                  <th>Kepada</th>
                  <td><span id="kepada1"></span></td>
              </tr>
              <tr>
                  <th>Perihal</th>
                  <td><span id="perihal1"></span></td>
              </tr>
              <tr>
                  <th>Isi Surat</th>
                  <td><span id="isisurat1"></span></td>
              </tr>
              <tr>
                  <th>Sifat</th>
                  <td><span id="sifat1"></span></td>
              </tr>
              <tr>
                  <th>Alamat</th>
                  <td><span id="alamat1"></span></td>
              </tr>
              <tr>
                  <th>Ekspedisi</th>
                  <td><span id="ekspedisi1"></span></td>
              </tr>
              <tr>
                  <th>Lampiran File</th>
                  <td><span id="lampiranjudul1"></span></td>
              </tr>
              <tr>
                  <th></th>
                  <td><span id="lampiran1"></span></td>
              </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
{{--end modal detail--}}


@stop
@section('js')
  <script>
   $(function () {
    $.ajaxSetup({
       headers: {
       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     }
    });

    $(document).ready(function() {
        var table = $('#tbsuratkeluar').DataTable();
        table.column(1).visible( false );
    });

    $('#btntambah').click(function (e) {
      var today = new Date();
      var year = today.getFullYear();

      e.preventDefault();
      $('.modal-body').find('textarea,input').val('');
      $('#lampiran').empty(); 
      $('#btnsave').val('Simpan');
      $('#ttlform').html('TAMBAH SURAT KELUAR');
      $('#mdlform').modal('show');
      $('#formtambah').attr('action', 'simpansuratkeluar')
      $('#kodeinstansi').val('101.6.26');
      $('#thnsurat').val(year);
      $('#formremove').hide();
      $('#formtampil').show();
      showjenissurat();
    });

    function showjenissurat() {
           const url = 'http://localhost:8000/showjenissurat';
           let isi = '';

           $.ajax({
               type: "GET",
               url: url,
               dataType: "JSON",
               success: function (response) {
                console.log(response);
                 $.each(response, function (idx, val) {
                  isi += `
                      <option value="${val.kode_surat}"> ${val.kode_surat} || ${val.nama_surat}</option>
                  `;
                 });
                 $('#kode_surat')
                      .empty()
                      .append(isi);
               }
           });
    }
    
    function generateObjek(obj) {
        for (let key in obj) {
            if (obj.hasOwnProperty(key) && (typeof obj[key] === "object")) {
                generateObjek(obj[key])
            } else {
                if (key == 'no_suratkeluar') {
                       $('#no_surat1').text( obj[key] ); 
                }
                if (key == 'tgl_surat') {
                       $('#tgl_surat1').text( obj[key] ); 
                }
                if (key == 'pengirim') {
                       $('#pengirim1').text( obj[key] ); 
                }
                if (key == 'kepada') {
                       $('#kepada1').text( obj[key] ); 
                }
                if (key == 'perihal') {
                       $('#perihal1').text( obj[key] ); 
                }
                if (key == 'isi_surat') {
                       $('#isisurat1').text( obj[key] ); 
                }
                if (key == 'sifat') {
                       $('#sifat1').text( obj[key] ); 
                }
                if (key == 'alamat') {
                       $('#alamat1').text( obj[key] ); 
                }
                if (key == 'ekspedisi') {
                       $('#ekspedisi1').text( obj[key] ); 
                }
                if (key == 'lampiran') {
                       $('#lampiranjudul1').text( obj[key] );
                       $('#lampiran1').html("<a href='{{ URL::to('/') }}/upload/" + obj[key] + "' target='_blank'><img src={{ URL::to('/') }}/image/document-icon.png width='70' class='img-thumbnail' /></a><br>Silahkan klik untuk melihat "); 
                }                  
            }
        }
    }

    $(document).on("click", "#tbsuratkeluar tbody tr td #btnEdit", function (e) {
      e.preventDefault();
      var table = $('#tbsuratkeluar').DataTable();
      var data = table.row( $(this).parents('tr') ).data();

      $('#mdlform').modal('show');
      $('#btnsave').val('Ubah');
      $('#ttlform').html('UBAH SURAT KELUAR');
      $('#formtambah').attr('action', 'ubahsuratkeluar/' + data[1]);
      $('#formremove').show();
      $('#formtampil').hide();
      showjenissurat();

      let url ='suratkeluar/' + data[1] + '/edit';
      console.log(url);

      $.ajax({
        type: "GET",
        url: url,
        dataType: "JSON",
        success: function (response) {
          let len=0;
          let isi;

          if(response != null){
            len = response.lenght;
          }
          console.table(response);
          $('#idsuratkeluar').val(response.id);
          $('#nosuratedit').val(response.no_suratkeluar);
          $('#tgl_surat').val(response.tgl_surat);
          $('#pengirim').val(response.pengirim);
          $('#kepada').val(response.kepada);
          $('#sifat').val(response.sifat);
          $('#isi_surat').val(response.isi_surat);
          $('#perihal').val(response.perihal);
          $('#alamat').val(response.alamat);
          $('#ekspedisi').val(response.ekspedisi);
          $('#lampiran').show();
          $('#lampiran').html("<a href='{{ URL::to('/') }}/upload/" + response.lampiran + "' target='_blank'><img src={{ URL::to('/') }}/image/document-icon.png width='70' class='img-thumbnail' /></a><br>");
          $('#lampiran').append(response.lampiran+"<br> Silahkan klik untuk melihat");
          $('#tbsuratmsk tbody').append(isi);
        }
      });
    });

    $(document).on("click", "#tbsuratkeluar tbody tr td #btnDelete", function (e) {
      e.preventDefault();
      var table = $('#tbsuratkeluar').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
      console.log(data);
    
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
            
            let url = 'suratkeluar/' + data[1];
            console.log(url);

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
    });


    $(document).on("click", "#tbsuratkeluar tbody tr td #btnDetail", function (e) {
      e.preventDefault();
      $('#modaldetail').modal('show');
      $('#titlemodaldetail').html('DETAIL SURAT KELUAR');
      //showjenissurat();
    
      
      var table = $('#tbsuratkeluar').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
    
      let url ='tampilsuratkeluar/' + data[1];
      console.log(url);

      $.ajax({
        type: "GET",
        url: url,
        dataType: "JSON",
        success: function (response) {
          let len=0;
          let isi;

          if(response != null){
            len = response.lenght;
          }
          console.table(response);
          generateObjek(response);
        }
      });
    });


});
</script>
@stop

@section('footer')
    <h1></h1>
@stop
