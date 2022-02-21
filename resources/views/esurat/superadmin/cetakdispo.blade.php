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
  border-collapse: collapse;
  width: 100%;
}

#disposisi td, #disposisi th {
  border: 1px solid #ddd;
  padding: 8px;
}

#disposisi tr:nth-child(even){background-color: #f2f2f2;}

#disposisi tr:hover {background-color: #ddd;}

#disposisi th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #4CAF50;
  color: white;
}
</style>
<div class="my_image"></div>
<hr />
<h4>LAPORAN DISPOSISI</h4>
<table id="disposisi">
  <thead>
  <tr>
              <th>No</th>
              <th>Id</th>
              <th>No. Surat</th>
              <th>Tanggal Disposisi</th>
              <th>Isi Disposisi</th>
            </tr>
  </thead>
  <tbody>
    @php
        $i = 1;
    @endphp

    @foreach($dispo as $dt)
        <tr>
            <td> {{ $i++ }} </td>
            <td> {{ $dt->id }} </td>
            <td> {{ $dt->suratmasuk->no_surat }} </td>
            <td> {{ $dt->tgl_disposisi }} </td>
            <td> {{ $dt->isi}} </td>
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
    .......................<br>
    NIP
  </div>
</table>