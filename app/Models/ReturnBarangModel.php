<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnBarangModel extends Model
{
    protected $table = 'return_barang';
    protected $primaryKey = 'return_barang_id';

    protected $guarded = [];
}
