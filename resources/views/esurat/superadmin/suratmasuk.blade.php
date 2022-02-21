@extends('adminlte::page')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
@stop

@section('title', 'Surat Masuk')

{{-- @section('content_header') --}}

{{-- @stop --}}


@section('content')
 <div class="card">
    <div class="card-header">
        <h3 class="card-title" >DATA SURAT MASUK</h3>
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
         @endif
        <a class="btn btn-primary float-right" id="btntambah" href="" title="Tambah Surat Masuk"><i class="fa fa-plus-circle"> </i> Tambah Surat Masuk</a>
    </div>

    <!-- <div class="small-box bg-blue">
        <div class="inner">
          <h3>{{ $user }}</h3>
          <p>USER</p>
        </div>
        <div class="icon">
          <i class="fas fa-user-friends fa-2x"></i>
        </div>
        <a href="/user" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
      </div>
    </div> -->

    <div class="card-body">
        <table id="tbsuratmsk" class="table table-hover">
            <thead>
            <tr>
              <th>No</th>
              <th>Id</th>
              <th>No. Surat</th>
              <th>Tanggal Surat</th>
              <th>Pengirim</th>
              <th>Perihal</th>
              <th>Disposisi</th>
              <th>Aksi</th>
            </tr>
            </thead>

            <tbody id="dynamictable">
            @php
               $i = 1;
            @endphp
            @foreach($suratmsk as $dt)
                <tr>
                  <td> {{ $i++ }} </td>
                  <td class="nr" scope="row"> {{ $dt->id }} </td>
                  <td> {{ $dt->no_surat }} </td>
                  <td> {{ $dt->tgl_surat }} </td>
                  <td> {{ $dt->pengirim}} </td>
                  <td> {{ $dt->perihal}} </td>
                  <td> @if( $dt->status_dispo === "Belum Didisposisi" )
                            <span class="badge badge-pill badge-danger">{{ $dt->status_dispo }}</span>
                       @else
                            <span class="badge badge-pill badge-success">{{ $dt->status_dispo }}</span> 
                       @endif
                  </td>
                  <td>
                    @if( $user === "Super Admin")
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
                        @if( $dt->status_dispo === "Belum Didisposisi" )
                          <span class="fa-stack">
                          <a href="" id="btnDispo" title="Disposisi"><i class="fa fa-square fa-stack-2x"></i>
                          <i class="fa fa-paper-plane fa-stack-1x" style="color: white"></i></a>
                        </span>
                        @endif
                    @else
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
                    @endif
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
          <h5 class="modal-title" id="ttlform"> Tambah Surat Masuk</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="" method="post" enctype="multipart/form-data" id="formtambah">
            @csrf
            
            <input type="hidden" name="idsuratmasuk" id="idsuratmasuk">
                  <div class="form-group">
                      <label>No. Surat</label>
                      <input type="text" class="form-control" id="no_surat" name="no_surat">
                  </div>
                  <div class="form-group">
                      <label>Tanggal Surat</label>
                      <input class="form-control" type="date" id="tgl_surat" name="tgl_surat">
                  </div>
                  <div class="form-group">
                        <label>Tanggal Diterima</label>
                        <input class="form-control" type="date" id="tgl_diterima" name="tgl_diterima">
                  </div>
                  <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Klasifikasi Surat</label>
                        <select class="form-control" name="kode_surat" id="kode_surat">

                        </select>
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
                        <label>Pengirim</label>
                        <input type="text" class="form-control" id="pengirim" name="pengirim">
                  </div>
                  <div class="form-group">
                        <label>Perihal</label>
                        <input type="text" class="form-control" id="perihal" name="perihal">
                  </div>
                  <div class="form-group">
                        <label>Lampiran</label><br>
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
                  <td><span id="no_surat1"></span></td>
              </tr>
              <tr>
                  <th>Tanggal Surat</th>
                  <td><span id="tgl_surat1"></span></td>
              </tr>
              <tr>
                  <th>Tanggal Diterima</th>
                  <td><span id="tgl_diterima1"></span></td>
              </tr>
              <tr>
                  <th>Klasifikasi Surat</th>
                  <td><span id="kode_surat1"></span></td>
              </tr>
              <tr>
                  <th>Sifat</th>
                  <td><span id="sifat1"></span></td>
              </tr>
              <tr>
                  <th>Pengirim</th>
                  <td><span id="pengirim1"></span></td>
              </tr>
              <tr>
                  <th>Perihal</th>
                  <td><span id="perihal1"></span></td>
              </tr>
              <tr>
                  <th>Lampiran File</th>
                  <td><span id="lampiranjudul"></span></td>
              </tr>
              <tr>
                  <th></th>
                  <td><span id="lampiran1"></span></td>
              </tr>
              <tr>
                  <th>Disposisi</th>
                  <td>
                  
                  <span id="disposisi1"><span class="badge badge-pill badge-danger"></span></span></td>
              </tr>
              <tr>
                  <th>Isi Disposisi</th>
                  <td><span id="isidisposisi1"></span></td>
              </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
{{--end modal detail--}}


