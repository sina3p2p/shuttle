<?php

namespace Sina\Shuttle\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class MediaLibrary extends Model
{

    protected $table = 'shuttle_media_libraries';

    protected $guarded = ['id'];

    public $appends = ['url'];

    public function getUrlAttribute(){
        return Storage::url($this->path);
    }

}
