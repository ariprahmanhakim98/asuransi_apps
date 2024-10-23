<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tpprd extends Model
{
    use HasFactory;
    
    protected $table = 'tpprd';

    protected $fillable = [
        'tpprd_nomor_peserta',
        'tpprd_nama',
        'tpprd_tanggal_lahir',
        'tpprd_umur',
        'tpprd_bank',
        'tpprd_tanggal_awal',
        'tpprd_masa_bulan',
        'tpprd_tanggal_akhir',
        'tpprd_up',
        'tpprd_tarif',
        'tpprd_premi',
        'tpprd_user_input',
        'tpprd_date_input',
    ];
}
