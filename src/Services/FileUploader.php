<?php
// src/Service/FileUploader.php
namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $publicDir;

    private $targetDir;

    private $path;

    public function __construct($publicDir)
    {
        $this->publicDir = $publicDir;
    }

    public function to($path = '/')
    {
        $this->path = $path;
        return $this;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function getTargetDir()
    {
        return $this->getPublicDir().$this->getPath();
    }

    public function getPublicDir()
    {
        return $this->publicDir;
    }

    public function getPath()
    {
        return $this->path;
    }
}