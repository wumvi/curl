<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

class PutMethodPipe extends Pipe
{
    private string $file;

    /**
     * @param resource $curl
     *
     * @return $this|Pipe
     */
    public function apply($curl): Pipe
    {
        curl_setopt($curl, CURLOPT_PUT, true);
        if (!empty($this->file)) {
            curl_setopt($curl, CURLOPT_INFILE, fopen($this->file, 'r'));
            curl_setopt($curl, CURLOPT_INFILESIZE, filesize($this->file));
        }
        curl_setopt($curl, CURLOPT_PUT, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');

        return $this;
    }

    /**
     * @param resource $curl
     */
    public function remove($curl): void
    {
        curl_setopt($curl, CURLOPT_PUT, false);
        curl_setopt($curl, CURLOPT_INFILE, null);
        curl_setopt($curl, CURLOPT_INFILESIZE, null);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    }

    public function setFile(string $file): Pipe
    {
        $this->file = $file;

        return $this;
    }
}
