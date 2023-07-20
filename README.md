# OutlineVPN Manager Client

Outline manager client for PHP projects ([OutlineVPN](https://getoutline.org/)).

## Installation

Install the latest version with

```bash
$ composer require edvardpotter/outline-manager-client
```

## Requirements

PHP >= 7.4

## How to use

### Usage

```php

<?php
require 'vendor/autoload.php';

use OutlineManagerClient\OutlineClient;

$url = 'https://1.1.1.1:5155/lrd5SuLajnsTIdvszo_VA/';

/* Create outline client */
$api = new OutlineClient($url);

/* Or create with your own guzzle http client */
$guzzleClient = new \GuzzleHttp\Client([
    'uri' => $url
]);

$api = new OutlineClient('', $guzzleClient);

/* Get server info */
$server = $api->getServer();
echo $server->getName();
echo $server->getServerId();
echo $server->getVersion();
echo $server->getHostnameForAccessKeys();
echo $server->getPortForNewAccessKeys();
echo $server->getCreatedTimestampMs();

/* Set server name */
$api->setServerName('My outline server');

/* Set server port */
$api->setServerPortForNewKeys(42314);

/* Get array key collection (array<id, KeyType>) */
$keysList = $api->getKeys();
foreach ($keysList as $id => $key) {
    echo $key->getId();
    echo $key->getName();
    echo $key->getUsedBytes();
    echo $key->getAccessUrl();
    echo $key->getPort();
    /* ... */
}

/* Create new key with name */
$key = $api->addKey('First key');

/* Or set key after creating */
$key = $api->addKey();
$api->setKeyName($key->getId(), 'First key');

/* Get key by id */
$api->getKeyById(123);

/* Set key data limit in bytes by key id. In the example set 10GB */
$api->setKeyDataLimit($key->getId(), 10 * 1024 * 1024 *1024);

/* Unset key data limit by key id */
$api->unsetKeyDataLimit($key->getId());

/* Delete key */
$api->deleteKey($key->getId());

/* Set default data limit (for all keys) */
$api->setDefaultDataLimit(10 * 1024 * 1024 *1024);

/* Unset default data limit */
$api->unsetDefaultDataLimit();

/* Get an array of used traffic for all keys */
$usedBytes = $api->getUsedBytes();
```
