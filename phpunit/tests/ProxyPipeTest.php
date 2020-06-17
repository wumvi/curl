<?php

use PHPUnit\Framework\TestCase;
use Wumvi\Curl\Curl;
use Wumvi\Curl\Pipe\ProxyPipe;

class ProxyPipeTest extends TestCase
{
    public function testProxyPipe(): void
    {
        $curl = new Curl();
        $curl->setFollowLocationFlag(false);

        $curl->setUrl('https://yandex.ru/');
        $proxy = new ProxyPipe('docker:pwd@localhost:1080', ProxyPipe::SOCKS5);
        $curl->applyPipe($proxy);
        $response = $curl->exec();
        $this->assertEquals(200, $response->getHttpCode(), 'apply proxy pipe');

        $proxy->setProxy('socks5://docker:pwd@localhost:1080');
        $curl->applyPipe($proxy);
        $curl->setUrl('https://habr.com/ru/');
        $response = $curl->exec();
        $this->assertEquals(200, $response->getHttpCode(), 'apply proxy pipe type in url');

        $curl->removePipe($proxy);
        $response = $curl->exec();
        $this->assertEquals(200, $response->getHttpCode(), 'remove proxy pipe');

        $curl->close();
    }
}