<?php

namespace App\Http\Controllers;

use App\Models\Tpprd;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KepesertaanController extends Controller
{
    public function index()
    {
        return view('kepesertaan.index');
    }

    public function getData(Request $request)
    {
        var_dump($request->input('bank'));die();

        $query = Tpprd::query();

        // // Filter by date range
        // if ($request->has('start_date') && $request->has('end_date')) {
        //     $start_date = $request->input('start_date');
        //     $end_date = $request->input('end_date');
        //     $query->whereBetween('tpprd_date_input', [$start_date, $end_date]);
        // }

        // Filter by name
        if ($request->has('nama')) {
            $nama = $request->input('nama');
            $query->where('tpprd_nama', 'LIKE', "%{$nama}%");
        }

        // // Filter by bank name
        // if ($request->has('bank')) {
        //     $bank = $request->input('bank');
        //     $query->where('tpprd_bank', 'LIKE', "%{$bank}%");
        // }

        // // Filter by participant number
        // if ($request->has('nomor_peserta')) {
        //     $nomor_peserta = $request->input('nomor_peserta');
        //     $query->where('tpprd_nomor_peserta', 'LIKE', "%{$nomor_peserta}%");
        // }


        return DataTables::of($query)->make(true);
    }
}
