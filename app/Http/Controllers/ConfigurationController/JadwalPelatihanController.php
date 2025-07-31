<?php

namespace App\Http\Controllers\ConfigurationController;

use App\Models\JadwalPelatihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

use Barryvdh\DomPDF\Facade\Pdf;

class JadwalPelatihanController
{
    public function index(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $query = JadwalPelatihan::query();

        if ($request->has('jenis_pelatihan') && $request->jenis_pelatihan != '') {
            $jenis_pelatihan = $request->jenis_pelatihan;
            $parts = explode('_', $jenis_pelatihan, 2);
            if (count($parts) == 2) {
                $type = $parts[0];
                $value = $parts[1];
                if ($type === 'inti') {
                    $query->where('pelatihan_inti', $value);
                } elseif ($type === 'pendukung') {
                    $query->where('pelatihan_pendukung', $value);
                }
            }
        }

        $data = $query->get();
        return view('admin.configuration.jadwal-pelatihan', compact('data', 'layout'));
    }

    public function store(Request $request)
    {
        // Log::info('JadwalPelatihanController@store: Received request', ['request' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'nama_pelatihan' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'jenis_pelatihan' => 'required|string',
            'file_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            // Log::error('JadwalPelatihanController@store: Validation failed', ['errors' => $validator->errors()]);
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
            $file = $request->file('file_path')->store('pelatihan', 'public');
            $data['file_path'] = $file;
            // Log::info('JadwalPelatihanController@store: File uploaded', ['filename' => $file]);
        } else {
            $data['file_path'] = null;
        }

        // Log::info('JadwalPelatihanController@store: Creating new JadwalPelatihan', ['data' => $data]);

        JadwalPelatihan::create($data);

        // Log::info('JadwalPelatihanController@store: JadwalPelatihan created successfully');

        Alert::success('Selamat', 'Jadwal Pelatihan berhasil ditambahkan.');
        return redirect()->route('admin.jadwal-pelatihan.index');
    }

    public function update(Request $request, $id)
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
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            
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
        // Ensure the filename has the 'pelatihan/' prefix if it's missing
        if (strpos($filename, 'pelatihan/') !== 0) {
            $filename = 'pelatihan/' . $filename;
        }

        if (!Storage::disk('public')->exists($filename)) {
            abort(404);
        }

        $path = Storage::disk('public')->path($filename);

        return response()->file($path);
    }



}
