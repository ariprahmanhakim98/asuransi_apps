<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use App\Models\Tpprd;
use Carbon\Carbon;
// use DateTime;

class ExcelImportController extends Controller
{
    public function importExcel(Request $request)
    {
        // Validasi bahwa file yang diunggah haruslah file Excel dengan ekstensi .xlsx
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        // Ambil file yang diunggah
        $file = $request->file('file');

        // Baca file Excel menggunakan PhpSpreadsheet
        try {
            $spreadsheet = IOFactory::load($file->getPathName());
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = $worksheet->toArray();

            // Proses data dari Excel (misalnya simpan ke database)
            foreach ($rows as $index => $row) {

                if ($index == 0) {
                    continue; // Ini adalah header, lewati baris pertama
                }

                $nama = $row[1];
                $tgl_lahir = $row[2];
                $bank = $row[3];
                $masa = $row[4];
                $up = $row[5];

                // $request->validate([
                //     'tpprd_nama' => 'required',
                //     'tpprd_tanggal_lahir' => 'required|date_format:d/m/Y',
                //     'tpprd_bank' => 'required',
                //     'tpprd_masa_bulan' => 'required|integer',
                //     'tpprd_up' => 'required|numeric',
                // ]);

                // Buat nomor peserta
                $currentYear = now()->format('y'); // Contoh: 24
                $currentMonth = now()->format('m'); // Contoh: 05
                $lastParticipant = Tpprd::latest()->first();
                $newNumber = $lastParticipant ? intval(substr($lastParticipant->tpprd_nomor_peserta, 6)) + 1 : 1;
                $tpprd_nomor_peserta = $currentYear . '.' . $currentMonth . '.' . str_pad($newNumber, 6, '0', STR_PAD_LEFT);

                // Hitung umur
                $tanggal_lahir = Carbon::createFromFormat('d/m/Y', $tgl_lahir);
                $umur = $tanggal_lahir->diffInYears(now());

                // Set tanggal awal dan tanggal akhir
                $tanggal_awal = now();
                $tanggal_akhir = $tanggal_awal->copy()->addMonths($masa);

                // Hitung tarif
                $tarif_per_mil = 3.88;
                $tarif = ($masa / 12) * $tarif_per_mil;

                // Hitung premi
                $cleanedNumberString = str_replace(',', '', $up);
                $premi = ($cleanedNumberString * $tarif) / 1000;


                $datax = array(
                    'tpprd_nomor_peserta' => $tpprd_nomor_peserta,
                    'tpprd_nama' => $nama,
                    'tpprd_tanggal_lahir' => $tgl_lahir,
                    'tpprd_umur' => $umur,
                    'tpprd_bank' => $bank,
                    'tpprd_tanggal_awal' => $tanggal_awal,
                    'tpprd_masa_bulan' => $masa,
                    'tpprd_tanggal_akhir' => $tanggal_akhir,
                    'tpprd_up' => $cleanedNumberString,
                    'tpprd_tarif' => $tarif,
                    'tpprd_premi' => $premi,
                    'tpprd_user_input' => 'aripp',
                    // 'tpprd_user_input' => auth()->user()->name,
                    'tpprd_date_input' => now(),
                );

                Tpprd::create([
                    'tpprd_nomor_peserta' => $tpprd_nomor_peserta,
                    'tpprd_nama' => $nama,
                    'tpprd_tanggal_lahir' => $tanggal_lahir->format('Y-m-d'),
                    'tpprd_umur' => $umur,
                    'tpprd_bank' => $bank,
                    'tpprd_tanggal_awal' => $tanggal_awal->format('Y-m-d'),
                    'tpprd_masa_bulan' => $masa,
                    'tpprd_tanggal_akhir' => $tanggal_akhir->format('Y-m-d'),
                    'tpprd_up' => $cleanedNumberString,
                    'tpprd_tarif' => $tarif,
                    'tpprd_premi' => $premi,
                    'tpprd_user_input' => 'aripp',
                    // 'tpprd_user_input' => auth()->user()->name,
                    'tpprd_date_input' => now(),
                ]);
                // var_dump($tanggal_lahir->format('Y-m-d'));
                // die();
            }

            return redirect()->back()->with('success', 'File berhasil diunggah dan diproses.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Ada masalah dalam memproses file.');
        }
    }
}
