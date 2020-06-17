[![Latest Stable Version](https://poser.pugx.org/wumvi/curl/v/stable?format=flat-square)](https://packagist.org/packages/wumvi/curl)
[![GitHub issues](https://img.shields.io/github/issues/wumvi/curl.svg?style=flat-square)](https://github.com/wumvi/curl/issues)
[![Build status](https://travis-ci.org/wumvi/curl.svg?branch=master)](https://travis-ci.org/wumvi/curl)
[![codecov](https://codecov.io/gh/wumvi/curl/branch/master/graph/badge.svg)](https://codecov.io/gh/wumvi/curl)
[![Maintainability](https://api.codeclimate.com/v1/badges/943689de2ecb8ae407ac/maintainability)](https://codeclimate.com/github/wumvi/curl/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/943689de2ecb8ae407ac/test_coverage)](https://codeclimate.com/github/wumvi/curl/test_coverage)


##### Example
```php
$curl = new \Wumvi\Curl\Curl();
$curl->setUrl('http://localhost:8883');
$response = $curl->exec();
var_dump($response->getData());
$curl->close();
```

##### Multi exec Example
```php
$curl = new \Wumvi\Curl\Curl();
$curl->setUrl('http://localhost:8883');
$response = $curl->exec();
var_dump($response->getData());
$response = $curl->exec();
var_dump($response->getData());
$curl->close();
```

##### Post request
```php
use \Wumvi\Curl\Pipe\PostMethodPipe;
$post = new PostMethodPipe();
$curl->applyPipe($post);
// $curl->removePipe($post);
```

##### Write response to the file
```php
use \Wumvi\Curl\Pipe\FileWriterPipe;
$fileWriter = new FileWriterPipe('test.txt');
$curl->applyPipe($fileWriter);
// $curl->removePipe($fileWriter);
```

##### Add custom header
```php
use \Wumvi\Curl\Pipe\HeaderPipe;
$header = new HeaderPipe([
    'Data' => 1,
]);
$curl->applyPipe($header);
//$curl->removePipe($header);
```

```php
use \Wumvi\Curl\ContentType;
use \Wumvi\Curl\Pipe\HeaderPipe;
$header = new HeaderPipe([
    ContentType::CONTENT_TYPE => 'text/html',
]);
$curl->applyPipe($header);
//$curl->removePipe($header);
```

##### Send file as PUT request
````php
use \Wumvi\Curl\Pipe\PutMethodPipe;
$put = new PutMethodPipe();
$put->setFile('z:\1.txt');
$curl->applyPipe($put);
// $curl->removePipe($put);
````

##### Use proxy
```php
use \Wumvi\Curl\Pipe\ProxyPipe;
$curl->setUrl('http://ya.ru/');
$proxy = new ProxyPipe('socks5://docker:pwd@localhost:1080');
$curl->applyPipe($proxy);
//$curl->removePipe($proxy);
```
or

```php
use \Wumvi\Curl\Pipe\ProxyPipe;
$curl->setUrl('http://ya.ru/');
$proxy = new ProxyPipe('docker:pwd@localhost:1080', ProxyPipe::SOCKS5);
$curl->applyPipe($proxy);
``` 
##### Send request to unix socket
```php
use \Wumvi\Curl\Pipe\UnixSocketPipe;
$curl->setUrl('http://localhost:8883/?url=3');
$unixSocket = new UnixSocketPipe('unix-test.sock');
$curl->applyPipe($unixSocket);
// $curl->removePipe($unixSocket);
```

##### Get response status code
```php
$response = $curl->exec();
echo $response->getHttpCode();
```

##### Get response text
```php
$response = $curl->exec();
echo $response->getData();
```

##### Get response Headers 
```php
$response = $curl->exec();
echo $response->getHeaders();
```

##### Reset settings
```php
$curl->reset();
```

##### Verbose mode
```php
$curl->setVerboseFlag(true);
```

##### Short code
```php
use \Wumvi\Curl\Pipe\PostMethodPipe;
$curl->applyPipe((new PostMethodPipe())->setData('post-data'));
```

##### Check unix socket

```bash
curl -X GET --unix-socket tmp/unix-test.sock http://image.json
```

