<?php

namespace App\Http\Controllers\SoalController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JawabanPeserta;
use App\Models\KategoriSoalPelatihan;
use App\Models\User;
use App\Models\SoalPelatihan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RekapNilaiController
{
    public function index(Request $request)
    {
        $layout = match (auth()->user()->role) {
            'admin', 'psm', 'kasubag', 'operator' => 'admin.layouts.app',
            default => 'layouts.default',
        };
        $kategoriList = KategoriSoalPelatihan::all();
        $pesertaList = User::whereHas('jawabanPeserta')->get();
        $users = User::where('role', 'masyarakat')->get();

        $rekapList = collect();
        $selectedKategoriId = $request->input('kategori_id');

        $filteredKategoriList = $kategoriList;
        if ($selectedKategoriId) {
            $filteredKategoriList = $kategoriList->where('id', $selectedKategoriId);
        }

        foreach ($pesertaList as $peserta) {
            foreach ($filteredKategoriList as $kategori) {
                $soalIds = SoalPelatihan::where('id_kategori_soal_pelatihan', $kategori->id)->pluck('id');

                if ($soalIds->isEmpty()) {
                    continue;
                }

                $jawaban = JawabanPeserta::where('id_user', $peserta->id)
                    ->whereIn('id_soal', $soalIds)
                    ->get();

                $jumlahSoal = $soalIds->count();
                $jumlahBenar = $jawaban->where('benar', 1)->count();
                $jumlahSalah = $jumlahSoal - $jumlahBenar;
                $skor = $jumlahSoal > 0 ? round(($jumlahBenar / $jumlahSoal) * 100) : 0;

                if ($jawaban->count() > 0) {
                    $rekapList->push((object) [
                        'id' => $peserta->id . '-' . $kategori->id, // Composite ID for reference
                        'user' => $peserta,
                        'kategori' => $kategori,
                        'total_soal' => $jumlahSoal,
                        'benar' => $jumlahBenar,
                        'salah' => $jumlahSalah,
                        'nilai' => $skor,
                        'created_at' => $jawaban->first()->created_at,
                    ]);
                }
            }
        }

        // Sort by created_at desc
        $rekapList = $rekapList->sortByDesc('created_at');

        return view('admin.soal.rekap-nilai', [
            'layout' => $layout,
            'rekapList' => $rekapList,
            'users' => $users,
            'kategoriList' => $kategoriList,
            'selectedKategoriId' => $selectedKategoriId
        ]);
    }

    private function saveJawaban(Request $request, $userId)
    {
        try {
            DB::beginTransaction();

            // Hapus jawaban lama jika ada
            $soalIds = collect($request->jawaban)->pluck('id_soal');
            JawabanPeserta::where('id_user', $userId)
                ->whereIn('id_soal', $soalIds)
                ->delete();

            // Simpan jawaban baru
            $jawabanData = [];
            foreach ($request->jawaban as $jawaban) {
                $soal = SoalPelatihan::find($jawaban['id_soal']);
                $jawabanData[] = [
                    'id_user' => $userId,
                    'id_soal' => $jawaban['id_soal'],
                    'jawaban_peserta' => $jawaban['jawaban_peserta'],
                    'benar' => $jawaban['jawaban_peserta'] === $soal->jawaban_benar ? 1 : 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            JawabanPeserta::insert($jawabanData);
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            // Log the error or handle it as needed
            return false;
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|exists:users,id',
            'id_kategori' => 'required|exists:kategori_soal_pelatihan,id',
            'jawaban' => 'required|array',
            'jawaban.*.id_soal' => 'required|exists:soal_pelatihan,id',
            'jawaban.*.jawaban_peserta' => 'required|string|in:a,b,c,d',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($this->saveJawaban($request, $request->id_user)) {
            return redirect()->route('admin.rekap-nilai.index')
                ->with('success', 'Jawaban berhasil disimpan.');
        }

        return redirect()->back()
            ->with('error', 'Terjadi kesalahan saat menyimpan jawaban.')
            ->withInput();
    }

    public function update(Request $request, $id)
    {
        // Parse composite ID
        list($userId, $kategoriId) = explode('-', $id);

        $validator = Validator::make($request->all(), [
            'jawaban' => 'required|array',
            'jawaban.*.id_soal' => 'required|exists:soal_pelatihan,id',
            'jawaban.*.jawaban_peserta' => 'required|string|in:a,b,c,d',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        if ($this->saveJawaban($request, $userId)) {
            return redirect()->route('admin.rekap-nilai.index')
                ->with('success', 'Jawaban berhasil diperbarui.');
        }

        return redirect()->back()
            ->with('error', 'Terjadi kesalahan saat memperbarui jawaban.')
            ->withInput();
    }

    public function destroy($id)
    {
        try {
            // Parse composite ID
            list($userId, $kategoriId) = explode('-', $id);

            // Dapatkan semua soal dalam kategori
            $soalIds = SoalPelatihan::where('id_kategori_soal_pelatihan', $kategoriId)
                ->pluck('id');

            // Hapus semua jawaban peserta untuk soal-soal dalam kategori tersebut
            JawabanPeserta::where('id_user', $userId)
                ->whereIn('id_soal', $soalIds)
                ->delete();

            return redirect()->route('admin.rekap-nilai.index')
                ->with('success', 'Rekap nilai berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function getByKategori($kategoriId, Request $request)
    {
        try {
            $soalList = SoalPelatihan::where('id_kategori_soal_pelatihan', $kategoriId)
                ->orderBy('id')
                ->get();

            $jawabanPeserta = [];
            if ($request->has('rekap_id')) {
                // Parse the composite ID (user_id-kategori_id)
                list($userId, $kategoriId) = explode('-', $request->rekap_id);

                $jawabanPeserta = JawabanPeserta::where('id_user', $userId)
                    ->whereIn('id_soal', $soalList->pluck('id'))
                    ->pluck('jawaban_peserta', 'id_soal')
                    ->toArray();
            }

            return view('admin.soal.partials.soal-options', [
                'soalList' => $soalList,
                'jawabanPeserta' => $jawabanPeserta
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memuat soal: ' . $e->getMessage()
            ], 500);
        }
    }
}
