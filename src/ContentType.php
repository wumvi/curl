<?php
declare(strict_types=1);

namespace Wumvi\Curl;

class ContentType
{
    public const CONTENT_TYPE = 'Content-Type';

    /** Content type @see https://ru.wikipedia.org/wiki/Multipart/form-data */
    public const MULTIPART_FORM_DATA = 'multipart/form-data';

    /** @see Content type */
    public const X_WWW_FORM_URLENCODED = 'application/x-www-form-urlencoded';

    public const JSON = 'application/json';
}
