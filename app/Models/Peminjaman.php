<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

class Peminjaman extends Model
{
    use HasFactory;

    //Mass Assignment untuk inputan di resource nanti
    protected $fillable = [
        'stok_id',
        'user_id',
        'keterangan',
        'jumlah',
        'status'
    ];

    //Memberi tahu bahwa model peminjaman dimiliki oleh model stok dan user
    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //Validasi pengurangan stok otomatis pada saat crud dilakukan
    protected static function booted()
    {
        static::creating(function($peminjaman){
            if ($peminjaman->stok->jumlah < $peminjaman->jumlah){
                throw ValidationException::withMessages(['jumlah' => 'Jumlah tidak mencukupi untuk peminjaman ini']);
            }
            $peminjaman->stok->decrement('jumlah', $peminjaman->jumlah);
        });

        static::updating(function($peminjaman){
            if ($peminjaman->isDirty('status') && $peminjaman->status == 'Dikembalikan'){
                $peminjaman->stok->increment('jumlah', $peminjaman->jumlah);
            }
        });

        static::deleting(function($peminjaman){
            if ($peminjaman->status == 'Dipinjam'){
                $peminjaman->stok()->increment('jumlah', $peminjaman->jumlah);
            }
        });
    }
}
