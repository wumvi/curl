<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

use Wumvi\Curl\Exception\CurlException;

class FileWriterPipe extends Pipe
{
    private string $outFile = '';

    public function __construct(string $outFile = '')
    {
        $this->setOutFilename($outFile);
    }

    /**
     * @param resource $curl
     * @return $this|Pipe
     */
    public function apply($curl): Pipe
    {
        if (!empty($this->outFile)) {
            $fwout = fopen($this->outFile, 'w');
            curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
            curl_setopt($curl, CURLOPT_WRITEFUNCTION, function ($curl, $data) use ($fwout) {
                if (!is_resource($fwout)) {
                    throw new CurlException('Wrong file descriptor');
                }
                fwrite($fwout, $data);

                return strlen($data);
            });
        }

        return $this;
    }

    /**
     * @param resource $curl
     */
    public function remove($curl): void
    {
        curl_setopt($curl, CURLOPT_BINARYTRANSFER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    }


    /**
     * @param string $outFile
     */
    public function setOutFilename(string $outFile): Pipe
    {
        $this->outFile = $outFile;

        return $this;
    }
}
