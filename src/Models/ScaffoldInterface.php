<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;

class ScaffoldInterface extends Model
{
    protected $table = "scaffold_interfaces";

    protected $fillable = [
        'name', 'slug', 'display_name_singular', 'display_name_plural', 'migration',
        'model', 'translation_model', 'controller', 'views', 'details', 'icon', 'menuable',
    ];

    public function rows()
    {
        return $this->hasMany('Sina\Shuttle\Models\ScaffoldinterfaceRow', 'scaffold_interface_id', 'id')->orderBy('ord');
    }

    public function browseRows()
    {
        return $this->rows()->where('browse', 1);
    }

    public function readRows()
    {
        return $this->rows()->where('read', 1);
    }

    public function editRows()
    {
        return $this->rows()->where('edit', 1);
    }

    public function addRows()
    {
        return $this->rows()->where('add', 1);
    }

}
