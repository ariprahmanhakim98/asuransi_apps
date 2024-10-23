<?php

namespace App\Http\Controllers;

use App\Models\Tpprd;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\KepesertaanImport;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TpprdController extends Controller
{

    public function create()
    {
        return view('tpprd.create');
    }

    public function store(Request $request)
    {
        // Validasi input dari user
        $request->validate([
            'tpprd_nama' => 'required',
            'tpprd_tanggal_lahir' => 'required|date_format:d/m/Y',
            'tpprd_bank' => 'required',
            'tpprd_masa_bulan' => 'required|integer',
            'tpprd_up' => 'required|numeric',
        ]);

        $currentYear = now()->format('y');
        $currentMonth = now()->format('m');
        $lastParticipant = Tpprd::latest()->first();
        $newNumber = $lastParticipant ? intval(substr($lastParticipant->tpprd_nomor_peserta, 6)) + 1 : 1;
        $tpprd_nomor_peserta = $currentYear . '.' . $currentMonth . '.' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

        $tanggal_lahir = Carbon::createFromFormat('d/m/Y', $request->tpprd_tanggal_lahir);
        $umur = $tanggal_lahir->diffInYears(now());

        $tanggal_awal = now();
        $tanggal_akhir = $tanggal_awal->copy()->addMonths($request->tpprd_masa_bulan);

        $tarif_per_mil = 3.88;
        $tarif = ($request->tpprd_masa_bulan / 12) * $tarif_per_mil;

        $premi = ($request->tpprd_up * $tarif) / 1000;

        // var_dump(str_pad($newNumber, 6, '0', STR_PAD_LEFT)); die();

        Tpprd::create([
            'tpprd_nomor_peserta' => $tpprd_nomor_peserta,
            'tpprd_nama' => $request->tpprd_nama,
            'tpprd_tanggal_lahir' => $tanggal_lahir->format('Y-m-d'),
            'tpprd_umur' => $umur,
            'tpprd_bank' => $request->tpprd_bank,
            'tpprd_tanggal_awal' => $tanggal_awal->format('Y-m-d'),
            'tpprd_masa_bulan' => $request->tpprd_masa_bulan,
            'tpprd_tanggal_akhir' => $tanggal_akhir->format('Y-m-d'),
            'tpprd_up' => $request->tpprd_up,
            'tpprd_tarif' => $tarif,
            'tpprd_premi' => $premi,
            'tpprd_user_input' => 'aripp',
            // 'tpprd_user_input' => auth()->user()->name,
            'tpprd_date_input' => now(),
        ]);

        return redirect()->route('tpprd.create')->with('success', 'Data peserta berhasil disimpan.');
    }

    public function downloadTemplate()
    {
        $filePath = public_path('tpprd/template_kumpulan.xlsx');
        return response()->download($filePath);
    }

}
