<?php

namespace App\Framework;

class Image extends File
{
    private ?string $imageExist = null;

    private const VALID_EXTENSIONS = ['img', 'png', 'jpg', 'jpeg'];
    private const VALID_MIME_TYPES = ['image/png', 'image/jpeg'];

    public function __construct(array $file, string $imageExist = null)
    {
        $this->createFolderImage();
        parent::__construct($file);

        $this->imageExist = $imageExist;
    }

    private function checkMime(): void
    {
        $fileMimeInfo = mime_content_type($this->file['tmp_name']);

        if(!in_array($fileMimeInfo, self::VALID_MIME_TYPES))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
        }
    }

    private function checkExtension (): void
    { 
        $this->checkMime();
        
        $fileName = pathinfo($this->file['name']);
        $fileExtension = strtolower($fileName['extension']);

        if(!in_array($fileExtension, self::VALID_EXTENSIONS))
        {
            FlashBag::addFlash("L'extension du fichier n'est pas valide.", 'error');
        }
    }

    public function uploadFileImage(): null|string
    {
        $this->checkExtension();

        if(!FlashBag::hasMessages('error'))
        {
            $fileName = $this->generateRandomFileName();
            
            move_uploaded_file($this->file['tmp_name'], IMAGE_DIR .  '/' . $fileName);

            if (!empty($this->imageExist))
            {
                unlink(IMAGE_DIR . '/' . $this->imageExist);
            }

            return $fileName;
        }

        return null;
    }

    private function createFolderImage(): void
    {
        if (!file_exists(PROJECT_DIR . '/public/img/imgArticle'))
        {
            mkdir(PROJECT_DIR . '/public/img/imgArticle', 0777, true);
        }
    }
}