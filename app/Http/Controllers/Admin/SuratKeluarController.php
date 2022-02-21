<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Datatables;
use App\SuratKeluar;


class SuratKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getsuratkeluar(){

        $suratkeluar= SuratKeluar::orderBy('created_at', 'DESC')->get();
        return view('esurat.superadmin.suratkeluar', compact('suratkeluar', $suratkeluar));
        return response()->json($suratkeluar);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function show(SuratKeluar $suratKeluar)
    {
        //
    }

    public function simpansuratkeluar(Request $request)
      {
     
             if ($request->hasFile('gbrlampiran')){
                 $request->validate([
                     'tgl_surat'      =>  'required',
                     'gbrlampiran'    =>  'required|mimes:jpeg,png,jpg,doc,docx,pdf,zip|max:2048',
                 ]);
     
                 $imageName = time() . '.' . $request->gbrlampiran->extension();
                 $request->gbrlampiran->move(public_path('upload'), $imageName);
     
                 $suratkeluar = SuratKeluar::create([
                             'no_suratkeluar'      => $request->kode_surat . "/" . $request->nourut . "/" . $request->kodeinstansi . "/" . $request->thnsurat,
                             'tgl_surat'           => $request->tgl_surat,
                             'pengirim'            => $request->pengirim,
                             'kepada'              => $request->kepada,
                             'sifat'               => $request->sifat,
                             'isi_surat'           => $request->isi_surat,
                             'perihal'             => $request->perihal,
                             'alamat'              => $request->alamat,
                             'ekspedisi'           => $request->ekspedisi,
                             'lampiran'            => $imageName
                 ]);
               }
               //return response()->json($suratkeluar);
               return redirect('viewsuratkeluar');
        }


        public function ubahsuratkeluar(Request $request, $id)
        {
            if ($request->hasFile('gbrlampiran')){
                echo "ini dijalankan";
                $request->validate([
                    'tgl_surat'   =>  'required',
                    'gbrlampiran' => 'required|mimes:jpeg,png,jpg,doc,docx,pdf,zip|max:2048',
                ]);
    
                $imageName = time() . '.' . $request->gbrlampiran->extension();
                $request->gbrlampiran->move(public_path('upload'), $imageName);
    
                $suratkeluar = SuratKeluar::find($id);
                $suratkeluar->no_suratkeluar    = $request->nosuratedit;
                $suratkeluar->tgl_surat         = $request->tgl_surat;
                $suratkeluar->pengirim          = $request->pengirim;
                $suratkeluar->kepada            = $request->kepada;
                $suratkeluar->sifat             = $request->sifat;
                $suratkeluar->isi_surat          = $request->isi_surat;
                $suratkeluar->perihal           = $request->perihal;
                $suratkeluar->alamat            = $request->alamat;
                $suratkeluar->ekspedisi         = $request->ekspedisi;
                $suratkeluar->lampiran          = $imageName;
                $suratkeluar->save();
                
            }else{
                $suratkeluar = SuratKeluar::find($id);
                $suratkeluar->no_suratkeluar    = $request->nosuratedit;
                $suratkeluar->tgl_surat         = $request->tgl_surat;
                $suratkeluar->pengirim          = $request->pengirim;
                $suratkeluar->kepada            = $request->kepada;
                $suratkeluar->sifat             = $request->sifat;
                $suratkeluar->isi_surat          = $request->isi_surat;
                $suratkeluar->perihal           = $request->perihal;
                $suratkeluar->alamat            = $request->alamat;
                $suratkeluar->ekspedisi         = $request->ekspedisi;
                $suratkeluar->lampiran          = $imageName;
                $suratkeluar->save();
            }
            return redirect('viewsuratkeluar');
        }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suratkeluar = SuratKeluar::find($id);
        return response()->json($suratkeluar);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SuratKeluar $suratKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SuratKeluar  $suratKeluar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $suratkeluar = SuratKeluar::find($id)->delete();
        return response()->json('success');
    }

    public function tampilsuratkeluar($idsurat)
    {
      $data=SuratKeluar::where('id', $idsurat)->get();
      return response()->json($data);
    }
}
