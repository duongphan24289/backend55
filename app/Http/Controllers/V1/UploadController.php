<?php

namespace App\Http\Controllers\V1;

use App\Helpers\FileHelper;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{

    use FileHelper {
        FileHelper::__construct as private __fhConstruct;
    }

    public function upload(Request $request){
        try {
            $file = $request->file('file');

            $image = app(ImageRepository::class);
            $image->standardizedWithoutResize($file);

            dd($this->getS3ConfigEc2());

            if($this->uploadToS3($image->getPath())){
                dd('upload thanh cong');
            }
            dd('upload that bai');
        }
        catch(\Exception $exception){
            dd($exception);
        }
    }
}
