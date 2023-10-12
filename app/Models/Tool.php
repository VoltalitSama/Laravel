<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Tool extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price'
    ];
    /**
     * A Tool can be in many Invoices
     *
     * @return BelongsToMany
     */
    public function invoices():BelongsToMany
    {
        return $this->belongsToMany(Invoice::class)->withTimestamps();
    }
}
