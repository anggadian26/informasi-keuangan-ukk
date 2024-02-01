<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokModel extends Model
{
    protected $table = 'stok';
    protected $primaryKey = 'stok_id';

    protected $guarded = [];
}
