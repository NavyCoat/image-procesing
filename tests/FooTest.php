<?php


use PHPUnit\Framework\TestCase;

class FooTest extends TestCase
{

    public function testSubmission()
    {
        //arrange
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
        $originalImageStored = new OriginalImageStored();

        //When
        $statistics->recieve($originalImageStored);

        //then
        self::assertSame(1, $statistics->imagesStored);
    }

    public function testFilesizesForResolution()
    {
        //arrange
        $originalImageStored = new OriginalImageStored(size: 1000, resolution: '200x200');
        $changedImageStored = new ChangedImageStored(size: 1000, resolution: '200x200');

        //When
        $statistics->recieve($originalImageStored);
        $statistics->recieve($changedImageStored);

        //then
        self::assertSame(2000, $statistics->filesizeForResolution('200x200'));
    }


}
