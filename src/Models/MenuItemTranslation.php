<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{

    protected $fillable = [
        "title",
    ];

    public $timestamps = false;
}
