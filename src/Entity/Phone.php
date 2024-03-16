<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\PhoneRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\UX\Turbo\Attribute\Broadcast;

#[ORM\Entity(repositoryClass: PhoneRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['phone:read:collection']],
        ),
        new Get(
            normalizationContext: ['groups' => ['phone:read']],
        ),
    ],

    paginationClientEnabled: true,
)]
#[Broadcast]
class Phone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['phone:read:collection', 'phone:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['phone:read:collection', 'phone:read'])]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    #[Groups(['phone:read:collection', 'phone:read'])]
    private ?string $model = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    #[Groups(['phone:read'])]
    private ?string $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['phone:read'])]
    private ?array $colors = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['phone:read'])]
    private ?string $screenSize = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['phone:read'])]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getColors(): ?array
    {
        return $this->colors;
    }

    public function setColors(?array $colors): static
    {
        $this->colors = $colors;

        return $this;
    }

    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    public function setScreenSize(?string $screenSize): static
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
