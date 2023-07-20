<?php

namespace OutlineManagerClient;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use OutlineManagerClient\Type\KeyType;
use OutlineManagerClient\Type\ServerType;

class OutlineClient
{
    private ClientInterface $client;

    public function __construct(string $apiUrl, ?ClientInterface $client = null)
    {
        if ($client === null) {
            $client = new Client([
                'base_uri' => $apiUrl,
                'verify' => false,
            ]);
        }

        $this->client = $client;
    }

    public function getServer(): ServerType
    {
        $body = (string)$this->client->get('server')->getBody();
        $result = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        return new ServerType($result);
    }

    public function setServerName(string $name): void
    {
        $this->client->put('name', [
            RequestOptions::JSON => [
                'name' => $name,
            ],
        ]);
    }

    public function setServerPortForNewKeys(int $port): void
    {
        $this->client->put('server/port-for-new-access-keys', [
            RequestOptions::JSON => [
                'port' => $port,
            ],
        ]);
    }

    /**
     * @return array<KeyType>
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getKeys(): array
    {
        $body = (string)$this->client->get('access-keys')->getBody();
        $result = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        $metrics = $this->getUsedBytes();
        $keys = [];

        foreach ($result['accessKeys'] as $key) {
            $key['usedBytes'] = $metrics[$key['id']] ?? null;
            $keys[$key['id']] = new KeyType($key);
        }

        return $keys;
    }

    public function getKeyById(int $id): ?KeyType
    {
        return $this->getKeys()[$id] ?? null;
    }

    public function addKey(string $name = null): KeyType
    {
        $body = (string)$this->client->post('access-keys', [
            RequestOptions::JSON => [
                'name' => $name,
            ],
        ])->getBody();

        $result = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        if ($name !== null) {
            $this->setKeyName($result['id'], $name);
            $result['name'] = $name;
        }

        return new KeyType($result);
    }

    public function deleteKey(int $id): void
    {
        $this->client->delete("access-keys/$id");
    }

    public function setKeyName(int $id, string $name): void
    {
        $this->client->put("access-keys/$id/name", [
            RequestOptions::JSON => [
                'name' => $name,
            ],
        ]);
    }

    /**
     * @return array<int>
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function getUsedBytes(): array
    {
        $body = (string)$this->client->get('metrics/transfer')->getBody();

        $result = json_decode($body, true, 512, JSON_THROW_ON_ERROR);

        return $result['bytesTransferredByUserId'];
    }

    public function setKeyDataLimit(int $id, int $bytes): void
    {
        $this->client->put("access-keys/$id/data-limit", [
            RequestOptions::JSON => [
                'limit' => [
                    'bytes' => $bytes,
                ],
            ],
        ]);
    }

    public function unsetKeyDataLimit(int $id): void
    {
        $this->client->delete("access-keys/$id/data-limit");
    }

    public function setDefaultDataLimit(int $bytes): void
    {
        $this->client->put('server/access-key-data-limit', [
            RequestOptions::JSON => [
                'limit' => [
                    'bytes' => $bytes,
                ],
            ],
        ]);
    }

    public function unsetDefaultDataLimit(): void
    {
        $this->client->delete('server/access-key-data-limit');
    }
}
