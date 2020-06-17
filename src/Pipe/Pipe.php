<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

abstract class Pipe
{
    /**
     * @param resource $curl
     *
     * @return Pipe
     */
    abstract public function apply($curl): Pipe;

    /**
     * @param resource $curl
     */
    abstract public function remove($curl): void;
}
