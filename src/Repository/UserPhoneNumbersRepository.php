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

    // /**
    //  * @return UserPhoneNumbers[] Returns an array of UserPhoneNumbers objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserPhoneNumbers
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
