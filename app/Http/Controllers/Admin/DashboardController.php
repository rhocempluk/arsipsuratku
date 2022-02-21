<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\User;
use App\JenisSurat;
use App\Disposisi;
use App\SuratMasuk;
use App\SuratKeluar;

class DashboardController extends Controller
{
    public function index()
    {
        $jmluser = User::count();
        //$user = User::all();

        $jenis = JenisSurat::count();

        $jmldispo = Disposisi::count();

        $srtmasuk = SuratMasuk::count();

        $srtkeluar = SuratKeluar::count();

       return view('esurat.superadmin.dashboard', compact(['jmluser', 'jenis','jmldispo','srtmasuk','srtkeluar']));
       // return response()->json([$jmluser,$jenis]);
    }
}
