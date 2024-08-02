<?php

namespace App\Doctrine;

use ApiPlatform\Doctrine\Orm\Extension\QueryCollectionExtensionInterface;
use ApiPlatform\Doctrine\Orm\Extension\QueryItemExtensionInterface;
use ApiPlatform\Doctrine\Orm\Util\QueryNameGeneratorInterface;
use ApiPlatform\Metadata\Operation;
use App\Entity\CustomerOwnedInterface;
use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use ReflectionClass;
use ReflectionException;
use Symfony\Bundle\SecurityBundle\Security;

class CurrentUserExtension implements QueryCollectionExtensionInterface, QueryItemExtensionInterface
{

    public function __construct(private Security $security)
    {
    }

    /**
     * @throws ReflectionException
     */
    public function applyToCollection(QueryBuilder $queryBuilder,
                                      QueryNameGeneratorInterface $queryNameGenerator,
                                      string $resourceClass,
                                      ?Operation $operation = null,
                                      array $context = []): void
    {
        $this->addWhere($resourceClass, $queryBuilder);
    }

    /**
     * @throws ReflectionException
     */
    public function applyToItem(QueryBuilder $queryBuilder, QueryNameGeneratorInterface $queryNameGenerator, string $resourceClass, array $identifiers, ?Operation $operation = null, array $context = []): void
    {
        $this->addWhere($resourceClass, $queryBuilder);
    }

    /**
     * @throws ReflectionException
     */
    private function addWhere(string $resourceClass, QueryBuilder $queryBuilder): void
    {
        $reflexionClass = new ReflectionClass($resourceClass);
        if ($reflexionClass->implementsInterface(CustomerOwnedInterface::class)) {
            $alias = $queryBuilder->getRootAliases()[0];
            $queryBuilder
                ->andWhere("$alias.customer = :current_user")
                ->setParameter('current_user', $this->security->getUser()->getId());
        }

    }
}