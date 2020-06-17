<?php

use PHPUnit\Framework\TestCase;
use Wumvi\Curl\Curl;
use Wumvi\Curl\Pipe\HeaderPipe;

class HeaderPipeTest extends TestCase
{
    public function testHeaderPipe(): void
    {
        $curl = new Curl();
        $curl->setFollowLocationFlag(false);
        $curl->setUrl(CurlTest::HTTP_URL);

        $headerPipe = new HeaderPipe([
            'Data' => 1,
        ]);
        $curl->applyPipe($headerPipe);
        $response = $curl->exec();
        $this->assertEquals('r=GET q= ht=1 pt= ', $response->getData(), 'apply header pipe');

        $this->assertEquals(['Data' => 1,], $headerPipe->getHeader(), 'get headers');

        $curl->removePipe($headerPipe);
        $response = $curl->exec();
        $this->assertEquals('r=GET q= ht= pt= ', $response->getData(), 'remove header pipe');

        $curl->close();
    }
}
