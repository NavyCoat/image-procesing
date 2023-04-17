<?php


use App\ImageProcessing\Event\ImageFormatChanged;
use App\ImageProcessing\ProcessingEventsListener;
use PHPUnit\Framework\TestCase;

class ProcessTest extends TestCase
{
/*todo:
- Test if process is restored based on id from event
- Test if process is continued
- Test if process is finished...
*/
    public function testProcessCanBeContinued(){
        $ChangedImageFormat = new ImageFormatChanged();
        $listener = new ProcessingEventsListener();

        $listener->onImageFormatChanged($ChangedImageFormat);

        //valid process is restoeed based on id from event
        //process is continued
    }
}
