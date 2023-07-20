<?php

namespace OutlineManagerClient\Type;

class ServerType extends AbstractType
{
    protected string $name;
    protected string $serverId;
    protected bool $metricsEnabled;
    protected int $createdTimestampMs;
    protected string $version;
    protected int $portForNewAccessKeys;
    protected string $hostnameForAccessKeys;

    public function getName(): string
    {
        return $this->name;
    }

    public function getServerId(): string
    {
        return $this->serverId;
    }

    public function isMetricsEnabled(): bool
    {
        return $this->metricsEnabled;
    }

    public function getCreatedTimestampMs(): int
    {
        return $this->createdTimestampMs;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getPortForNewAccessKeys(): int
    {
        return $this->portForNewAccessKeys;
    }

    public function getHostnameForAccessKeys(): string
    {
        return $this->hostnameForAccessKeys;
    }
}
