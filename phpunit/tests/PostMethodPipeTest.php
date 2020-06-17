<?php

use PHPUnit\Framework\TestCase;
use Wumvi\Curl\Curl;
use Wumvi\Curl\Pipe\PostMethodPipe;
use Wumvi\Curl\ContentType;

class PostMethodPipeTest extends TestCase
{
    public function testPostRequest(): void
    {
        $curl = new Curl();
        $curl->setUrl(CurlTest::HTTP_URL);
        $postPipe = new PostMethodPipe();
        $postPipe->setData('test=1');
        $curl->applyPipe($postPipe);

        $response = $curl->exec();
        $this->assertEquals('r=POST q= ht= pt=1 ', $response->getData(), 'apply post pipe');

        $postPipe->setData(['test' => 1,], ContentType::X_WWW_FORM_URLENCODED);
        $curl->applyPipe($postPipe);
        $response = $curl->exec();
        $this->assertEquals('r=POST q= ht= pt=1 ', $response->getData(), 'content type post pipe');

        $curl->removePipe($postPipe);
        $response = $curl->exec();
        $this->assertEquals('r=GET q= ht= pt= ', $response->getData(), 'remove post pipe');

        $curl->close();
    }
}
