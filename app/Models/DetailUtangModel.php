<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUtangModel extends Model
{
    protected $table = 'detail_utang';
    protected $primaryKey = 'detail_utang_id';

    protected $guarded = [];
}
