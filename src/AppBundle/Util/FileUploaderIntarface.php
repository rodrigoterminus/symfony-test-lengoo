<?php

namespace AppBundle\Util;

interface FileUploaderIntarface
{
    /**
     * Upload file to given path
     *
     * @return FileUploader
     */
    public function upload();

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName();
}