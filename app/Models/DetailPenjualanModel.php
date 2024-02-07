<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPenjualanModel extends Model
{
    protected $table = 'detail_penjualan';
    protected $primaryKey = 'detail_penjualan_id';

    protected $guarded = [];

    public function produk() {
        return $this->hasOne(ProductModel::class, 'product_id', 'product_id');
    }
}
