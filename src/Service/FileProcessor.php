<?php
declare(strict_types=1);

namespace ClickMeeting\Service;

use \Gumlet\ImageResize;
use Gumlet\ImageResizeException;
use Symfony\Component\HttpFoundation\Response;

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

    public function processFiles(array $fileNames, array $tmpFilePath, string $uploadPath, int $width, int $height): self
    {
        $totalFiles = count($fileNames);
        for($i = 0; $i < $totalFiles; $i++) {
            $filePath = $tmpFilePath[$i];
            $image = new ImageResize($filePath);
            $image->scale(50);
            $image->save($uploadPath . $fileNames[$i]);
            $this->fileZipper->addFileToArchive($uploadPath . $fileNames[$i]);
        }
        
        return $this;
    }

    public function createArchive(string $path, string $archiveName): self
    {
        $this->fileZipper->createArchive($path, $archiveName);
        $this->responseBuilder->setDownloadPath($path, $archiveName);
        return $this;
    }

    public function returnAttachmentResponse(): Response
    {
        return $this->responseBuilder->buildResponse();
    }
    
}