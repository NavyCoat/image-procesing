# Requirements

- Images can be:
  - [ ] Scaled to a fixed resolution
  - [ ] Converted to other formats
- [ ] Images can be added through a web interface (form)
- [ ] Information about fact of adding an image should be stored
- [ ] Input images are stored
- [ ] Output images are stored
- [ ] Image needs to be stored optimally on a hard disk with the unique naming system
- [ ] System should collect some statistics using Redis
  - [ ] Case for implementation: Filesize of images in a given resolution

## Stack requirements
- [ ] PHP >8.0
- [ ] Laravel, Symfony or Yii
- [ ] Database migrations
- [ ] Some UI without CSS
- [ ] Docker
- [ ] Use queues if needed
- [ ] Tests for code/features
- [ ] Documentation of how the System works
- [ ] Result on GitHub

# Proposed solution

I found that the project can be split into four modules:
- Image processing
- Statistics
- Web interface for handling submissions for processing images (Submission Center)
- Image Storage

## Submission Center
The user is placing a submission for processing an image.
The original image is stored, and the Submission is sent to the image processing module.
And this is how it ends for the user now.
In the future, there can be an email sent when processing ends,
or webhook support can be added for users who want to wait on the page.

## Image processing
When Submission is received by image processing.
It contains a list of the tasks that need to be performed on Image to fulfill the Submission.
There is a process manager to handle order of changes and allows for future modifications in the process
For example, in the future, we may want to add the "Add smiling cats to the image" feature. There is a place to handle it.

## Statistics
Splitting statistics as a separate module allows for the Statistic team to try any ideas they want without
changes in Image Processing and Submission Center.
It's done by Events sent by the Submission Center and Image Processing.
The statistics team can implement anything they want to measure based on events in the System.

## Image Storage
Image processing needs to be able to receive the file from Submission Center to apply changes.
Also, after the Image is transformed, it needs to be stored. If, in the future, some processing will be done on different services,
they also need to be able to receive files. So there is a need for a separate module for handling storage.

## Image from Event Storming
![img.png](img.png)