<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Datatables;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    public function getUser()
    {

            $user = User::orderBy('created_at', 'DESC')->get();
            return view('esurat.superadmin.list', compact('user', $user));
            return response()->json($user);

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

        //$user = User::create($request->all());


        $user = User::create([
            'name'                   => $request->name,
            'email'                  => $request->email,
            'password'               => Hash::make($request->password),
            'role'                   => $request->role
            // 'email_verified_at'      => $request->email_verified_at,
            // 'remember_token'         => $request->remember_token,
            // 'created_at'             => $request->created_at,
            // 'updated_at'             => $request->updated_at

        ]);
        return response()->json($request->name . $request->email);

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

        $user = User::find($id);
        return response()->json($user);
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
        $user = User::find($id);
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->password = Hash::make($request->get('password'));
        $user->role     = $request->role;
        $user->save();
        return response()->json('sukses');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return response()->json('success');
    }

}
