<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Datatables;
use App\Disposisi;
use App\SuratMasuk;
use PDF;

class DisposisiController extends Controller
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

    public function getdisposisi()
    {

            $dispo= Disposisi::orderBy('created_at', 'DESC')->get();
           //$dispo=Disposisi::with('suratmasuk')->get();

            return view('esurat.superadmin.disposisi', compact('dispo', $dispo));
            return response()->json($dispo);

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
        //$dispo = Disposisi::create($request->all());
        // $dispo = Disposisi::create([
        //     'id_suratmasuk'     => $request->id_suratmasuk,
        //     'tgl_disposisi'     => $request->tgl_disposisi,
        //     'id_bagian'         => $request->id_bagian,
        //     'isi'               => $request->isi
        // ]);
        return response()->json($request->all());
    }

    public function simpan(Request $request)
    {
           
        $dispo = Disposisi::create([
            'id_suratmasuk'     => $request->id_suratmasuk,
            'tgl_disposisi'     => $request->tgl_disposisi,
            'id_bagian'         => $request->id_bagian,
            'isi'               => $request->isi
        ]);
        return response()->json($dispo);
        //return response()->json($request->all());
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function show(Disposisi $disposisi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function edit(Disposisi $disposisi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Disposisi $disposisi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Disposisi  $disposisi
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $disposisi = Disposisi::find($id)->delete();
        return response()->json('success');
    }

    public function suratdispo($idsurat)
    {
      $dispo=Disposisi::with('suratmasuk')->where('id', $idsurat)->get();
      //$dispo=Disposisi::with('suratmasuk')->get();
      return response()->json($dispo);
    }

    public function createPDF() {

        $dispo = Disposisi::all();
  
        view()->share('dispo',$dispo);
        $pdf = PDF::loadView('esurat.superadmin.cetakdispo', compact('dispo', $dispo));
  
        // download PDF file with download method
        //return $pdf->download('pdf_dispo.pdf');
        return $pdf->stream();
      }

      public function cetakdispo($id) {
        $dispo=Disposisi::with('suratmasuk')->where('id', $id)->get();
  
   
        view()->share('dispo',$dispo);
        $pdf = PDF::loadView('esurat.superadmin.cetaklembardispo', compact('dispo', $dispo));
 
        return $pdf->stream();
        //return response()->json($dispo);
      }

      public function rubahstatus($id)
      {
          $suratmasuk = SuratMasuk::where('id',$id)->update(["status_dispo" => "Belum Didisposisi"]);
          // $suratmasuk->status_dispo = "Sudah Didisposisi";
          // $suratmasuk->save();
          return response()->json($suratmasuk);
      }
          
}
