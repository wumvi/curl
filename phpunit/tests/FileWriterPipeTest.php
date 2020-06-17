<?php

use PHPUnit\Framework\TestCase;
use Wumvi\Curl\Curl;
use Wumvi\Curl\Pipe\FileWriterPipe;

class FileWriterPipeTest extends TestCase
{
    public function testFileWriter(): void
    {
        $curl = new Curl();
        $curl->setFollowLocationFlag(false);
        $curl->setUrl(CurlTest::HTTP_URL);

        $file = 'tmp/test.txt';
        $filePipe = new FileWriterPipe($file);
        $curl->applyPipe($filePipe);
        $response = $curl->exec();
        $act = $response->getData();
        $this->assertEquals('', $act, 'empty response');
        $this->assertEquals('r=GET q= ht= pt= ', @file_get_contents($file), 'file response');

        $curl->removePipe($filePipe);
        $response = $curl->exec();
        $this->assertEquals('r=GET q= ht= pt= ', $response->getData(), 'remove unix pipe');

        $curl->close();
    }
}
