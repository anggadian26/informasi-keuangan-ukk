<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianModel extends Model
{
    protected $table = 'pembelian';
    protected $primaryKey = 'pembelian_id';

    protected $guarded = [];

    public function details()
    {
        return $this->hasMany(DetailPembelianModel::class, 'pembelian_id', 'pembelian_id');
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierModel::class, 'supplier_id');
    }

}
