<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SuratMasuk;
use App\Models\MasterSurat;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class SuratController extends Controller
{
    public function Masukindex(
    ) {
        $data = SuratMasuk::with('masterSurat')->get();
        // dd($data);
        return view('admin.surat.masuk.index', compact('data'));
    }

    public function simpanData(Request $request)
    {
        $request->validate([
            'nomor_surat' => 'required|unique:master_surat,nomor_surat',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
            'disposisi' => 'nullable',
        ]);
        $masterSurat = MasterSurat::create([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'pengirim' => $request->pengirim,
            'perihal' => $request->perihal,
        ]);

        SuratMasuk::create([
            'master_surat_id' => $masterSurat->id,
            'disposisi' => $request->disposisi,
        ]);

        return redirect()->route('admin.surat-masuk')->with('status', 'Surat masuk berhasil ditambahkan!');
    }

    // Update data surat masuk
    public function updateData(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:surat_masuk,id',
            'nomor_surat' => 'required',
            'tanggal_surat' => 'required|date',
            'pengirim' => 'required',
            'perihal' => 'required',
            'tanggal_terima' => 'required|date',
            'disposisi' => 'nullable',
        ]);

        $suratMasuk = SuratMasuk::findOrFail($request->id);
        $masterSurat = MasterSurat::findOrFail($suratMasuk->master_surat_id);

        $masterSurat->update([
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'pengirim' => $request->pengirim,
            'perihal' => $request->perihal,
        ]);

        $suratMasuk->update([
            'tanggal_terima' => $request->tanggal_terima,
            'disposisi' => $request->disposisi,
        ]);

        dd($suratMasuk, $masterSurat);

        // return redirect()->route('admin.surat-masuk')->with('status', 'Surat masuk berhasil diperbarui!');
    }

    // Hapus data surat masuk
    public function hapusData(Request $request)
    {
        $suratMasuk = SuratMasuk::findOrFail($request->id);
        $masterSurat = MasterSurat::findOrFail($suratMasuk->master_surat_id);

        $suratMasuk->delete();
        $masterSurat->delete();

        return redirect()->route('admin.surat-masuk')->with('status', 'Surat masuk berhasil dihapus!');
    }

    public function filterData(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = SuratMasuk::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_surat', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_surat', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_surat', $tanggal->month)
                            ->whereYear('tanggal_surat', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_surat', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();
        session(['filter' => $filter, 'tanggal' => $tanggal]);
        // dd($request->all());
        return view('admin.surat.masuk.index', compact('data'));
    }
    public function cetakPDF(Request $request)
    {
        $filter = session('filter');
        $tanggal = session('tanggal');

        $query = SuratMasuk::query()->with('masterSurat');

        if ($filter && $tanggal) {
            $tanggal = Carbon::parse($tanggal);
            $query->whereHas('masterSurat', function ($q) use ($filter, $tanggal) {
                switch ($filter) {
                    case 'harian':
                        $q->whereDate('tanggal_surat', $tanggal);
                        break;
                    case 'mingguan':
                        $q->whereBetween('tanggal_surat', [$tanggal->startOfWeek(), $tanggal->endOfWeek()]);
                        break;
                    case 'bulanan':
                        $q->whereMonth('tanggal_surat', $tanggal->month)
                            ->whereYear('tanggal_surat', $tanggal->year);
                        break;
                    case 'tahunan':
                        $q->whereYear('tanggal_surat', $tanggal->year);
                        break;
                }
            });
        }

        $data = $query->get();

        $pdf = PDF::loadView('admin.surat.masuk.formCetakPDF', compact('data'));
        return $pdf->stream('laporan-surat-masuk.pdf');
    }
}
