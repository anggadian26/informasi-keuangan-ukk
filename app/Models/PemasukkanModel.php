<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemasukkanModel extends Model
{
    protected $table = 'pemasukkan';
    protected $primaryKey = 'pemasukkan_id';

    protected $guarded = [];
}
