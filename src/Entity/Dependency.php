<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
    ],
    paginationClientEnabled: false,
    paginationEnabled: false,
)]
class Dependency
{
    #[ApiProperty(
        identifier: true
    )]
    private string $uuid;
    #[ApiProperty(
        description: 'The name of the dependency',
        example: 'symfony/dependency-injection'
    )]
    private string $name;
    #[ApiProperty(
        description: 'The version of the dependency',
        example: 'v5.3.*'
    )]
    private string $version;

    public function __construct(string $uuid, string $name, string $version)
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->version = $version;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }
}