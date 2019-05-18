<?php

namespace App\Repository;

use App\Entity\UserPhoneNumbers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method UserPhoneNumbers|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPhoneNumbers|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPhoneNumbers[]    findAll()
 * @method UserPhoneNumbers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPhoneNumbersRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, UserPhoneNumbers::class);
    }
}
