<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    protected $fillable = ['title', 'keywords', 'description'];
    public $timestamps = false;
    public $table = "shuttle_page_translations";
}
