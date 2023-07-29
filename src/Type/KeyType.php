<?php

namespace OutlineManagerClient\Type;

class KeyType extends AbstractType
{
    protected int $id;
    protected string $name;
    protected string $password;
    protected int $port;
    protected string $method;
    protected ?int $dataLimit = null;
    protected string $accessUrl;
    protected ?int $usedBytes = null;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getDataLimit(): ?int
    {
        return $this->dataLimit;
    }

    public function getAccessUrl(): string
    {
        return $this->accessUrl;
    }

    public function getUsedBytes(): ?int
    {
        return $this->usedBytes;
    }
}
