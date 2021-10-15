<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\ValidatedInput;

class Item extends ModelWithHistory
{
    use SoftDeletes;

    protected $table = 'items';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Price(): HasOne
    {
        return $this->hasOne(Price::class, 'item_id', 'id')
            ->where('currency', '=', 'NZD');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Prices(): HasMany
    {
        return $this->hasMany(Price::class, 'item_id', 'id');
    }
}
