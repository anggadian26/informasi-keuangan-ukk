<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianModel extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'pembelian_id';

    protected $guarded = [];
}
