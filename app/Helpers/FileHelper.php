<?php

namespace App\Helpers;

use Aws\S3\S3Client;
use League\Flysystem\Adapter\Local;
use League\Flysystem\AwsS3v3\AwsS3Adapter;
use League\Flysystem\Filesystem;
use Cache;
use Carbon\Carbon;
use App;

trait FileHelper {

    protected $local;

    protected $s3;

    private $rootUploads = 'uploads';

    private $directories = [
        'uploads' => ''
    ];

    public function __construct()
    {
        $this->initDirectory();
        $this->initLocal();
        $this->initS3();
    }

    public function initDirectory(){
        foreach ($this->directories as $directory){
            $path = public_path($this->rootUploads) . "/{$directory}";
            if(!is_dir($path)){
                mkdir($path);
            }
        }
    }

    public function initLocal(){
        $adapter = new Local(public_path($this->rootUploads));
        $this->local = new Filesystem($adapter);
    }

    public function initS3(){
        try {
            $config = $this->configS3();
            $client = new S3Client(
              [
                  'credentials' => [
                      'key' => $config['key'],
                      'secret' => $config['secret'],
                      'token' => $config['token'],
                  ],
                  'region' => config('filesystems.disks.s3.region'),
                  'version' => 'latest'
              ]
            );
            $adapter = new AwsS3Adapter($client, config('filesystems.disks.s3.bucket'));
            $this->s3 = new Filesystem($adapter);
        }
        catch (\Exception $e){
            dd('init s3 error');
        }
    }

    public function configS3(){
        if($this->isValidS3Config()){
            $key = Cache::get('AWS_S3_KEY');
            $secret = Cache::get('AWS_S3_SECRET');
            $token = Cache::get('AWS_S3_TOKEN');
        }
        else {
            if(App::isLocal()){
                list($key, $secret, $token, $expiration) = $this->getS3ConfigLocal();
            }
            else {
                list($key, $secret, $token, $expiration) = $this->getS3ConfigEc2();
            }

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

        return [
            'key' => $key,
            'secret' => $secret,
            'token' => $token,
        ];
    }

    public function isValidS3Config(){
        if(Cache::has('AWS_S3_EXPIRATION')){
            $expiration = new Carbon(Cache::get('AWS_S3_EXPIRATION'));

            return Cache::has('AWS_S3_KEY')
                && Cache::has('AWS_S3_SECRET')
                && Cache::has('AWS_S3_TOKEN')
                && $expiration->subHours(3)->isFuture();
        }
        return false;
    }

    public function getS3ConfigLocal(){
        return [
            config('filesystems.disks.s3.key'),
            config('filesystems.disks.s3.secret'),
            config('filesystems.disks.s3.token'),
            config('filesystems.disks.s3.expiration'),
        ];
    }

    public function uploadToS3($path){
        try {
            return $this->s3->put('debug.png', file_get_contents($path));
        }
        catch (\Exception $e){
            dd($e->getMessage());
            dd('upload fail.');
        }
    }

    /**
     * @param string   $key
     * @param S3Client $client
     *
     * @return bool
     */
    public function isExistS3($key, $client)
    {
        return $client->doesObjectExist(config('filesystems.disks.s3.bucket'), $key);
    }

    public function getS3ConfigEc2(){

        $content = json_decode(shell_exec('curl ' . config('filesystems.disks.s3.access')));

        return [
            $content->AccessKeyId,
            $content->SecretAccessKey,
            $content->Token,
            $content->Expiration,
        ];
    }
}