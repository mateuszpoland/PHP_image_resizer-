<?php
declare(strict_types=1);

namespace ClickMeeting\Service;

use ZipArchive;

class FileZipper 
{
    private $filePathsToArchive = [];

    public function addFileToArchive(string $filePath)
    {
        $this->filePathsToArchive[] = $filePath;
    }

    public function createArchive(string $path, string $archiveName)
    {
        $zip = new ZipArchive();
        if(!empty($this->filePathsToArchive)){
            if ($zip->open($path . $archiveName, ZipArchive::CREATE) === TRUE) {
                foreach($this->filePathsToArchive as $filePath) {
                    $zip->addFile($filePath);
                }
                $zip->close();
            }
        }
        

    }
}