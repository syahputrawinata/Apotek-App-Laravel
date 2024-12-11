<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{

    //-r : resource : membuat method/func untuk CRUD nya
    // mengambil banyak data/ menampilkan halaman awal (CRUD : R all)
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //prosess pemanggilan file blade
        return view('landing-page');
    }

    /**
     * Show the form for creating a new resource.
     */
    // menampilkan form tambah data
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    //menambahkan data ke database/ mengirim data dari form create
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    // menampilkan hanya satu data (detail data)
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    // menampilkan halaman untuk edit data
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    //mengubah data di database / memproses data dari form edit
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    // menghapus data di database
    public function destroy(string $id)
    {
        //
    }
}
