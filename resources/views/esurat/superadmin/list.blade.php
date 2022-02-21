@extends('adminlte::page')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
@stop

@section('title', 'Manajemen User')

{{-- @section('content_header') --}}

{{-- @stop --}}


@section('content')

  <div class="card">
        <div class="card-header">
                <h3 class="card-title" >DATA USER</h3>
                 @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
          @endif
          <a class="btn btn-primary float-right" id="btntambah" href="" title="Tambah User"><i class="fa fa-plus-circle"> </i> Tambah User</a>
        </div>

        <div class="card-body">

            {{-- <h3 align="center"><span id="total_records"></span></h3> --}}
          <table id="tbuser" class="table table-hover">
            <thead>
            <tr>
              <th>No</th>
              <th>Id</th>
              <th>Nama User</th>
              <th>Email</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
            </thead>

            <tbody id="dynamictable">
            @php
               $i = 1;
            @endphp
            @foreach($user as $dt)
                <tr>
                  <td> {{ $i++ }} </td>
                  <td class="nr" scope="row"> {{ $dt->id }} </td>
                  <td> {{ $dt->name }} </td>
                  <td> {{ $dt->email }} </td>
                  <td> {{ $dt->role}} </td>
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
                    <input type="hidden" name="iduser" id="iduser">
                                      <div class="form-group">
                                      <label>Nama</label>
                                      <input type="text" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" class="form-control" id="email">
                                    </div>
                                    <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" id="password">
                                    </div>
                                    <div class="form-group">
                                      <label for="recipient-name" class="col-form-label">Status</label>
                                      <select id="role" class="form-control">
                                            <option value="Super Admin">Super Admin</option>
                                            <option value="Admin">Admin</option>
                                      </select>
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
        // $('#tbuser').DataTable();
        var table = $('#tbuser').DataTable();
        table.column(1).visible( false );
    });

    $('#btntambah').click(function (e) {
        e.preventDefault();
        //console.log('dipencet');
        $('#modalUtama').modal('show');
        $('#crudmodal').html("TAMBAH USER");
        $('.modal-body').find('textarea,input').val('');
        $('#btnSimpan').html('Simpan');

    });

    $('#btnSimpan').click(function (e) {
         e.preventDefault();
         if ($('#btnSimpan').html()=='Simpan'){
           //alert('simpan');
           simpanUser();
         }else{
           //alert('ubah');
           ubahUser();
         }
    });

    function simpanUser(){
        let name = $('#name').val();
        console.log(name);
        let email =  $('#email').val();
        let password =  $('#password').val();
        let role =  $('#role').val();

        $.ajax({
            type: "POST",
            url: "user",
            data: {
                name:name,
                email:email,
                password:password,
                role:role
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
                //$('.modal-body').find('textarea,input').val('');
                //$('#tbuser tbody').empty();
                //window.location = "http://localhost:8000/user";
            }
        });
    }


    $(document).on("click", "#tbuser tbody tr td #btnEdit", function (e) {
      e.preventDefault();
      $('#modalUtama').modal('show');
      $('#crudmodal').html("UBAH USER");
      $('#btnSimpan').html('Ubah');
    

      // let $row = $(this).closest("tr");
      // let $text = $row.find(".nr").text();
      var table = $('#tbuser').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
      //let thisid = $(this).data('id');
      let url ='user/' + data[1] + '/edit';

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
          $('#iduser').val(response.id);
         $('#name').val(response.name);
         $('#email').val(response.email);
         $('#password').val(response.password);
         //var newpass = CryptoJS.AES.encrypt($("#password").val(),key).toString();
         //console.log(newpass);
         $('#role').val(response.role);

         $('#tbuser tbody').append(isi);
        }
      });
    });


    function ubahUser(){

      let url ='user/' + $('#iduser').val();
      //alert(url);
      let name = $('#name').val();
      let email =  $('#email').val();
      let password =  $('#password').val();
      let role =  $('#role').val();
      $.ajax({
          type: "PUT",
          url: url,
          data: {
               name:name,
               email:email,
               password:password,
               role:role
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
            //$('#tbuser tbody').empty();
            //window.location = "http://localhost:8000/user";
         }
      });
    }


    $(document).on("click", "#tbuser tbody tr td #btnDelete", function (e) {
      e.preventDefault();
      var table = $('#tbuser').DataTable();
      var data = table.row( $(this).parents('tr') ).data();
      //let $row = $(this).closest("tr");
      // var data = $row.find(".nr").map(function(){
      // return $(this).text();
      // }).get();
      console.log(data);
      //$('#iduser').val(data[0]);
     // $('#modaldelete').modal('show');
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
            //var id = $('#iduser').val();
            let url = 'user/' + data[1];
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