<?php

namespace Sina\Shuttle\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait CanRender
{
    public function render($data)
    {
        if (method_exists($this, $this->type)) return $this->{$this->type}($data);

        return $data;
    }

    public function image($data)
    {
        return '<img src="' . Storage::url($data) . '" width="50" />';
    }

    public function relationship($data)
    {
        $option = $this->details;
        return match ($option->type) {
            "belongsTo" => $data->{$option->label},
            default => '',
        };
    }
}
