<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'inventory_id',
        'tanggal',
        'nomor_transaksi',
        'jumlah',
        'tipe',
        'total_stok'
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
