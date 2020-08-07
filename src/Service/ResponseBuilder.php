<?php
declare(strict_types=1);

namespace ClickMeeting\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\File\File;

class ResponseBuilder
{
    private $downloadPath;

    public function buildResponse(): Response
    {
        if(!$this->downloadPath) {
            return new Response('Attachment not found', Response::HTTP_NOT_FOUND);
        }
        $response = new Response(file_get_contents($this->downloadPath));
        $disp = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                'downloaded.zip'
        );
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-length', filesize($this->downloadPath));
        $response->headers->set('Content-Disposition', $disp);
        return $response;
    }

    public function setDownloadPath(string $path, string $archiveName): void
    {
        $this->downloadPath = $path . $archiveName;
    }
}