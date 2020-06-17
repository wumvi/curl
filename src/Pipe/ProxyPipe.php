<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

class ProxyPipe extends Pipe
{
    public const NONE = -1;
    public const SOCKS5 = CURLPROXY_SOCKS5;
    public const SOCKS4 = CURLPROXY_SOCKS4;
    public const HTTP = CURLPROXY_HTTP;

    private int $type = self::NONE;
    private string $url = '';

    public function __construct(string $url, int $type = self::NONE)
    {
        $this->type = $type;
        $this->url = $url;
    }

    /**
     * @param resource $curl
     *
     * @return $this|Pipe
     */
    public function apply($curl): Pipe
    {
        curl_setopt($curl, CURLOPT_PROXY, $this->url);
        if ($this->type !== self::NONE) {
            curl_setopt($curl, CURLOPT_PROXYTYPE, $this->type);
        }
        return $this;
    }

    /**
     * @param resource $curl
     */
    public function remove($curl): void
    {
        curl_setopt($curl, CURLOPT_PROXYTYPE, null);
        curl_setopt($curl, CURLOPT_PROXY, null);
    }

    public function setProxy(string $url, int $type = self::NONE): Pipe
    {
        $this->url = $url;
        $this->type = $type;

        return $this;
    }
}
