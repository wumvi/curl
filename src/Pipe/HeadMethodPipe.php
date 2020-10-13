<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

class HeadMethodPipe extends Pipe
{
    /**
     * @param resource $curl
     *
     * @return $this|Pipe
     */
    public function apply($curl): Pipe
    {
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'HEAD');

        return $this;
    }

    /**
     * @param resource $curl
     */
    public function remove($curl): void
    {
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_NOBODY, false);
    }
}
