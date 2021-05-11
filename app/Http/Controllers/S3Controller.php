<?php

namespace App\Http\Controllers;

// use App\Models\S3;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class S3Controller extends Controller
{

    public function getFiles(Request $request)
    {
        $files = Storage::disk('s3')->files();

        return array(
            "files" => $files,
        );
    }

    public function uploads(Request $request)
    {
        // Verifica se informou o arquivo e se é válido
        // dd($request->file);
        if ($request->hasFile('uploadFile') && $request->file('uploadFile')->isValid() && exif_imagetype($request->uploadFile)) {

            $isExists = Storage::disk('s3')->exists($request->file('uploadFile')->getClientOriginalName());

            if ($isExists) {
                return response()->json("Já existe um arquivo com mesmo nome na pasta", 406);
            }

            $path = $request->file('uploadFile')->storePubliclyAs(
                '/',
                $request->file('uploadFile')->getClientOriginalName(),
                's3'
            );

            return Storage::disk('s3')->url($path);
        }
    }

    public function download(Request $request)
    {
        if ($request->path) {
            return Storage::disk('s3')->download($request->path);
        }

        // return response()->download($file);
    }

    public function delete(Request $request)
    {
        if ($request->path) {
            if (Storage::disk('s3')->delete($request->path)) {
                return response()->json(["ok" => true]);
            } else {
                return response()->json(["ok" => false], 500);
            }
        }

        // return response()->download($file);
    }
}
