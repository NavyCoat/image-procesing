<?php

namespace App\Statistics;

class Statistics
{

    public function __construct()
    {
    }

    public function recieveOriginalImageEvent(\App\ImageStorage\Event\OriginalImageStored $originalImageStored)
    {

    }

    public function recieveChangedImagedEvent(\App\ImageStorage\Event\ChangedImageStored $changedImageStored)
    {
    }

    public function filesizeForResolution(string $string): int
    {
        return 0;
    }

    public function imagesStored(): int
    {
        return 0;
    }
}