{{--modal disposisi--}}
<div id="modaldispo" class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ttlform">DISPOSISI SURAT</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <input type="hidden" name="idsuratmasukdispo" id="idsuratmasukdispo">
            <div class="form-group">
                <label>No. Surat Masuk</label>
                <input class="form-control" type="text" id="no_suratmasuk" disabled>
            </div>
            <div class="form-group">
                  <label>Tanggal Disposisi</label>
                  <input class="form-control" type="date" id="tgl_disposisi">
            </div>
            <div class="form-group">
                    <div class="form-group">
                        <label>Ditujukan</label>
                          <select class="form-control" id="tujuandispo" name="tujuandispo">

                          </select>
                    </div>
            </div>
            <div class="form-group">
                  <label>Isi Disposisi</label>
                  <textarea class="form-control" name="isi" id="isi"></textarea>
            </div>
            <input type="submit" id="btnsimpandispo" value="Simpan" name="simpan" class="btn btn-primary" >
      </div>
    </div>
  </div>
</div>
{{--end modal disposisi--}}


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
        var table = $('#tbsuratmsk').DataTable();
        table.column(1).visible( false );
    });

    $('#btntambah').click(function (e) {
      e.preventDefault();
      $('.modal-body').find('textarea,input').val('');
      $('#lampiran').empty(); 
      $('#btnsave').val('Simpan');
      $('#ttlform').html('TAMBAH SURAT MASUK');
      $('#mdlform').modal('show');
      $('#formtambah').attr('action', 'simpan')
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
                      <option value="${val.kode_surat}"> ${val.nama_surat}  </option>
                  `;
                 });
                 $('#kode_surat')
                      .empty()
                      .append(isi);
               }
           });
    }

    
    function generateObjek2(obj) {
        for (let key in obj) {
            if (obj.hasOwnProperty(key) && (typeof obj[key] === "object")) {
                generateObjek2(obj[key])
            } else {
                if (key == 'no_surat') {
                       $('#no_surat1').text( obj[key] ); 
                }
                if (key == 'tgl_surat') {
                       $('#tgl_surat1').text( obj[key] ); 
                }
                if (key == 'tgl_diterima') {
                       $('#tgl_diterima1').text( obj[key] ); 
                }
                if (key == 'kode_surat') {
                       $('#kode_surat1').text( obj[key] ); 
                }
                if (key == 'sifat') {
                       $('#sifat1').text( obj[key] ); 
                }
                if (key == 'pengirim') {
                       $('#pengirim1').text( obj[key] ); 
                }
                if (key == 'perihal') {
                       $('#perihal1').text( obj[key] ); 
                }
                if (key == 'lampiran') {
                       $('#lampiranjudul').text( obj[key] );
                       $('#lampiran1').html("<a href='{{ URL::to('/') }}/upload/" + obj[key] + "' target='_blank'><img src={{ URL::to('/') }}/image/document-icon.png width='70' class='img-thumbnail' /></a><br>Silahkan klik untuk melihat "); 
                }
                if (key == 'status_dispo') {
                  
                    $('#disposisi1').text( obj[key] );
                  
                }
                if (key == 'isi') {
                       $('#isidisposisi1').text( obj[key] ); 
                }
                   
            }
        }
    }

    function showbagian() {
           const url = 'http://localhost:8000/showbagian';
           let isi = '';

           $.ajax({
               type: "GET",
               url: url,
               dataType: "JSON",
               success: function (response) {
                console.log(response);
                 $.each(response, function (idx, val) {
                  isi += `
                      <option value=" ${val.id} "> ${val.nama_bagian}  </option>
                  `;
                 });
                 $('#tujuandispo')
                      .empty()
                      .append(isi);
               }
           });
    }


   

    $(document).on("click", "#tbsuratmsk tbody tr td #btnEdit", function (e) {
      e.preventDefault();
      var table = $('#tbsuratmsk').DataTable();
      var data = table.row( $(this).parents('tr') ).data();

      
      $('#mdlform').modal('show');
      $('#btnsave').val('Ubah');
      $('#ttlform').html('UBAH SURAT MASUK');
      $('#formtambah').attr('action', 'ubah/' + data[1]);
      showjenissurat();
    
      // let $row = $(this).closest("tr");
      // let $text = $row.find(".nr").text();
      
    
      let url ='suratmasuk/' + data[1] + '/edit';
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
          $('#idsuratmasuk').val(response.id);
          $('#no_surat').val(response.no_surat);
          $('#tgl_surat').val(response.tgl_surat);
          $('#tgl_diterima').val(response.tgl_diterima);
          $('#kode_surat').val(response.kode_surat);
          $('#sifat').val(response.sifat);
          $('#pengirim').val(response.pengirim);
          $('#perihal').val(response.perihal);
          $('#lampiran').show();
          $('#lampiran').html("<a href='{{ URL::to('/') }}/upload/" + response.lampiran + "' target='_blank'><img src={{ URL::to('/') }}/image/document-icon.png width='70' class='img-thumbnail' /></a><br>");
          $('#lampiran').append(response.lampiran+"<br> Silahkan klik untuk melihat");
          $('#tbsuratmsk tbody').append(isi);
        }
      });
    });

    $(document).on("click", "#tbsuratmsk tbody tr td #btnDelete", function (e) {
      e.preventDefault();
      var table = $('#tbsuratmsk').DataTable();
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
            
            let url = 'suratmasuk/' + data[1];
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


    $(document).on("click", "#tbsuratmsk tbody tr td #btnDetail", function (e) {
      e.preventDefault();
      $('#modaldetail').modal('show');
      $('#titlemodaldetail').html('DETAIL SURAT MASUK');
      //showjenissurat();
    
      
      var table = $('#tbsuratmsk').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
    
      let url ='tampilsuratmasuk/' + data[1];
      console.log(url);

      $.ajax({
        type: "GET",
        url: url,
        dataType: "JSON",
        success: function (response) {
          let len=0;
          let isi;
          //let no_surat = $(this).data(no_surat)

          if(response != null){
            len = response.lenght;
          }
          console.table(response);
          $('#no_surat1').text()[3]; 
          $('#tgl_surat1').text(response.tgl_surat);
          $('#tgl_diterima1').text(response.tgl_diterima);
          $('#kode_surat1').text(response.kode_surat);
          $('#sifat1').text(response.sifat);
          $('#pengirim1').text(response.pengirim);
          $('#perihal1').text(response.perihal);
          $('#lampiran1').show();
          $('#lampiran1').html("<a href='{{ URL::to('/') }}/upload/" + response.lampiran + "' target='_blank'><img src={{ URL::to('/') }}/image/document-icon.png width='70' class='img-thumbnail' /></a><br>");
          $('#lampiran1').append(response.lampiran+"<br> Silahkan klik untuk melihat");
          $('#disposisi1').text(response.status_dispo);
          $('#isidisposisi1').text(response.isi);
         generateObjek2(response);
        }
      });
    });


    $(document).on("click", "#tbsuratmsk tbody tr td #btnDispo", function (e) {
      e.preventDefault();
       e.preventDefault();
      $('#modaldispo').modal('show');
      showbagian();
    
      var table = $('#tbsuratmsk').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
    
      let url ='suratmasuk/' + data[1] + '/edit';
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
          
          $('#idsuratmasukdispo').val(response.id);
          $('#no_suratmasuk').val(response.no_surat);
          $('#tbsuratmsk tbody').append(isi);
        }
      });
    });

    $('#btnsimpandispo').click(function (e) {
    e.preventDefault();
      
      let idsuratmasukdispo =  $('#idsuratmasukdispo').val();
      let tgl_disposisi =  $('#tgl_disposisi').val();
      let tujuandispo =  $('#tujuandispo').val();
      let isi =  $('#isi').val();

        $.ajax({
            type: "POST",
            url: "savedisposisi",
            data: {
                //no_disposisi:no_disposisi,
                id_suratmasuk : idsuratmasukdispo,
                tgl_disposisi :tgl_disposisi, 
                id_bagian : tujuandispo,
                isi : isi 
            },
            success: function (response) {
                console.log(response);
                $('#modaldispo').modal('hide');
                $('#btnDispo').prop('disabled', true);
                Swal.fire({
                    icon: 'success',
                    title: 'Data berhasil disimpan',
                    showConfirmButton: false,
                    timer: 1700
                }).then(function(){
                    location.reload();
                    }
                );
            }
        });

        let url = "ubahstatus/" + idsuratmasukdispo + "/edit";
        var selectedText = $("#tujuandispo option:selected").html();

        $.ajax({
            type: "POST",
            data:{
              id_suratmasuk : idsuratmasukdispo,
              status_dispo : selectedText
              
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
