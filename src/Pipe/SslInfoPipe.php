<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

class SslInfoPipe extends Pipe implements MoreInfo
{
    /**
     * @param resource $curl
     *
     * @return $this|Pipe
     */
    public function apply($curl): Pipe
    {
        curl_setopt($curl, CURLOPT_CERTINFO, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

        return $this;
    }

    /**
     * @param resource $curl
     */
    public function remove($curl): void
    {
        curl_setopt($curl, CURLOPT_CERTINFO, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);
    }

    public function get($curl): array
    {
        return ['ssl' => curl_getinfo($curl, CURLINFO_CERTINFO)];
    }
}
