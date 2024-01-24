<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UtangModel extends Model
{
    protected $table = 'utang';
    protected $primaryKey = 'utang_id';

    protected $guarded = [];
}
