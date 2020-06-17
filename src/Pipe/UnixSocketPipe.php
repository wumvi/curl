<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

class UnixSocketPipe extends Pipe
{
    private string $socket = '';

    public function __construct(string $socket)
    {
        $this->setSocket($socket);
    }

    /**
     * @param resource $curl
     *
     * @return $this|Pipe
     */
    public function apply($curl): Pipe
    {
        curl_setopt($curl, CURLOPT_UNIX_SOCKET_PATH, $this->socket);

        return $this;
    }

    /**
     * @param resource $curl
     */
    public function remove($curl): void
    {
        curl_setopt($curl, CURLOPT_UNIX_SOCKET_PATH, null);
    }

    public function setSocket(string $socket): Pipe
    {
        $this->socket = $socket;

        return $this;
    }
}
