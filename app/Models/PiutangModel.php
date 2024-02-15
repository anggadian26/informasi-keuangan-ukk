<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiutangModel extends Model
{
    protected $table = 'piutang';
    protected $primaryKey = 'piutang_id';

    protected $guarded = [];
}
