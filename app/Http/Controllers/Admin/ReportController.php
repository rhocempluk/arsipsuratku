<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\SuratMasuk;
use App\SuratKeluar;
use PDF;


class ReportController extends Controller
{

//    public $arr = array();
    public $arr = [];
    public $coba ='';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('esurat.superadmin.report');
    }

    public function getreport(Request $request) {

        $data = [];
        //$input = $request->all();
        // return response()->json($input);
        $kategori= $request->kategori;
        $from= $request->tglawal;
        $to= $request->tglakhir;
        $bagian= $request->bagian;
        

        if($kategori == 'Surat Masuk' && $bagian == 'Semua Bagian' ){
                $data = SuratMasuk::whereBetween('tgl_surat',[$from, $to])->get();
                //array_push($this->arr,$data);
                array_push($this->arr,'coba');
                return response()->json(['title' => 'suratmasuk', $data]);   
        }elseif($kategori == 'Surat Masuk'){
                $data = SuratMasuk::where('status_dispo','=',$bagian)
                ->whereBetween('tgl_surat',[$from, $to])
                ->get();
                // array_push($this->arr,$data);
                array_push($this->arr,'coba');
                return response()->json(['title' => 'suratmasuk', $data]);  
        }elseif($kategori == 'Surat Keluar'){
                $data = SuratKeluar::whereBetween('tgl_surat',[$from, $to])->get();
                return response()->json(['title' => 'suratkeluar', $data]);
                //array_push($this->arr,$data);  
               array_push($this->arr,'coba');
                 
        }
        $this->coba='coba';

        
    }

    public function getPDF($id) {
        //echo ('ini ditampilkan');
        //  $pdf = PDF::loadView('esurat.superadmin.cetakreportmasuk',compact('data',$data));
        //  return $pdf->stream();
       // echo $this->arr;
        echo ($id);   
        var_dump($this->arr);
        // $suratmasuk = SuratMasuk::all();
  
        
  
        // // download PDF file with download method
        // //return $pdf->download('pdf_dispo.pdf');
        // return $pdf->stream();
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
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        //
    }
}
