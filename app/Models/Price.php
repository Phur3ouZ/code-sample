<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Price extends ModelWithHistory
{
    protected $table = 'prices';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function Item(): BelongsTo
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
}
