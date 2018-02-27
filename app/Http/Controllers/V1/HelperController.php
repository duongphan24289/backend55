<?php

namespace App\Http\Controllers\V1;

use App\Helpers\FileHelper;
use App\Http\Controllers\Controller;
use Cache;

class HelperController extends Controller
{
    use FileHelper;

    public function getS3Config(){
        try {

            if($this->isValidS3Config()){
                $key = Cache::get('AWS_S3_KEY');
                $secret = Cache::get('AWS_S3_SECRET');
                $token = Cache::get('AWS_S3_TOKEN');
            }
            else {
                list( $key, $secret, $token, $expiration ) = $this->getS3ConfigEc2();

                // remove from cache
                Cache::forget('AWS_S3_KEY');
                Cache::forget('AWS_S3_SECRET');
                Cache::forget('AWS_S3_TOKEN');
                Cache::forget('AWS_S3_EXPIRATION');

                // renew cache
                Cache::put('AWS_S3_KEY', $key, config('filesystems.disks.s3.time_cache'));
                Cache::put('AWS_S3_SECRET', $secret, config('filesystems.disks.s3.time_cache'));
                Cache::put('AWS_S3_TOKEN', $token, config('filesystems.disks.s3.time_cache'));
                Cache::put('AWS_S3_EXPIRATION', $expiration, config('filesystems.disks.s3.time_cache'));
            }

            return response()->success([
                'key' => $key,
                'secret' => $secret,
                'token' => $token
            ]);
        }
        catch (\Exception $e){

        }
    }
}
