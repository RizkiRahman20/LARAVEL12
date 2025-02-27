<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    //Mass Assignment untuk inputan di resource
    protected $fillable = [
        'nama_barang',
        'kondisi',
        'jumlah'
    ];

    //Memberi tahu bahwa model stok memiliki banyak data model peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
