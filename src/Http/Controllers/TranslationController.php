<?php

namespace Sina\Shuttle\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class TranslationController extends Controller
{
    public function index()
    {
        $langPath = File::directories(resource_path('lang'));
        $strings = [];
        foreach ($langPath as $item){
            $lang = basename($item);
            $strings[$lang] = collect(File::allFiles($item))->flatMap(function ($file) {
                $lang = (basename(dirname($file)));
                return [
                    ($translation = $file->getBasename('.php')) => trans($translation, [],$lang),
                ];
            })->toArray();
        }

        return view('shuttle::translation',compact('strings'));

    }

    public function store(Request $request)
    {
        $trans = trans('common', [],$request->lang);
        $trans[$request->key] = $request->value;
        $content = "<?php return ".var_export($trans,true).";";
        file_put_contents(resource_path('lang/'. $request->lang .'/common.php'), $content);
        return 'success';
    }
}
