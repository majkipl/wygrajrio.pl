<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    /**
     * @param string $targetDirectory
     */
    public function __construct(private string $targetDirectory)
    {
    }

    /**
     * @throws Exception
     */
    public function upload(UploadedFile $file): string
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();

        try {
            $file->move($this->targetDirectory, $fileName);
        } catch (Exception) {
            throw new Exception('Wystąpił błąd podczas zapisu pliku.');
        }

        return $fileName;
    }
}
