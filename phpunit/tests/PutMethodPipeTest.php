<?php

use PHPUnit\Framework\TestCase;
use Wumvi\Curl\Curl;
use Wumvi\Curl\Pipe\PutMethodPipe;

class PutMethodPipeTest extends TestCase
{
    public function testPutMethodPipe(): void
    {
        $curl = new Curl();
        $curl->setFollowLocationFlag(false);

        $curl->setUrl('http://localhost:8884/put-method.php');
        $putMethodPipe = new PutMethodPipe();
        $putMethodPipe->setFile('dev/test-file.txt');
        $curl->applyPipe($putMethodPipe);
        $response = $curl->exec();
        $this->assertEquals('r=PUT 987', $response->getData(), 'apply proxy pipe');

        $curl->removePipe($putMethodPipe);
        $response = $curl->exec();
        $this->assertEquals('r=GET ', $response->getData(), 'remove proxy pipe');

        $curl->close();
    }
}