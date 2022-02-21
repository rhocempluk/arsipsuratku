<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\SuratMasuk;
use Datatables;
use PDF;


class ReportMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('esurat.superadmin.reportmasuk');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getdata(Request $request)
    {
        $bagian= $request->bagian;
        $tglawal= $request->tglawal;
        $tglakhir= $request->tglakhir;

        if($bagian == 'Semua Bagian'){
            $data = SuratMasuk::whereBetween('tgl_surat',[$tglawal, $tglakhir])
            ->get();
            //return response()->json(['data' => $data]);
        }else{
            $data = SuratMasuk::where('status_dispo','=',$bagian)
            ->whereBetween('tgl_surat',[$tglawal, $tglakhir])
            ->get();
            //return response()->json(['data' => $data]);
        }
    }


    public function getreport(Request $request)
    {
        $bagian= $request->bagian;
        $tglawal= $request->tglawal;
        $tglakhir= $request->tglakhir;

        
       //return response()->json($request->all());
        
        if($bagian == 'Semua Bagian'){

            $data = SuratMasuk::whereBetween('tgl_surat',[$tglawal, $tglakhir])
            ->get();
            
            $pdf = PDF::loadView('esurat.superadmin.cetakreportmasuk',compact('data',$data) );
            return $pdf->stream();

        }else{
            $data = SuratMasuk::where('status_dispo','=',$bagian)
            ->whereBetween('tgl_surat',[$tglawal, $tglakhir])
            ->get();
            
            $pdf = PDF::loadView('esurat.superadmin.cetakreportmasuk',compact('data',$data) );
            return $pdf->stream();          
        }
    }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
