<?php
/**
 * Created by PhpStorm.
 * User: rodrigo
 * Date: 07/07/17
 * Time: 12:50
 */

namespace AppBundle\Util;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\File;
use Mockery as m;

class FileUploaderTest extends TestCase
{
    /**
     * @var FileUploader
     */
    private $fileUploader;

    /**
     * @var \Mockery
     */
    private $fileMock;

    public function setUp()
    {
        $this->fileMock = m::mock(File::class);
        $this->fileUploader = new FileUploader($this->fileMock, '/foo/bar');
    }

    public function testIfMailerImplementsMailerInterface()
    {
        $this->assertInstanceOf(FileUploaderIntarface::class, $this->fileUploader);
    }

    public function testIfUploadIsSuccessful()
    {
        $this->fileMock->shouldReceive('guessExtension')->once()->andReturn('txt');
        $this->fileMock->shouldReceive('move')->once()->andReturn(m::mock(File::class));

        $return = $this->fileUploader->upload();
        $fileReflectionProperty = new \ReflectionProperty($return, 'file');
        $fileReflectionProperty->setAccessible(true);
        $file = $fileReflectionProperty->getValue($return);

        $pathReflectionProperty = new \ReflectionProperty($return, 'path');
        $pathReflectionProperty->setAccessible(true);
        $path = $pathReflectionProperty->getValue($return);

        $this->assertInstanceOf(File::class, $file);
        $this->assertEquals('/foo/bar', $path);
        $this->assertEquals('/foo/bar', $path);
    }
}
