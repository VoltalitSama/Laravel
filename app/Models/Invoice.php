<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    protected $fillable = [
        'client_id',
        'purchase_order_id',
        'total_amount',
        'amount_before_tax',
        'tax',
        'send_at',
        'acquitted_at'
    ];

    /**
     * A Invoice is related to a Client
     *
     * @return BelongsTo
     */
    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * A Invoice can have many tools
     *
     * @return BelongsToMany
     */
    public function tools():BelongsToMany
    {
        return $this->belongsToMany(Tool::class)->withPivot('quantity');
    }
}
