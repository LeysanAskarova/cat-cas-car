<?php
namespace App\Service;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader 
{
    /*
     * @var string
     */
    private $uploadsPath;
    public function __construct(string $uploadsPath)
    {
        $this->uploadsPath = $uploadsPath;
    }

    public function uploadFile(File $file): string
    {
        $newFilename = pathinfo(
            $file instanceof UploadedFile ? $file->getClientOriginalName() : $file->getFilename(),
                PATHINFO_FILENAME
            ).'-'.uniqid().'.'.$file->guessExtension();

        $file->move(
            $this->uploadsPath,
            $newFilename
        );

        // delete files if exists with filesystem

        return $newFilename;
    }
}