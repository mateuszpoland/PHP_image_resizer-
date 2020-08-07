<?php
declare(strict_types=1);

namespace ClickMeeting\Service;

use \Gumlet\ImageResize;
use Gumlet\ImageResizeException;

class FileProcessor
{
    const MAX_LONGER_SIDE_LENGTH = 150;

    private $responseBuilder;

    private $fileZipper;

    public function __construct
    (
        ResponseBuilder $responseBuilder,
        FileZipper $fileZipper
    )
    {
        $this->responseBuilder = $responseBuilder;
        $this->fileZipper = $fileZipper;
    }

    public function processFiles(array $fileNames, string $uploadPath, int $width, int $height)
    {
        foreach($fileNames as $fileName) {
            var_dump($uploadPath . '/' . $fileName);
            $image = new ImageResize($uploadPath . '/' . $fileName);
            $image->resizeToLongSide(200);
            $image->save('file_processed.png');
        }  
    }
}