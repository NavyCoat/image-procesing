<?php


use App\ImageProcessing\ImageProcessing;
use App\ImageStorage\Event\ChangedImageStored;
use App\ImageStorage\ImageStorage;
use App\ImageStorage\Event\OriginalImageStored;
use App\Statistics\Statistics;
use App\SubmissionCenter\Event\Image;
use App\SubmissionCenter\Event\SubmissionBuilder;
use App\SubmissionCenter\Event\SubmissionCreated;
use App\SubmissionCenter\Event\SubmissionsCenter;
use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{

    public function testSubmission()
    {
        //arrange
        $image = new Image();
        $submissionsCenter = new SubmissionsCenter();
        $submissionBuilder = new SubmissionBuilder();
        $submission = $submissionBuilder->modify($image)
            ->scaleTo(200, 300)
            ->changeFormatToJPG()
            ->build();

        //when
        $submissionsCenter->submit($submission);

        //then
        $this->assertEventsOccured([
            SubmissionCreated::class,
        ]);
    }

    public function testImageProcessingForSubmission()
    {
        //arrange
        $image = new Image();
        $imageProcessing = new ImageProcessing();
        $submissionBuilder = new SubmissionBuilder();
        $submission = $submissionBuilder->modify($image)
            ->scaleTo(200, 300)
            ->changeFormatToJPG()
            ->build();

        //When
        $imageProcessing->process($submission);

        //Then
        $this->assertEventsOccured([
            ResoultionChagned::class,
            FormatChanged::class,
            ImageProcessed::class,
        ]);
    }

    public function testStoringOriginalImage()
    {
        //arrange
        $image = new Image();
        $imageStorage = new ImageStorage();

        //When
        $imageStorage->saveOriginal($image);

        //Then
        self::assertSame($image, $imageStorage->getOriginal($image));
        $this->assertEventsOccured([
            OriginalImageStored::class,
        ]);
    }

    public function testStoringChangedImage()
    {
        //arrange
        $image = new Image();
        $imageStorage = new ImageStorage();

        //When
        $imageStorage->saveChanged($image);

        //Then
        self::assertSame($image, $imageStorage->getChanged($image));
        $this->assertEventsOccured([
            ChangedImageStored::class,
        ]);
    }

    public function testStatisticsForImageStored()
    {
        //arrange
        $statistics = new Statistics();
        $originalImageStored = new OriginalImageStored(1000, '200x200');

        //When
        $statistics->recieveOriginalImageEvent($originalImageStored);

        //then
        self::assertSame(1, $statistics->imagesStored());
    }

    public function testFilesizesForResolution()
    {
        //arrange
        $statistics = new Statistics();
        $originalImageStored = new OriginalImageStored(1000, '200x200');
        $changedImageStored = new ChangedImageStored(1000, '200x200');

        //When
        $statistics->recieveOriginalImageEvent($originalImageStored);
        $statistics->recieveChangedImagedEvent($changedImageStored);

        //then
        self::assertSame(2000, $statistics->filesizeForResolution('200x200'));
    }

}
