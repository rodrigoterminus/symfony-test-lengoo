<?php

namespace AppBundle\Util;

use Symfony\Component\HttpFoundation\File\File;

class FileUploader implements FileUploaderIntarface
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * @var string
     */
    private $path;

    /**
     * FileUploader constructor.
     *
     * @param File $file
     * @param string $path
     */
    public function __construct(File $file, $path)
    {
        $this->file = $file;
        $this->path = $path;
    }

    /**
     * Upload file to given path
     *
     * @return FileUploader
     */
    public function upload() {
        $this->fileName = md5(uniqid()).'.'.$this->file->guessExtension();

        $this->file->move(
            $this->path,
            $this->fileName
        );

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName() {
        return $this->fileName;
    }
}