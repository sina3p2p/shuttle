<?php

namespace Sina\Shuttle\Http\Traits;

use Illuminate\Support\Facades\Storage;

use function Symfony\Component\Translation\t;

trait EloquentImageMutatorTrait
{

    protected static $imageEnable = true;
    protected static $forceImageEnable = false;


    public function enableForceImageMulator()
    {
        self::$forceImageEnable = true;
    }

    public function toArray()
    {
        $arr = parent::toArray();

        $middlewares = request()->route()->middleware();

        if (self::$imageEnable) {
            foreach ($this->image_fields ?? [] as $key) {
                if (!isset($arr[$key])) continue;
                
                if (is_array($arr[$key])) {
                    $arr[$key] = array_map(function ($img) {
                        return url(Storage::url($img));
                    }, $arr[$key]);
                } else {
                    $arr[$key] = url(Storage::url($arr[$key]));
                }
            }
        }

        return $arr;
    }
}
