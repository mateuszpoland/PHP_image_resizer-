<?php
declare(strict_types=1);

namespace ClickMeeting\Tests\Service;

use ClickMeeting\Service\FileProcessor;
use PHPUnit\Framework\TestCase;

class FileProcessorTest extends TestCase
{
    public function testWillCropFilesAndSaveThemOnDisc(): void
    {
        $fileProcessor = $this->getFileProcessorInstance();
        $fileProcessor->processFile($width, $height);
    }

    private function getFileProcessorInstance(): FileProcessor
    {
        return new FileProcessor();
    }
}