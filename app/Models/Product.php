<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $table = "produtos";

    public function tipoProduto(): BelongsTo
    {
        return $this->belongsTo(ProductType::class, 'produto_tipo_id');
    }
}
