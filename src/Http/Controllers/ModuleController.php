<?php

namespace Sina\Shuttle\Http\Controllers;

use App\Http\Controllers\Controller;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use ZanySoft\Zip\Zip;
use Illuminate\Support\Str;
use PhpParser\NodeDumper;
use PhpParser\ParserFactory;
use PhpParser\{Node, NodeTraverser, NodeVisitorAbstract};

class ModuleController extends Controller
{
    public function import()
    {
        return '<form action="'.route('shuttle.module.store').'" enctype="multipart/form-data" method="post">'.csrf_field().'<input name="zip" type="file"><button type="submit">save</button></form>';
    }

    public function store(Request $request)
    {
        $zip_file = $request->zip->store('public/module/tmp');
        $zip = Zip::open(storage_path('app/'.$zip_file));
        $files = $zip->listFiles();
        
        if(in_array('module.json',$files))
        {
            if(!File::exists(app_path('Modules'))){
                File::makeDirectory(app_path('Modules'));
            }

            $extract_temp = storage_path('app/public/module/extracts');

            $zip->extract($extract_temp, 'module.json');

            $package_info = json_decode(file_get_contents($extract_temp.'/module.json'));
            
            $package_directories = explode('/', $package_info->name);

            $dir_of_package = 'Modules';

            foreach($package_directories as $dir)
            {
                $dir_of_package = $dir_of_package.'/'.$dir;
                if(!File::exists(app_path($dir_of_package))){
                    File::makeDirectory(app_path($dir_of_package));
                }
            }
            $zip->extract(app_path($dir_of_package));

            foreach($files as $f)
            {

                if(Str::endsWith($f, '.php')){

                    $file_path = app_path($dir_of_package.'/'.$f);

                    $for_use_as_name_space = "App\\".str_replace("/", "\\", $dir_of_package);
                    // preg_match_all('/^(use|namespace) [^;]+;/m', file_get_contents($file_path), $matches)

                    $content = preg_replace_callback('/^(use|namespace) [^;]+;/m', function ($match) use ($for_use_as_name_space, $files, $f){
                        if($match[1] == 'namespace'){
                            return "namespace ".$for_use_as_name_space.'\\'.Str::of($f)->dirname().';';
                        }
                        $file_name = Str::of($match[0])->basename()->remove(';').'.php';
                        $path = array_filter($files,  function ($file) use ($file_name) {
                            return Str::of($file)->basename() == $file_name;
                        });
                        
                        if($path){
                            return "use ".$for_use_as_name_space.'\\'.str_replace(['.php', '/'], ['', '\\'], array_values($path)[0]).';';
                        }

                        return $match[0];
                    }, file_get_contents($file_path));

                    File::put($file_path, $content);
            
                };
            }

            Artisan::call('migrate --path=app/'.$dir_of_package.'/Database/Migrations');

            $outputt = Artisan::output();
            print $outputt;
        }
    }

}
