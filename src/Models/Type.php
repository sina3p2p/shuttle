<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{

    protected $table = 'shuttle_types';

    protected $fillable = ['model', 'display_name', 'name'];

    public function sections()
    {
        return $this->hasMany('Sina\Shuttle\Models\Section')->orderBy('position');
    }

    public function pages()
    {
        return $this->hasMany('Sina\Shuttle\Models\Page');
    }

}
