<?php

namespace App\Repositories;

use App\Helpers\FileHelper;
use Intervention\Image\Facades\Image as Facade;

class ImageRepositoryImagick implements ImageRepository{

    use FileHelper;

    private $image;

    private $name;

    private $path;

    private $uploadMimeType = [
        'image/jpeg',
        'image/png',
    ];

    private $pattern = '';

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setPath($path){
        $this->path = $path;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getPattern(){
        return $this->pattern;
    }

    public function make($data){
        $this->image = Facade::make($data);
    }

    public function save(){
        $this->image->save($this->path);
    }

    public function standardized($file)
    {
        // TODO: Implement standardized() method.
    }

    public function getDefaultExtension($type)
    {
        // TODO: Implement getDefaultExtension() method.
    }

    public function standardizedWithoutResize($file)
    {
        $this->make($file);
        $this->setName('image.png');
        $this->setPath(public_path($this->rootUploads) . "/{$this->name}");
        $this->save();
    }
}