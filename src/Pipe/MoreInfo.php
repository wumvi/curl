<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

interface MoreInfo
{
    /**
     * @param resource $curl
     *
     * @return array
     */
    public function get($curl): array;
}
