<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPiutangModel extends Model
{
    protected $table = 'detail_piutang';
    protected $primaryKey = 'detail_piutang_id';

    protected $guarded = [];
}
