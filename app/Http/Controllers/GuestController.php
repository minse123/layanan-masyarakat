<?php

namespace App\Http\Controllers;
use App\Models\Tamu;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\MasterSurat;
use App\Models\SuratProses;
use App\Models\MasterKonsultasi;
use App\Models\KonsultasiPending;



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
        Alert::success('Selamat', 'Data Berhasil Disimpan');
        return back()->with('status', 'Data Berhasil Disimpan');
    }

    public function storeSurat(Request $request)
    {
        // dd($request->all());
        // Validasi input
        $request->validate([
            'nomor_surat' => 'required|string|max:255|unique:master_surat,nomor_surat',
            'tanggal_surat' => 'required|date',
            'perihal' => 'nullable|string|max:255',
            'pengirim' => 'required|string|max:255',
            'telepon' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'catatan_proses' => 'nullable|string',
            'id_user' => 'nullable|exists:users,id',
            'file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);
        // dd($request->all());
        // Menyimpan file dan mendapatkan path
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            \Log::info('File uploaded: ' . $filePath); // Log file path
        }

        // Membuat entri di MasterSurat
        $surat = MasterSurat::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'perihal' => $request->perihal,
            'pengirim' => $request->pengirim,
            'telepon' => $request->telepon,
            'status' => 'Proses',
            'keterangan' => null,
            'id_user' => null,
            'file_path' => $filePath,
        ]);


        if ($surat) {
            // Langsung masuk ke proses
            SuratProses::create([
                'id_surat' => $surat->id_surat,
                'tanggal_proses' => now(),
                'catatan_proses' => $request->catatan_proses,
            ]);

        }

        Alert::success('Selamat', 'Data Berhasil Disimpan');
        return back()->with('status', 'Data Berhasil Disimpan');
    }

    public function storeKonsultasi(Request $request)
    {
        // Validate input
        $request->validate([
            'nama' => 'required|string|max:255',
            'telepon' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'judul_konsultasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        // Save consultation data
        $konsultasi = MasterKonsultasi::create($request->all());

        // Save pending consultation data
        KonsultasiPending::create([
            'id_konsultasi' => $konsultasi->id_konsultasi,
            'tanggal_pengajuan' => now(),
        ]);
        Alert::success('Selamat', 'Konsultasi Berhasil Diajukan');
        return back()->with('status', 'Data Berhasil Disimpan');
    }

}

