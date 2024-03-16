<?php

namespace App\Serializer;

use App\Entity\CustomerOwnedInterface;
use ReflectionClass;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Mime\Encoder\ContentEncoderInterface;
use Symfony\Component\Serializer\Encoder\ContextAwareDecoderInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class UserOwnedDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{

    use DenormalizerAwareTrait;

    private const ALREADY_CALLED_DENORMALIZER = 'UserOwnedDenormalizerCalled';

    public function __construct(private Security $security)
    {

    }
    public function decode(string $data, string $format, array $context = []): mixed
    {
        // TODO: Implement decode() method.
    }

    public function denormalize(mixed $data, string $type, string $format = null, array $context = []): mixed
    {
        $context[self::ALREADY_CALLED_DENORMALIZER] = true;
        /** @var CustomerOwnedInterface $object */
        $object = $this->denormalizer->denormalize($data, $type, $format, $context);
        $object->setCustomer($this->security->getUser());
        return $object;

    }

    /**
     * @throws \ReflectionException
     */
    public function supportsDenormalization(mixed $data, string $type, string $format = null, array $context = []): bool
    {
        $reflexionClass = new ReflectionClass($type);
        $alreadyCalled = $context[self::ALREADY_CALLED_DENORMALIZER] ?? false;
        return $reflexionClass->implementsInterface(CustomerOwnedInterface::class) && $alreadyCalled === false;
    }

    public function getSupportedTypes(?string $format): array
    {
        return $this->denormalizer->getSupportedTypes($format);
    }

}