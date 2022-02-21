<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Datatables;
use App\Bagian;
use App\SuratMasuk;


class BagianController extends Controller
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


    public function getbagian()
    {

            $bagian = Bagian::orderBy('created_at', 'DESC')->get();
            return view('esurat.superadmin.bagian', compact('bagian', $bagian));
            //return response()->json($surat);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bagian = Bagian::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JenisSurat  $jenisSurat
     * @return \Illuminate\Http\Response
     */


    public function showbagian()
    {
        $showbagian = Bagian::all();
        //return view('esurat.superadmin.report', compact('showbagian',$showbagian);
        return response()->json($showbagian);
    }

  
    public function edit($id)
    {
        $bagian = Bagian::find($id);
        return response()->json($bagian);
    }

 
    public function update(Request $request, $id)
    {
        $bagian = Bagian::find($id);
        $bagian->kd_bagian      = $request->kd_bagian;
        $bagian->nama_bagian    = $request->nama_bagian;
        $bagian->save();
        return response()->json('sukses');
    }


    public function destroy($id)
    {
        $bagian = Bagian::find($id)->delete();
        return response()->json('success');
    }

    public function ubahstatus(Request $request)
    {
        $suratmasuk = SuratMasuk::where("id","=",$request->id_suratmasuk)->update(["status_dispo" => $request->status_dispo]);
        // $suratmasuk->status_dispo = "Sudah Didisposisi";
        // $suratmasuk->save();
        //$suratmasuk = SuratMasuk::where("no_surat","=",$request->no_suratmasuk)->get();
        return response()->json($suratmasuk);
    }
}
