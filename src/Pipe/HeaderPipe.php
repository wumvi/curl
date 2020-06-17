<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

class HeaderPipe extends Pipe
{
    /**
     * @var array<mixed>
     */
    private array $headers = [];

    /**
     * HeaderPipe constructor.
     *
     * @param array<mixed> $headers
     */
    public function __construct(array $headers)
    {
        $this->setHeader($headers);
    }

    /**
     * @param resource $curl
     *
     * @return $this|Pipe
     */
    public function apply($curl): Pipe
    {
        $headers = array_map(fn($key, $item) => $key . ': ' . $item, array_keys($this->headers), $this->headers);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        return $this;
    }

    /**
     * @param resource $curl
     */
    public function remove($curl): void
    {
        curl_setopt($curl, CURLOPT_HTTPHEADER, []);
    }

    /**
     * @param  array<mixed> $headers
     * @return $this|Pipe
     */
    public function setHeader(array $headers): Pipe
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * @return array<mixed>
     */
    public function getHeader(): array
    {
        return $this->headers;
    }
}
