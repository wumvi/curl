<?php
declare(strict_types=1);

namespace Wumvi\Curl;

use Wumvi\Curl\Pipe\Pipe;

interface ICurl
{
    public function setUrl(string $url): void;

    public function setHeaderEchoFlag(bool $flag): void;

    public function setFollowLocationFlag(bool $flag): void;

    public function setTimeout(int $wait, int $connect): void;

    public function setVerboseFlag(bool $flag): void;

    public function setEncoding(string $encoding): void;

    public function applyPipe(Pipe $pipe): void;

    public function removePipe(Pipe $pipe): void;

    public function exec(): Response;

    public function reset(): void;

    public function close(): void;
}
