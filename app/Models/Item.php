<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends ModelWithHistory
{
    use SoftDeletes;

    protected $table = 'items';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Prices(): HasMany
    {
        return $this->hasMany(Price::class, 'item_id', 'id');
    }
}
