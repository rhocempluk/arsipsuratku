@extends('adminlte::page')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
@stop

@section('title', 'Manajemen Jenis Surat')

{{-- @section('content_header') --}}

{{-- @stop --}}


@section('content')

  <div class="card">
        <div class="card-header">
                <h3 class="card-title" >DATA JENIS SURAT</h3>
                 @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          <a class="btn btn-primary float-right" id="btntambah" href="" title="Tambah Jenis Surat"><i class="fa fa-plus-circle"> </i> Tambah Jenis Surat</a>
        </div>

        <div class="card-body">

            {{-- <h3 align="center"><span id="total_records"></span></h3> --}}
          <table id="tbjenissurat" class="table table-hover">
            <thead>
            <tr>
              <th>No</th>
              <th>Id</th>
              <th>Kode Surat</th>
              <th>Nama Surat</th>
              <th>Aksi</th>
            </tr>
            </thead>

            <tbody id="dynamictable">
            @php
               $i = 1;
            @endphp
            @foreach($surat as $dt)
                <tr>
                  <td> {{ $i++ }} </td>
                  <td class="nr" scope="row"> {{ $dt->id }} </td>
                  <td> {{ $dt->kode_surat }} </td>
                  <td> {{ $dt->nama_surat }} </td>
                  <td>
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


            <!-- Modal Form -->
            <div class="modal fade" id="modalUtama" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="crudmodal"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                    <input type="hidden" name="idsurat" id="idsurat">
                                      <div class="form-group">
                                      <label>Kode Surat</label>
                                      <input type="text" class="form-control" id="kode_surat">
                                    </div>
                                    <div class="form-group">
                                            <label>Nama Surat</label>
                                            <input type="text" class="form-control" id="nama_surat">
                                    </div>

                    </div>
                    <div class="modal-footer">
                        <button id="btnSimpan" type="button" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
                </div>
            </div>
            <!-- End Modal Form -->
        </div>
  </div>
@stop


@section('js')
<script>
    $(function(){
     $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });

    $(document).ready(function() {
        //$('#tbuser').DataTable();
        var table = $('#tbjenissurat').DataTable();
        table.column(1).visible( false );
    });

    $('#btntambah').click(function (e) {
        e.preventDefault();
        //console.log('dipencet');
        $('#modalUtama').modal('show');
        $('#crudmodal').html("TAMBAH JENIS SURAT");
        $('.modal-body').find('textarea,input').val('');
        $('#btnSimpan').html('Simpan');

    });

    $('#btnSimpan').click(function (e) {
         e.preventDefault();
         if ($('#btnSimpan').html()=='Simpan'){
           //alert('simpan');
           simpanSurat();
         }else{
           //alert('ubah');
           ubahSurat();
         }
    });

    function simpanSurat(){
        let kode_surat = $('#kode_surat').val();
        let nama_surat =  $('#nama_surat').val();

        $.ajax({
            type: "POST",
            url: "jenissurat",
            data: {
                kode_surat:kode_surat,
                nama_surat:nama_surat
            },
            success: function (response) {
                //console.log(response);
                $('#modalUtama').modal('hide');
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
    }


    $(document).on("click", "#tbjenissurat tbody tr td #btnEdit", function (e) {
      e.preventDefault();
      $('#modalUtama').modal('show');
      $('#crudmodal').html("UBAH JENIS SURAT");
      $('#btnSimpan').html('Ubah');
    

      // let $row = $(this).closest("tr");
      // let $text = $row.find(".nr").text();
       var table = $('#tbjenissurat').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
    
      let url ='jenissurat/' + data[1] + '/edit';

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
          $('#idsurat').val(response.id);
         $('#kode_surat').val(response.kode_surat);
         $('#nama_surat').val(response.nama_surat);
         $('#tbjenissurat tbody').append(isi);
        }
      });
    });


    function ubahSurat(){
      let url ='jenissurat/' + $('#idsurat').val();
      //alert(url);
      let kode_surat = $('#kode_surat').val();
      let nama_surat =  $('#nama_surat').val();

      $.ajax({
          type: "PUT",
          url: url,
          data: {
                kode_surat:kode_surat,
                nama_surat:nama_surat
            },
      success: function (response) {
            console.log(response);
            $('#modalUtama').modal('hide');
            Swal.fire({
                    icon: 'success',
                    title: 'Data berhasil dirubah',
                    showConfirmButton: false,
                    timer: 1700
                }).then(function(){
                    location.reload();
                });
         }
      });
    }


    $(document).on("click", "#tbjenissurat tbody tr td #btnDelete", function (e) {
      e.preventDefault();
      var table = $('#tbjenissurat').DataTable();
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
            
            let url = 'jenissurat/' + data[1];
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


});
</script>
@stop

@section('footer')
    <h1></h1>
@stop
