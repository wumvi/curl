<?php

use PHPUnit\Framework\TestCase;
use Wumvi\Curl\Curl;
use Wumvi\Curl\Pipe\UnixSocketPipe;

class UnixSocketPipeTest extends TestCase
{
    public function testUnixSocket(): void
    {
        $curl = new Curl();
        $curl->setTimeout(2, 1);
        $curl->setUrl(CurlTest::HTTP_URL);

        $unixSocket = new UnixSocketPipe('tmp/unix-test.sock');
        $curl->applyPipe($unixSocket);
        $response = $curl->exec();
        $this->assertEquals('123', $response->getData(), 'Read from unix socket');

        $curl->removePipe($unixSocket);
        $response = $curl->exec();
        $this->assertEquals('r=GET q= ht= pt= ', $response->getData(), 'remove unix pipe');

        $curl->close();
    }
}
