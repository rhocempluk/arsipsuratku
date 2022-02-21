@extends('adminlte::page')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
@stop

@section('title', 'Manajemen Data Bagian')

{{-- @section('content_header') --}}

{{-- @stop --}}


@section('content')

  <div class="card">
        <div class="card-header">
                <h3 class="card-title" >DATA UNIT BAGIAN</h3>
                 @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          <a class="btn btn-primary float-right" id="btntambah" href="" title="Tambah Bagian"><i class="fa fa-plus-circle"> </i> Tambah Bagian</a>
        </div>

        <div class="card-body">

          <table id="tbbagian" class="table table-hover">
            <thead>
            <tr>
              <th>No</th>
              <th>Id</th>
              <th>Kode Bagian</th>
              <th>Nama Bagian</th>
              <th>Aksi</th>
            </tr>
            </thead>

            <tbody id="dynamictable">
            @php
               $i = 1;
            @endphp
            @foreach($bagian as $dt)
                <tr>
                  <td> {{ $i++ }} </td>
                  <td class="nr" scope="row"> {{ $dt->id }} </td>
                  <td> {{ $dt->kd_bagian }} </td>
                  <td> {{ $dt->nama_bagian }} </td>
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
                    <input type="hidden" name="idbagian" id="idbagian">
                                      <div class="form-group">
                                      <label>Kode Bagian</label>
                                      <input type="text" class="form-control" id="kd_bagian">
                                    </div>
                                    <div class="form-group">
                                            <label>Nama Bagian</label>
                                            <input type="text" class="form-control" id="nama_bagian">
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
        var table = $('#tbbagian').DataTable();
        table.column(1).visible( false );
    });

    $('#btntambah').click(function (e) {
        e.preventDefault();
        //console.log('dipencet');
        $('#modalUtama').modal('show');
        $('#crudmodal').html("TAMBAH UNIT BAGIAN");
        $('.modal-body').find('textarea,input').val('');
        $('#btnSimpan').html('Simpan');

    });

    $('#btnSimpan').click(function (e) {
         e.preventDefault();
         if ($('#btnSimpan').html()=='Simpan'){
           //alert('simpan');
           simpanBagian();
         }else{
           //alert('ubah');
           ubahBagian();
         }
    });

    function simpanBagian(){
        let kd_bagian = $('#kd_bagian').val();
        let nama_bagian =  $('#nama_bagian').val();

        $.ajax({
            type: "POST",
            url: "unitbagian",
            data: {
                kd_bagian:kd_bagian,
                nama_bagian:nama_bagian
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

    function ubahBagian(){
      let url ='unitbagian/' + $('#idbagian').val();
      //alert(url);
      let kd_bagian = $('#kd_bagian').val();
      let nama_bagian =  $('#nama_bagian').val();

      $.ajax({
          type: "PUT",
          url: url,
          data: {
                kd_bagian:kd_bagian,
                nama_bagian:nama_bagian
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


    $(document).on("click", "#tbbagian tbody tr td #btnEdit", function (e) {
      e.preventDefault();
      $('#modalUtama').modal('show');
      $('#crudmodal').html("UBAH UNIT BAGIAN");
      $('#btnSimpan').html('Ubah');
    

      // let $row = $(this).closest("tr");
      // let $text = $row.find(".nr").text();
      var table = $('#tbbagian').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
    
      let url ='unitbagian/' + data[1] + '/edit';

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
          $('#idbagian').val(response.id);
          $('#kd_bagian').val(response.kd_bagian);
          $('#nama_bagian').val(response.nama_bagian);
          $('#tbbagian tbody').append(isi);
        }
      });
    });

    $(document).on("click", "#tbbagian tbody tr td #btnDelete", function (e) {
      e.preventDefault();
      var table = $('#tbbagian').DataTable();
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
            
            let url = 'unitbagian/' + data[1];
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
