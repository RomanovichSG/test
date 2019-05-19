<?php

namespace App\Service\User;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class UserDenormalizer implements DenormalizerInterface
{

    /**
     * @var ObjectNormalizer
     */
    private $normalizer;

    /**
     * UserDenormalizer constructor.
     *
     * @param ObjectNormalizer $normalizer
     */
    public function __construct(ObjectNormalizer $normalizer)
    {
        $this->normalizer = $normalizer;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, $class = User::class, $format = null, array $context = [])
    {
        $this->validateData($data);

        return $this->normalizer->denormalize($data, $class, $format, $context);
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type instanceof User;
    }

    /**
     * @param $data
     */
    private function validateData($data) {
        if (!is_array($data)) {
            throw new \InvalidArgumentException('Data must be array');
        }

        if (empty($data['firstName'])) {
            throw new \InvalidArgumentException('First name must be filled');
        }

        if (empty($data['lastName'])) {
            throw new \InvalidArgumentException('Last name must be filled');
        }

        if (!is_array($data['phoneNumbers'])) {
            throw new \InvalidArgumentException('Phone numbers must be array');
        }

        foreach ($data['phoneNumbers'] as $number) {
            if (!is_string($number)) {
                throw new \InvalidArgumentException('Phone number must be string');
            }
        }
    }
}