<?php

namespace Slince\Upload\Tests\Filesystem;

use PHPUnit\Framework\TestCase;
use Slince\Upload\Filesystem\Local;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LocalTest extends TestCase
{
    public function testUpload()
    {
        $filepath = __DIR__ . '/../Fixtures/hello.txt';
        $copyFilePath = __DIR__ . '/../Fixtures/hello-tmp.txt';
        copy($filepath, $copyFilePath);
        $file = new UploadedFile(
            $copyFilePath,
            'hello2.txt',
            'text/plain',
            null,
            true
        );
        $local = new Local(__DIR__ . '/../Fixtures/dst/');
        $file = $local->upload('hello-2.txt', $file);
        $this->assertContains(sys_get_temp_dir(), $file->getPathname());
    }
}