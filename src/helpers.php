<?php

if (!function_exists('getModels')) {

    function getModels(){
        $path = app_path('Models');
        $out = [];
        $results = scandir($path);
        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;
            if (!is_dir($path . '/' . $result)) {
                $out[] = 'App\\Models\\' . substr($result, 0, -4);;
            }
        }
        return $out;
    }
}


if (! function_exists('createSlug')) {
    function createSlug($title,$model, $id = 0)
    {
        // Normalize the title
        $slug = Str::slug(localizeGeorgianToEnglish($title),'-');
        // Get any that could possibly be related.
        // This cuts the queries down by doing it once.
        $allSlugs = getRelatedSlugs($model,$slug, $id);
        // If we haven't used it before then we are all good.
        if (! $allSlugs->contains('url', $slug)){
            return $slug;
        }
        // Just append numbers like a savage until we find not used.
        for ($i = 1; $i <= 10; $i++) {
            $newSlug = $slug.'-'.$i;
            if (! $allSlugs->contains('url', $newSlug)) {
                return $newSlug;
            }
        }
        throw new \Exception('Can not create a unique slug');
    }
}

if (! function_exists('getRelatedSlugs')) {
    function getRelatedSlugs($model,$slug, $id = 0)
    {
        return $model->select('url')->where('url', 'like', $slug . '%')
            ->where('id', '<>', $id)
            ->get();
    }
}


if (! function_exists('localizeGeorgianToEnglish')) {
    function localizeGeorgianToEnglish($string)
    {
        $string = trim($string);
        if (empty($string)) {
            return '';
        }
        $symbols = ['ა' => 'a', 'შ' => 'sh', 'ჩ' => 'ch', 'ღ' => 'g', 'ძ' => 'dz', 'თ' => 't', 'ჟ' => 'j', 'წ' => 'w', 'ჭ' => 'ch', 'ბ' => 'b', 'ც' => 'c', 'დ' => 'd', 'ე' => 'e', 'ფ' => 'f', 'გ' => 'g', 'ჰ' => 'h', 'ი' => 'i', 'ჯ' => 'j', 'კ' => 'k', 'ლ' => 'l', 'მ' => 'm', 'ნ' => 'n', 'ო' => 'o', 'პ' => 'p', 'ქ' => 'q', 'რ' => 'r', 'ს' => 's', 'ტ' => 't', 'უ' => 'u', 'ვ' => 'v', 'ხ' => 'x', 'ყ' => 'y', 'ზ' => 'z',];
        $return_string = '';
        $array = preg_split('//u', $string, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($array as $char) {
            if (key_exists($char, $symbols)) {
                $return_string .= $symbols[$char];
            } else {
                $return_string .= $char;
            }
        }
        return $return_string;
    }
}


if (!function_exists('isBreadSlugAutoGenerator')) {

    function isBreadSlugAutoGenerator($options)
    {
//        dd($options);
        if (isset($options->slugify)) {
            return ' data-slug-origin=' . $options->slugify->origin
                . ((isset($options->slugify->forceUpdate))
                    ? ' data-slug-forceupdate=true'
                    : '');
        }

        return '';
    }
}

// Reflection Helpers

if (!function_exists('get_reflection_method')) {
    function get_reflection_method($object, $method)
    {
        $reflectionMethod = new \ReflectionMethod($object, $method);
        $reflectionMethod->setAccessible(true);

        return $reflectionMethod;
    }
}

if (!function_exists('call_protected_method')) {
    function call_protected_method($object, $method, ...$args)
    {
        return get_reflection_method($object, $method)->invoke($object, ...$args);
    }
}

if (!function_exists('get_reflection_property')) {
    function get_reflection_property($object, $property)
    {
        $reflectionProperty = new \ReflectionProperty($object, $property);
        $reflectionProperty->setAccessible(true);

        return $reflectionProperty;
    }
}

if (!function_exists('get_protected_property')) {
    function get_protected_property($object, $property)
    {
        return get_reflection_property($object, $property)->getValue($object);
    }
}

if (! function_exists('cleanHtml')) {
    function cleanHtml($str)
    {
        $str = mb_convert_encoding($str,'HTML-ENTITIES','utf-8');
        $str = str_replace("&nbsp;", " ", $str);
        $str = preg_replace('/\s+/', ' ',$str);
        $str = trim($str);
        return $str;
    }
}

if (!function_exists('pageUrl')) {
    function pageUrl($type){
        return url(optional(\Sina\Shuttle\Models\Page::where('type_id',$type)->first())->url ?? "");
    }
}
