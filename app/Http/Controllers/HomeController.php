<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
//use App\JenisSurat;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function index()
     {
         //$user = User::all();
         //return view('esurat.superadmin.list', compact('user'));
         return view('esurat.superadmin.dashboard');
     }
   
     /**
      * Show the application dashboard.
      *
      * @return \Illuminate\Contracts\Support\Renderable
      */
     public function userHome()
     {
        //$user = Jenis::all();
         //return view('admin.user.list', compact('user'));
         return view('esurat.user.dashboard');
     }
}
