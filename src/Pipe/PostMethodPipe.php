<?php
declare(strict_types=1);

namespace Wumvi\Curl\Pipe;

use Wumvi\Curl\ContentType;

class PostMethodPipe extends Pipe
{
    /**
     * @var mixed
     */
    protected $data;

    /**
     * PostMethodPipe constructor.
     *
     * @param mixed  $data
     *
     * @param string $contentType
     */
    public function __construct($data = '', string $contentType = '')
    {
        $this->setData($data, $contentType);
    }

    /**
     * @param resource $curl
     *
     * @return $this|Pipe
     */
    public function apply($curl): Pipe
    {
        curl_setopt($curl, CURLOPT_POST, true);

        if (!empty($this->data)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $this->data);
        }

        return $this;
    }

    /**
     * @param resource $curl
     */
    public function remove($curl): void
    {
        curl_setopt($curl, CURLOPT_POST, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, null);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
    }

    /**
     * @param mixed  $data
     * @param string $contentType
     *
     * @return $this|Pipe
     */
    public function setData($data, string $contentType = ''): Pipe
    {
        if ($contentType === ContentType::X_WWW_FORM_URLENCODED && is_array($data)) {
            $this->data = urldecode(http_build_query($data));
        } else {
            $this->data = $data;
        }

        return $this;
    }
}
