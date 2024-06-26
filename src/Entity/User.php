<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\UserRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Validator\Constraints\UserMinimalProperties;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            normalizationContext: ['groups' => ['user:read:collection']],
        ),
        new Get(
            normalizationContext: ['groups' => ['user:read', 'customer:read']],
        ),
        new Post(
            normalizationContext: ['groups' => ['user:read:post']],
            denormalizationContext: ['groups' => ['user:post']],
            validationContext: ['groups' => ['user:post']]
        ),
        new Patch(
            normalizationContext: ['groups' => ['user:read:patch']],
            denormalizationContext: ['groups' => ['user:patch']],
            validationContext: ['groups' => ['user:patch']],
        ),
        new Delete(
            securityMessage: "Access denied. Only owners can delete their user."
        ),
    ],

    paginationClientEnabled: true,
)]

#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'email' => 'partial', 'firstname' => 'partial', 'lastname' => 'partial'])]
#[Broadcast]
#[UniqueEntity('email', message: 'This email is already used', groups: ['user:post', 'user:patch'])]
class User implements CustomerOwnedInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read:collection','user:read', 'user:read:post', 'user:read:patch', 'user:patch', 'user:post'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    #[Groups(['user:read:collection', 'user:read:post', 'user:read:patch','user:read', 'customer:read'])]
    #[ApiProperty(readableLink: true, writableLink: true)]
    private ?Customer $customer = null;

    #[Assert\NotBlank(message: "This propertie cannot be empty", groups: ['user:post', 'user:patch'])]
    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:read:post', 'user:read:patch','user:patch', 'user:post'])]
    private ?string $firstname = null;

    #[Assert\NotBlank(message: "This propertie cannot be empty", groups: ['user:post', 'user:patch'])]
    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:read:post', 'user:read:patch','user:patch', 'user:post'])]
    private ?string $lastname = null;

    #[Assert\NotBlank(message: "This propertie cannot be empty", groups: ['user:post', 'user:patch'])]
    #[Assert\Email(message: "This email is not valid", groups: ['user:post', 'user:patch'])]
    #[Groups(['user:read:collection','user:read', 'user:read:post', 'user:read:patch','user:patch', 'user:post'])]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[Groups(['user:read', 'user:read:post', 'user:read:patch','user:patch', 'user:post'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'user:read:post'])]
    private ?DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'user:read:patch','user:patch'])]
    private ?DateTimeImmutable $updated_at = null;

    public function __construct()
    {
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }


}
