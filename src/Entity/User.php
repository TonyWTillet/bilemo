<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use mysql_xdevapi\CollectionFind;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\UX\Turbo\Attribute\Broadcast;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

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
            validationContext: ['groups' => ['Default', 'user:write']]
        ),
        new Put(
            validationContext: ['groups' => ['Default', 'user:write']]
        ),
        new Delete(
            security: "is_granted('ROLE_ADMIN') or object.getCustomer() == user",
            securityMessage: "Access denied. Only owners can delete their user."
        ),
    ],
    denormalizationContext: ['groups' => ['user:write']],
    paginationClientEnabled: true,
)]

#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'email' => 'partial', 'firstname' => 'partial', 'lastname' => 'partial'])]
#[Broadcast]
#[UniqueEntity('email')]

class User implements CustomerOwnedInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read:collection','user:read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(name: "customer_id", referencedColumnName: "id", nullable: false, onDelete: "CASCADE")]
    #[Groups(['user:read:collection', 'user:read'])]
    #[ApiProperty(readableLink: false, writableLink: false)]
    private ?Customer $customer = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $firstname = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $lastname = null;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[Groups(['user:read:collection','user:read', 'user:write'])]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[Groups(['user:read', 'user:write'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

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


}
