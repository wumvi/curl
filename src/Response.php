<?php
declare(strict_types=1);

namespace Wumvi\Curl;

/**
 * Модель ответа запроса
 */
class Response
{
    /** @var int Код ответа */
    private int $httpCode;

    /** @var string Данные ответа */
    private string $data;

    /** @var string Headers */
    private string $headers;

    /**
     * Result constructor.
     *
     * @param int $httpCode Код ответа
     * @param string $data Данные ответа
     * @param string $headers Заголовки
     */
    public function __construct(int $httpCode, string $data, string $headers)
    {
        $this->httpCode = $httpCode;
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * Получаем код ответа
     *
     * @return int Код ответа
     */
    public function getHttpCode(): int
    {
        return $this->httpCode;
    }

    /**
     * Получаем данные ответа
     *
     * @return string Данные ответа
     */
    public function getData(): string
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getHeaders(): string
    {
        return $this->headers;
    }
}
