<?php

namespace App\SubmissionCenter\Event;

class SubmissionBuilder
{
    public function __construct()
    {

    }

    public function modify($image)
    {
        return $this;
    }

    public function scaleTo($int, $int1)
    {
        return $this;
    }

    public function changeFormatToJPG()
    {
        return $this;
    }

    public function build(): Submission
    {
        return new Submission();
    }
}