<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Datatables;
use App\SuratMasuk;
use App\SuratKeluar;
use App\Disposisi;
use App\User;

class SuratMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }


    public function getsuratmasuk(){

        $suratmsk= SuratMasuk::orderBy('created_at', 'DESC')->get();

        $user = auth()->user()->role;
        return view('esurat.superadmin.suratmasuk', compact(['suratmsk', 'user']));

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
        
     }

     public function simpan(Request $request)
      {
             // return response()->json($request->all());
             // $validation = Validator::make($request->all(), [
             //     'select_file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
             // ]);
     
             if ($request->hasFile('gbrlampiran')){
                 $request->validate([
                     'no_surat'    =>  'required',
                     'tgl_surat'   =>  'required',
                     'tgl_diterima'=>  'required',
                     'gbrlampiran'    =>  'required|mimes:jpeg,png,jpg,doc,docx,pdf,zip|max:2048',
                 ]);
     
                 $imageName = time() . '.' . $request->gbrlampiran->extension();
                 //getClientOriginalName();
                 $request->gbrlampiran->move(public_path('upload'), $imageName);
     
                 $suratmsk = SuratMasuk::create([
                             'no_surat'      => $request->no_surat,
                             'tgl_surat'     => $request->tgl_surat,
                             'tgl_diterima'  => $request->tgl_diterima,
                             'kode_surat'    => $request->kode_surat,
                             'sifat'         => $request->sifat,
                             'pengirim'      => $request->pengirim,
                             'perihal'       => $request->perihal,
                             'lampiran'      => $imageName
                 ]);
               }
               //return response()->json($suratmsk);
               return redirect('viewsuratmasuk');
        }

    /**
     * Display the specified resource.
     *
     * @param  \App\SuratMasuk  $suratMasuk
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $suratmasuk = SuratMasuk::find($id);
        return response()->json($suratmasuk);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SuratMasuk  $suratMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $suratmasuk = SuratMasuk::find($id);
        return response()->json($suratmasuk);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SuratMasuk  $suratMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SuratMasuk  $suratMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $suratmasuk = SuratMasuk::find($id)->delete();
        return response()->json('success');
    }

    public function tampilsuratmasuk($idsurat)
    {
      //$dispo=Disposisi::with('suratmasuk')->where('id_suratmasuk', $idsurat)->get();
      //$dispo = SuratMasuk::find($idsurat);
     $dispo=SuratMasuk::join('disposisis','disposisis.id_suratmasuk', '=' , 'surat_masuks.id')
       ->where('disposisis.id_suratmasuk', $idsurat)->get();
 
     // $dispo=SuratMasuk::where('id_suratmasuk', $idsurat)->get();
      return response()->json($dispo);
    }

    public function ubah(Request $request, $id)
    {

        if ($request->hasFile('gbrlampiran')){
            echo "ini dijalankan";
            $request->validate([
                'no_surat'    =>  'required',
                'tgl_surat'   =>  'required',
                'gbrlampiran' => 'required|mimes:jpeg,png,jpg,doc,docx,pdf,zip|max:2048',
            ]);

            $imageName = time() . '.' . $request->gbrlampiran->extension();
            $request->gbrlampiran->move(public_path('upload'), $imageName);

            $suratmasuk = SuratMasuk::find($id);
            $suratmasuk->no_surat    = $request->no_surat;
            $suratmasuk->tgl_surat    = $request->tgl_surat;
            $suratmasuk->tgl_diterima  = $request->tgl_diterima;
            $suratmasuk->kode_surat    = $request->kode_surat;
            $suratmasuk->sifat         = $request->sifat;
            $suratmasuk->pengirim      = $request->pengirim;
            $suratmasuk->perihal       = $request->perihal;
            $suratmasuk->lampiran     = $imageName;
            $suratmasuk->save();
            
        }else {
            $suratmasuk = SuratMasuk::find($id);
            $suratmasuk->no_surat    = $request->no_surat;
            $suratmasuk->tgl_surat    = $request->tgl_surat;
            $suratmasuk->tgl_diterima  = $request->tgl_diterima;
            $suratmasuk->kode_surat    = $request->kode_surat;
            $suratmasuk->sifat         = $request->sifat;
            $suratmasuk->pengirim      = $request->pengirim;
            $suratmasuk->perihal       = $request->perihal;
            $suratmasuk->lampiran     = $suratmasuk->lampiran;
            $suratmasuk->save();
        }
        return redirect('viewsuratmasuk');
    }

    public function ubahstatus(Request $request)
    {
        $suratmasuk = SuratMasuk::where("id","=",$request->id_suratmasuk)->update(["status_dispo" => $request->status_dispo]);
        // $suratmasuk->status_dispo = "Sudah Didisposisi";
        // $suratmasuk->save();
        return response()->json($request->all());
    }
}
