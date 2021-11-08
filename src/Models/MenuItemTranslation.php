<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class MenuItemTranslation extends Model
{

    public $table = "shuttle_menu_item_translations";

    protected $fillable = [
        "title",
    ];

    public $timestamps = false;
}
