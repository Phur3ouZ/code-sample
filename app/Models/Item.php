<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends ModelWithHistory
{
    use SoftDeletes;

    protected $table = 'items';
}
