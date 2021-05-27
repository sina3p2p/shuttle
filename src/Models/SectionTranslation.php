<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class SectionTranslation extends Model
{
    protected $fillable = ['body', 'title', 'keywords', 'description', 'image'];
    public $timestamps = false;
}
