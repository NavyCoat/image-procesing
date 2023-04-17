<?php

namespace App\ImageStorage;

use App\SubmissionCenter\Event\Image;

class ImageStorage
{

    public function __construct()
    {
    }

    public function saveChanged(\App\SubmissionCenter\Event\Image $image)
    {
    }

    public function getChanged(\App\SubmissionCenter\Event\Image $image): Image
    {
        return new Image();
    }

    public function saveOriginal(Image $image)
    {

    }

    public function getOriginal(Image $image): Image
    {
        return new Image();
    }
}