<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Datatables;
use App\JenisSurat;


class JenisSuratController extends Controller
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


    public function getsurat()
    {

            $surat = JenisSurat::orderBy('created_at', 'DESC')->get();
            return view('esurat.superadmin.jenisSurat', compact('surat', $surat));
            return response()->json($surat);

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
        $surat = JenisSurat::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JenisSurat  $jenisSurat
     * @return \Illuminate\Http\Response
     */
    public function show(JenisSurat $jenisSurat)
    {
        //
    }

    public function showjenissurat()
    {
        $showsurat = JenisSurat::all();
        return response()->json($showsurat);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JenisSurat  $jenisSurat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $surat = JenisSurat::find($id);
        return response()->json($surat);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JenisSurat  $jenisSurat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $surat = JenisSurat::find($id);
        $surat->kode_surat     = $request->kode_surat;
        $surat->nama_surat    = $request->nama_surat;
        $surat->save();
        return response()->json('sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JenisSurat  $jenisSurat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $surat = JenisSurat::find($id)->delete();
        return response()->json('success');
    }
}
