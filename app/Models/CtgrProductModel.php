<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CtgrProductModel extends Model
{
    protected $table = 'ctgr_product';
    protected $primaryKey = 'ctgr_product_id';

    protected $guarded = [];
}
