<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tamu;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function authIndex()
    { {
            $users = User::all(); // Mengambil semua data pengguna
            return view('admin.auth.index', compact('users')); // Pastikan nama view benar
        }
    }
    public function authTambah()
    {
        $user = User::all();
        return view('admin.auth.auth-formTambah');
    }
    public function authSimpan(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->role = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Disimpan');
    }
    public function authEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.auth.auth-formEdit', compact('user'));
    }

    public function authUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->telepon = $request->telepon;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Diperbarui');
    }

    public function authHapus(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        $user->delete();

        return redirect(route('admin.akun'))->with('status', 'Data Berhasil Dihapus');
    }

    public function dataTamu()
    {
        $data = Tamu::all();
        return view('admin.tamu.index', compact('data'));
    }

    public function simpanData(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'instansi' => 'nullable',
            'email' => 'nullable|email',
            'keperluan' => 'required',
            'date' => 'required|date',
        ]);

        Tamu::create($request->all());

        return redirect()->route('admin.index')->with('status', 'Data tamu berhasil ditambahkan!');
    }

    public function updateTamu(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'telepon' => 'required',
            'alamat' => 'required',
            'instansi' => 'nullable',
            'email' => 'nullable|email',
            'keperluan' => 'required',
            'date' => 'required|date',
        ]);

        $tamu = Tamu::findOrFail($request->id);
        $tamu->update($request->all());

        return redirect()->route('admin.tamu')->with('status', 'Data tamu berhasil diperbarui!');
    }

    public function hapusTamu(Request $request)
    {
        $tamu = Tamu::findOrFail($request->id);
        $tamu->delete();

        return redirect()->route('admin.tamu')->with('status', 'Data tamu berhasil dihapus!');
    }

    public function filterData(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = Tamu::query();

        if ($filter == 'harian') {
            $query->whereDate('date', $tanggal);
        } elseif ($filter == 'mingguan') {
            $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter == 'bulanan') {
            $query->whereMonth('date', date('m', strtotime($tanggal)))
                ->whereYear('date', date('Y', strtotime($tanggal)));
        } elseif ($filter == 'tahunan') {
            $query->whereYear('date', date('Y', strtotime($tanggal)));
        }

        $data = $query->get();

        session(['filter' => $filter, 'tanggal' => $tanggal]);

        return view('admin.tamu.index', compact('data'));
    }


    //form report
    public function reportdataTamu()
    {
        $data = Tamu::all();
        return view('admin.tamu.report', compact('data'));
    }
    public function reportfilterData(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = Tamu::query();

        if ($filter == 'harian') {
            $query->whereDate('date', $tanggal);
        } elseif ($filter == 'mingguan') {
            $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter == 'bulanan') {
            $query->whereMonth('date', date('m', strtotime($tanggal)))
                ->whereYear('date', date('Y', strtotime($tanggal)));
        } elseif ($filter == 'tahunan') {
            $query->whereYear('date', date('Y', strtotime($tanggal)));
        }

        $data = $query->get();

        session(['filter' => $filter, 'tanggal' => $tanggal]);

        return view('admin.tamu.report', compact('data'));
    }

    public function cetakPDF(Request $request)
    {
        $filter = $request->filter;
        $tanggal = $request->tanggal;

        $query = Tamu::query();

        if ($filter == 'harian') {
            $query->whereDate('date', $tanggal);
        } elseif ($filter == 'mingguan') {
            $query->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter == 'bulanan') {
            $query->whereMonth('date', date('m', strtotime($tanggal)))
                ->whereYear('date', date('Y', strtotime($tanggal)));
        } elseif ($filter == 'tahunan') {
            $query->whereYear('date', date('Y', strtotime($tanggal)));
        }

        $data = $query->get();

        $pdf = Pdf::loadView('admin.tamu.formCetakPDF', compact('data', 'tanggal'));
        // $pdf->setOption('isRemoteEnabled', true);
        return $pdf->stream('data-tamu.pdf');
    }


}


