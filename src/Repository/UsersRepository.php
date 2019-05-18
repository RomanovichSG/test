<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    const LIMIT = 30;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * @param string $checksume
     *
     * @return Users|null
     */
    public function getUserByChecksum(string $checksume): ?Users
    {
        /* @var $user Users */
        return $this->findOneBy(['checksum' => $checksume]);
    }

    /**
     * @param int $page
     * @param int $limit
     * @return Users[]
     */
    public function getUsers(int $page = 1, string $firstName = '', string $sorting = ''): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->select('u')
            ->setMaxResults(self::LIMIT)
            ->where($qb->expr()->gte('u.id', ($page - 1) * self::LIMIT));

        if ('' !== $firstName) {
            $qb->andWhere(
                $qb->expr()->eq(':firstName', 'u.firstName')
                )->setParameter('firstName', $firstName);
        }

        if ('' !== $sorting) {
            $sorting = strtoupper($sorting);
            $criteria = array_flip([Criteria::ASC, Criteria::DESC]);

            $qb->orderBy(
                'u.firstName',
                    isset($criteria[$sorting]) ? $sorting : Criteria::ASC
                );
        }

        return $qb->getQuery()->getResult();
    }
}
