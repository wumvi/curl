<?php
declare(strict_types=1);

namespace Wumvi\Curl;

use Wumvi\Curl\Exception\CurlConnectionTimeoutException;
use Wumvi\Curl\Exception\CurlException;
use Wumvi\Curl\Exception\CurlTimeoutException;
use Wumvi\Curl\Pipe\Pipe;

class Curl implements ICurl
{
    public const TIMEOUT_WAIT = 2;
    public const TIMEOUT_CONNECT = 1;

    /** @var resource */
    protected $curl;

    /** @var bool */
    protected bool $isHeaderEcho = false;

    public function __construct()
    {
        $this->curl = curl_init();
        $this->initDefault();
    }

    private function initDefault(): void
    {
        curl_setopt_array($this->curl, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CONNECTTIMEOUT => self::TIMEOUT_CONNECT,
            CURLOPT_TIMEOUT => self::TIMEOUT_WAIT,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HEADER => $this->isHeaderEcho
        ]);
    }

    public function setUrl(string $url): void
    {
        curl_setopt($this->curl, CURLOPT_URL, $url);
    }

    public function setHeaderEchoFlag(bool $flag): void
    {
        curl_setopt($this->curl, CURLOPT_HEADER, $flag);
        $this->isHeaderEcho = $flag;
    }

    public function setFollowLocationFlag(bool $flag): void
    {
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, $flag);
    }

    public function setTimeout(int $wait = self::TIMEOUT_WAIT, int $connect = self::TIMEOUT_CONNECT): void
    {
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $wait);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $connect);
    }

    /**
     * @param bool $flag
     *
     * @codeCoverageIgnore
     */
    public function setVerboseFlag(bool $flag): void
    {
        curl_setopt($this->curl, CURLOPT_VERBOSE, $flag);
    }

    /**
     * @param string $encoding
     *
     * @codeCoverageIgnore
     */
    public function setEncoding(string $encoding): void
    {
        curl_setopt($this->curl, CURLOPT_ENCODING, $encoding);
    }

    public function applyPipe(Pipe $pipe): void
    {
        $pipe->apply($this->curl);
    }

    public function removePipe(Pipe $pipe): void
    {
        $pipe->remove($this->curl);
    }

    /**
     * @param resource $curl
     *
     * @return int
     *
     * @throws CurlException
     */
    private function getHttpCode($curl): int
    {
        $errorCode = curl_errno($curl);
        if ($errorCode === 0) {
            return (int)curl_getinfo($curl, CURLINFO_HTTP_CODE);
        }

        if ($errorCode === CURLE_COULDNT_CONNECT) {
            throw new CurlConnectionTimeoutException();
        }

        if ($errorCode === CURLE_OPERATION_TIMEDOUT) {
            throw new CurlTimeoutException();
        }

        throw new CurlException(curl_error($curl), curl_errno($curl));
    }

    public function exec(): Response
    {
        $rawData = curl_exec($this->curl) ?: '';
        if ($rawData === true) {
            $rawData = '';
        }
        $httpCode = $this->getHttpCode($this->curl);

        $headers = '';
        $body = $rawData;
        if ($this->isHeaderEcho) {
            $headerSize = curl_getinfo($this->curl, CURLINFO_HEADER_SIZE);
            $headers = substr($rawData, 0, $headerSize);
            $body = substr($rawData, $headerSize);
        }

        return new Response($httpCode, $body, $headers);
    }

    public function reset(): void
    {
        curl_reset($this->curl);
        $this->initDefault();
    }

    public function close(): void
    {
        curl_close($this->curl);
    }
}
