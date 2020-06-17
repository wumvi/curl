<?php

use PHPUnit\Framework\TestCase;
use Wumvi\Curl\Curl;
use Wumvi\Curl\Pipe\PostMethodPipe;

class CurlTest extends TestCase
{
    public const HTTP_URL = 'http://localhost:8884/http.php';
    private const HTTP_URL_TIMEOUT = 'http://localhost:8884/timeout-error.php';
    private const HTTP_URL_NO_FOLLOW = 'http://localhost:8884/http-redirect.php';
    private const HTTP_URL_WRONG_PROTOCOL = 'no://localhost:8884/';

    public function testGetRequest(): void
    {
        $curl = new Curl();
        $curl->setUrl(self::HTTP_URL);
        $response = $curl->exec();
        $this->assertEquals(200, $response->getHttpCode(), 'get request');
        $curl->close();
    }

    public function testReset(): void
    {
        $curl = new Curl();

        $postPipe = new PostMethodPipe();
        $postPipe->setData('test=1');
        $curl->applyPipe($postPipe);

        $curl->reset();
        $curl->setUrl(self::HTTP_URL);
        $response = $curl->exec();
        $this->assertEquals('r=GET q= ht= pt= ', $response->getData(), 'reset curl');

        $curl->close();
    }

    public function testGetHeaders(): void
    {
        $curl = new Curl();
        $curl->setUrl(self::HTTP_URL);
        $curl->setHeaderEchoFlag(true);
        $response = $curl->exec();
        $act = substr($response->getHeaders(), 0, 15);
        $this->assertEquals('HTTP/1.1 200 OK', $act, 'response headers');
        $curl->close();
    }

    public function testTimeout(): void
    {
        $this->expectException(\Wumvi\Curl\Exception\CurlTimeoutException::class);
        $curl = new Curl();
        $curl->setTimeout(1, 1);
        $curl->setUrl(self::HTTP_URL_TIMEOUT);
        $curl->exec();
    }

    public function testConnectionTimeout(): void
    {
        $this->expectException(\Wumvi\Curl\Exception\CurlConnectionTimeoutException::class);
        $curl = new Curl();
        $curl->setTimeout(2, 1);
        $curl->setUrl('http://localhost:8889/');
        $unixSocket = new \Wumvi\Curl\Pipe\UnixSocketPipe('no-unix-test.sock');
        $curl->applyPipe($unixSocket);
        $curl->exec();
    }

    public function testException(): void
    {
        $this->expectException(\Wumvi\Curl\Exception\CurlException::class);
        $curl = new Curl();
        $curl->setTimeout(1, 1);
        $curl->setUrl(self::HTTP_URL_WRONG_PROTOCOL);
        $curl->exec();
    }

    public function testNoFollow(): void
    {
        $curl = new Curl();
        $curl->setFollowLocationFlag(false);
        $curl->setUrl(self::HTTP_URL_NO_FOLLOW);
        $response = $curl->exec();
        $act = $response->getData();
        $this->assertEquals('no-follow', $act, 'response headers');
        $curl->close();
    }
}
