<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    protected $table = 'product';
    protected $primaryKey = 'product_id';

    protected $guarded = [];

    public function stok()
    {
        return $this->hasOne(StokModel::class, 'product_id', 'product_id');
    }
}
