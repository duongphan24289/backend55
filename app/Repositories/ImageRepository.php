<?php

namespace App\Repositories;

interface ImageRepository {

    public function getName();

    public function getPath();

    public function getPattern();

    public function standardized($file);

    public function getDefaultExtension($type);

    public function standardizedWithoutResize($file);
}