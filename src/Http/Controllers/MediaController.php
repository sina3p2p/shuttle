<?php

namespace Sina\Shuttle\Http\Controllers;

use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaController extends Controller
{
    public function upload(Request $request)
    {
        set_time_limit(0);
        ini_set('max_execution_time', 180);

        if($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName.'_'.time().'.'.$extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/'.$fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            return $response;
        }else{
            $uploaded_file = $request->file('file');
            $file = $uploaded_file->store('public/upload');
//            $webp = imagewebp(imagecreatefromstring(Storage::get($file)), storage_path('app/'.$file.'.webp'), 70);
//            Webp::make($request->file('file')->getPathName())->save(storage_path('app/'.$file.'.webp'));
            $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            if (function_exists('imagewebp')) {

                switch ($file_type) {
                    case 'jpeg':
                    case 'jpg':
                        $image = imagecreatefromjpeg($uploaded_file);
                        break;

                    case 'png':
                        $image = imagecreatefrompng($uploaded_file);
                        imagepalettetotruecolor($image);
                        imagealphablending($image, true);
                        imagesavealpha($image, true);
                        break;

                    case 'gif':
                        $image = imagecreatefromgif($uploaded_file);
                        break;
                    default:
                        return response()->json(['path' => $file, 'url' => Storage::url($file)]);
                }

                // Save the image
                $result = imagewebp($image, storage_path('app/'.$file.'.webp'), 70);
                if (false === $result) {
                    return response()->json(['path' => $file, 'url' => Storage::url($file)]);
                }

                // Free up memory
                imagedestroy($image);

            }
            return response()->json(['path' => $file, 'url' => Storage::url($file)]);
        }
    }
}
