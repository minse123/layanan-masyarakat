<?php

namespace App\Http\Controllers\ConfigurationController;

use App\Models\JadwalPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalPelatihanController
{
    public function index()
    {
        \Log::info('Testing logging functionality.');
        $data = JadwalPelatihan::all();
        return view('admin.configuration.jadwal-pelatihan', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelatihan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_pelatihan' => 'required|string',
            'file_path' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->except(['_token', '_method', 'jenis_pelatihan']);

        // Process jenis_pelatihan
        $jenis_pelatihan = $request->input('jenis_pelatihan');
        if ($jenis_pelatihan) {
            $parts = explode('_', $jenis_pelatihan, 2);
            if (count($parts) == 2) {
                $type = $parts[0];
                $value = $parts[1];
                if ($type === 'inti') {
                    $data['pelatihan_inti'] = $value;
                    $data['pelatihan_pendukung'] = null;
                } elseif ($type === 'pendukung') {
                    $data['pelatihan_pendukung'] = $value;
                    $data['pelatihan_inti'] = null;
                }
            }
        }

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filename = 'pelatihan/' . time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public', $filename);
            $data['file_path'] = $filename;
        }

        JadwalPelatihan::create($data);

        Alert::success('Selamat', 'Jadwal Pelatihan berhasil ditambahkan.');
        return redirect()->route('admin.jadwal-pelatihan.index');
    }

    public function update(Request $request, $id)
    {
        // Log the start of the update process
        \Log::info("Starting update process for JadwalPelatihan with ID: {$id}");

        $validator = Validator::make($request->all(), [
            'nama_pelatihan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_pelatihan' => 'required|string',
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            \Log::warning("Validation failed for JadwalPelatihan with ID: {$id}", $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $jadwal = JadwalPelatihan::findOrFail($id);
        $data = $request->except(['_token', '_method', 'jenis_pelatihan']);

        // Process jenis_pelatihan
        $jenis_pelatihan = $request->input('jenis_pelatihan');
        if ($jenis_pelatihan) {
            $parts = explode('_', $jenis_pelatihan, 2);
            if (count($parts) == 2) {
                $type = $parts[0];
                $value = $parts[1];
                if ($type === 'inti') {
                    $data['pelatihan_inti'] = $value;
                    $data['pelatihan_pendukung'] = null;
                } elseif ($type === 'pendukung') {
                    $data['pelatihan_pendukung'] = $value;
                    $data['pelatihan_inti'] = null;
                }
            }
        }

        if ($request->hasFile('file_path')) {
            // Log file upload attempt
            \Log::info("File upload detected for JadwalPelatihan with ID: {$id}");

            // Hapus file lama jika ada
            if ($jadwal->file_path) {
                Storage::delete($jadwal->file_path);
                \Log::info("Old file deleted for JadwalPelatihan with ID: {$id}");
            }

            $file = $request->file('file_path')->store('pelatihan', 'public');
            $jadwal->file_path = $file;
            $jadwal->save();
            $data['file_path'] = $file;

            \Log::info("New file uploaded for JadwalPelatihan with ID: {$id}, Filename: {$file}");
        } else {
            $data['file_path'] = $jadwal->file_path;
        }

        $jadwal->update($data);
        \Log::info("JadwalPelatihan with ID: {$id} updated successfully.");

        Alert::success('Selamat', 'Jadwal Pelatihan berhasil diperbarui.');
        return redirect()->route('admin.jadwal-pelatihan.index');
    }


    public function destroy($id)
    {
        $jadwal = JadwalPelatihan::findOrFail($id);

        // Delete associated file if it exists
        if ($jadwal->file_path && Storage::disk('public')->exists($jadwal->file_path)) {
            Storage::disk('public')->delete($jadwal->file_path);
        }

        $jadwal->delete();

        Alert::success('Selamat', 'Jadwal Pelatihan berhasil dihapus.');
        return redirect()->route('admin.jadwal-pelatihan.index');
    }



    public function showFile($filename)
    {
        // Log the attempt to show the file
        \Log::info("Attempting to show file: {$filename}");

        if (!Storage::disk('public')->exists($filename)) {
            \Log::error("File not found: {$filename}");
            abort(404);
        }

        $path = Storage::disk('public')->path($filename);
        \Log::info("File found, serving file: {$path}");

        return response()->file($path);
    }



}
