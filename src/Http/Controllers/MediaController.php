<?php

namespace Sina\Shuttle\Http\Controllers;

use Buglinjo\LaravelWebp\Facades\Webp;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Sina\Shuttle\Models\MediaLibrary;

class MediaController extends Controller
{
    public function index(){
        return MediaLibrary::all();
    }
    //     public function upload(Request $request)
    //     {
    //         set_time_limit(0);
    //         ini_set('max_execution_time', 180);

    //         if($request->hasFile('upload')) {
    //             $originName = $request->file('upload')->getClientOriginalName();
    //             $fileName = pathinfo($originName, PATHINFO_FILENAME);
    //             $extension = $request->file('upload')->getClientOriginalExtension();
    //             $fileName = $fileName.'_'.time().'.'.$extension;

    //             $request->file('upload')->move(public_path('images'), $fileName);

    //             $CKEditorFuncNum = $request->input('CKEditorFuncNum');
    //             $url = asset('images/'.$fileName);
    //             $msg = 'Image uploaded successfully';
    //             $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

    //             @header('Content-type: text/html; charset=utf-8');
    //             return $response;
    //         }else{
    //             $uploaded_file = $request->file('file');
    //             $file = $uploaded_file->store('public/upload');
    // //            $webp = imagewebp(imagecreatefromstring(Storage::get($file)), storage_path('app/'.$file.'.webp'), 70);
    // //            Webp::make($request->file('file')->getPathName())->save(storage_path('app/'.$file.'.webp'));
    //             $file_type = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    //             if (function_exists('imagewebp')) {

    //                 switch ($file_type) {
    //                     case 'jpeg':
    //                     case 'jpg':
    //                         $image = imagecreatefromjpeg($uploaded_file);
    //                         break;

    //                     case 'png':
    //                         $image = imagecreatefrompng($uploaded_file);
    //                         imagepalettetotruecolor($image);
    //                         imagealphablending($image, true);
    //                         imagesavealpha($image, true);
    //                         break;

    //                     case 'gif':
    //                         $image = imagecreatefromgif($uploaded_file);
    //                         break;
    //                     default:
    //                         return response()->json(['path' => $file, 'url' => Storage::url($file)]);
    //                 }

    //                 // Save the image
    //                 $result = imagewebp($image, storage_path('app/'.$file.'.webp'), 70);
    //                 if (false === $result) {
    //                     return response()->json(['path' => $file, 'url' => Storage::url($file)]);
    //                 }

    //                 // Free up memory
    //                 imagedestroy($image);

    //             }
    //             // return response()->json(['path' => $file, 'url' => Storage::url($file)]);
    //             return response()->json(['path' => $file, 'url' => Storage::url($file)]);
    //         }
    //     }

    public function upload(Request $request)
    {

        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            return $response;
        } else {
            $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

            // check if the upload is success, throw exception or return response you need
            if ($receiver->isUploaded() === false) {
                throw new UploadMissingFileException();
            }

            // receive the file
            $save = $receiver->receive();

            // check if the upload has finished (in chunk mode it will send smaller files)
            if ($save->isFinished()) {
                // save the file and return any response you need, current example uses `move` function. If you are
                // not using move, you need to manually delete the file by unlink($save->getFile()->getPathname())
                return $this->saveFile($save->getFile());
            }

            // we are in chunk mode, lets send the current progress
            /** @var AbstractHandler $handler */
            $handler = $save->handler();

            return response()->json([
                "done" => $handler->getPercentageDone(),
            ]);
        }
    }

    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());
        // Group files by the date (week
        $dateFolder = date("Y-m-W");

        // Build the file path
        $filePath = "public/upload/{$mime}/{$dateFolder}/";
        $finalPath = storage_path("app/" . $filePath);

        // move the file name
        $file->move($finalPath, $fileName);

        // $uploaded_record = FileUpload::create([
        //     'path' => $filePath.$fileName
        // ]);

        $file_type = strtolower(pathinfo($filePath . $fileName, PATHINFO_EXTENSION));

        if (function_exists('imagewebp')) {

            switch ($file_type) {
                case 'jpeg':
                case 'jpg':
                    $image = imagecreatefromjpeg($finalPath . $fileName);
                    break;

                case 'png':
                    $image = imagecreatefrompng($finalPath . $fileName);
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                    break;

                case 'gif':
                    $image = imagecreatefromgif($finalPath . $fileName);
                    break;
            }

            if (isset($image) && !is_null($image)) {
                // Save the image
                $result = imagewebp($image, $finalPath . $fileName . '.webp', 70);
                // Free up memory
                imagedestroy($image);
            }
        }

        MediaLibrary::create([
            'name' => $fileName,
            'path' => $filePath . $fileName
        ]);

        return response()->json([
            // 'id'        => $uploaded_record->id,
            'path'      => $filePath . $fileName,
            'name'      => $fileName,
            'mime_type' => $mime,
            'url'       => Storage::url($filePath . $fileName)
        ]);
    }

    /**
     * Create unique filename for uploaded file
     * @param UploadedFile $file
     * @return string
     */
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        $filename = str_replace("." . $extension, "", $file->getClientOriginalName()); // Filename without extension

        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time()) . "." . $extension;

        return $filename;
    }

    public function link(Request $request)
    {
        if (!Storage::exists($request->path)) {
            abort(404);
        }
        return response()->file(Storage::path($request->path));
    }
}
