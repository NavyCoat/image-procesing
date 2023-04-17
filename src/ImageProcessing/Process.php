<?php

namespace App\ImageProcessing;

class Process
{
    private Step $currentStep;
    private Steps $steps;

    public static function fromSubmission(\App\SubmissionCenter\Event\Submission $submission)
    {

    }
}