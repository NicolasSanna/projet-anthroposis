<?php

namespace App\Framework;

abstract class File
{
    protected array $file;

    protected function __construct(array $file)
    {
        $this->file = $file;
    }

    protected function checkSize(): void
    {
        if($this->file['size'] > 2000000)
        {
            FlashBag::addFlash("Le fichier est trop volumineux (plus de 2Mo)", 'error');
        }
    }

    protected function generateRandomFileName(): string
    {
        $this->checkSize();

        $fileName = pathinfo($this->file['name']);
        $fileExtension = strtolower($fileName['extension']);

        $uniqueName = time()+ rand(1, 1000);
        $fileName = slugify($fileName['filename']) . '-' . $uniqueName . '.' . $fileExtension;

        return $fileName;
    }
}