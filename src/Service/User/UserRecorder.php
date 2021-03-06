<?php

namespace App\Service\User;

use App\Entity\UserPhoneNumbers;
use App\Entity\Users;
use App\Repository\UsersRepository;
use App\Service\Exception\AlreadyExistException;
use App\Service\Recordable;
use App\Service\Recorder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class UserRecorder
 *
 * @package App\Service\User
 */
class UserRecorder implements Recorder
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var UsersRepository
     */
    protected $repository;

    /**
     * UserRecorder constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->repository = $entityManager->getRepository(Users::class);
    }

    /**
     * Put User to record him into the database.
     *
     * @param User $unit
     *
     * @return integer
     *
     * @throws AlreadyExistException
     */
    public function makeRecord(Recordable $unit): int
    {
        $user = $this->repository->getUserByChecksum($unit->getChecksum());

        if (null !== $user) {
            throw new AlreadyExistException('This user already exists');
        }

        $user = new Users();
        $this->entityManager->persist($user);

        foreach ($unit->getPhoneNumbers() as $number) {
            $phoneNumber = new UserPhoneNumbers();
            $phoneNumber->setPhoneNumber($number);
            $phoneNumber->setUsers($user);
            $this->entityManager->persist($phoneNumber);
        }

        $user->setFirstName($unit->getFirstName());
        $user->setLastName($unit->getLastName());
        $user->setChecksum($unit->getChecksum());
        $this->entityManager->flush();

        return $user->getId();
    }
}
