<?php

namespace App\Http\Controllers;
use App\Models\Tamu;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $data = Tamu::all();
        return view('guest.buku-tamu', compact('data'));
    }

    public function simpanData(Request $request)
    {
        $nama = $request->nama;
        $telepon = $request->telepon;
        $instansi = $request->instansi;
        $alamat = $request->alamat;
        $telepon = $request->telepon;
        $email = $request->email;
        $keperluan = $request->keperluan;

        // dd($nama, $telepon, $alamat, $email);

        $data = new Tamu();
        $data->nama = $nama;
        $data->telepon = $telepon;
        $data->instansi = $instansi;
        $data->alamat = $alamat;
        $data->email = $email;
        $data->keperluan = $keperluan;



        $data->save();

        return redirect(url('buku-tamu'))->with('status', 'Data Berhasil Disimpan');
    }

}

