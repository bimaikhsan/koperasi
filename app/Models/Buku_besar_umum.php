<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku_besar_umum extends Model
{
    use HasFactory;
    protected $table = "buku_umum_besar";
    protected $fillable = [
        'uraian',
        'tanggal',
        'nomor_bukti',
        'nomor_rekening',
        'data',
    ];
}
