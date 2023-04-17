<?php

namespace App\ImageProcessing;

use App\SubmissionCenter\Event\Submission;

class ImageProcessing
{
    private ProcessQueue $queue;

    public function __construct(ProcessQueue $queue)
    {
        $this->queue = $queue;
    }

    public function process(Submission $submission)
    {
        $process = Process::fromSubmission($submission);
        $this->queue->add($process);
    }
}