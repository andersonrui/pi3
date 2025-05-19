<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Sale extends Model
{
    protected $table = "vendas";

    /**
     * Get the user that owns the Sale
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'cliente_id', 'id');
    }

    public function aVencer()
    {
        return $this->where('pago', 0)->where('vencimento', '>', Carbon::now());
    }

    public function vencidas()
    {
        return $this->where('pago', 0)->where('vencimento', '<', Carbon::now());
    }
}
