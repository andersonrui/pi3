<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Stock extends Model
{
    protected $table = 'stock';

    public function produto(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'produto_id');
    }

    public function getSaldoAttribute()
    {
        return $this->where('produto_id', $this->produto_id)->sum('quantidade');
    }
}
