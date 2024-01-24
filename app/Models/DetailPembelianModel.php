<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPembelianModel extends Model
{
    protected $table = 'detail_pembelian';
    protected $primaryKey = 'detail_pembelian_id';

    protected $guarded = [];
}
