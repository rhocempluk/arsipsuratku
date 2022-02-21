<style>
.ttd
{
  margin-left: 500px;
  font-size: 14px;
}

.my_image
{
    background:URL('image/kopcabdin.png');
    width: 400px;
    height: 101px;
    margin-left: 140px;
}

body { 
                text-align:center; 
            }
#disposisi {
  font-family: Arial, Helvetica, sans-serif;
  font-size: 14px;
  border-collapse: collapse;
  width: 100%;
}

#disposisi td, #disposisi th {
  /* border: 1px solid #ddd; */
  padding: 8px;
}

/* #disposisi tr:nth-child(even){background-color: #f2f2f2;}

#disposisi tr:hover {background-color: #ddd;} */

#disposisi th {
  padding-top: 8px;
  padding-bottom: 8px;
  text-align: left;
  color: black;
}
</style>
<div class="my_image"></div>
<hr \>
<h4>LEMBAR DISPOSISI SURAT</h4>
<table id="disposisi">
<thead>
 
</thead>
  <tbody>
  @foreach($dispo as $dt)
        <tr>
          <th width="30%">No. Surat</th>
          <td> : {{ $dt->suratmasuk->no_surat }} </td>
        </tr>
        <tr>
          <th>Tanggal Surat</th>
          <td> : {{ $dt->suratmasuk->tgl_surat }} </td>
        </tr>
        <tr>
          <th>Pengirim</th>
          <td> : {{ $dt->suratmasuk->pengirim }} </td>
        </tr>
        <tr>
          <th>Sifat</th>
          <td> : {{ $dt->suratmasuk->sifat }} </td>
        </tr>
        <tr>
          <th>Perihal</th>
          <td> : {{ $dt->suratmasuk->perihal }} </td>
        </tr>
        <tr>
          <th>Tujuan Disposisi</th>
          <td> : {{ $dt->suratmasuk->status_dispo }} </td>
        </tr>
        <tr>
          <th>Isi Disposisi</th>
          <td> : {{ $dt->isi }} </td>
        </tr>
    @endforeach
  </tbody>
  <div class="ttd">
  <br>
  <br>
    Jombang, {{ date('d-m-Y') }} <br>
    Kacabdin Kab. Jombang<br>
    <br>
    <br>
    <br>
    <br>
    Drs. Trisilo Budi Prasetyo, M.M<br>
    Pembina Tingkat I <br>
    NIP. 19651015 199302 1 002
</div>
</table>
