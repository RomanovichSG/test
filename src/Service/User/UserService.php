<?php

namespace App\Service\User;

use App\Repository\UsersRepository;

/**
 * Class UserService
 * @package App\Service\User
 */
class UserService
{

    /**
     * @var UserDenormalizer
     */
    private $denormalizer;

    /**
     * @var UserRecorder
     */
    private $recorder;

    /**
     * @var UsersRepository
     */
    private $repository;

    /**
     * UserService constructor.
     *
     * @param UserRecorder $recorder
     * @param UserDenormalizer $denormalizer
     * @param UsersRepository $repository
     */
    public function __construct(
        UserRecorder $recorder,
        UserDenormalizer $denormalizer,
        UsersRepository $repository
    ) {
        $this->recorder = $recorder;
        $this->denormalizer = $denormalizer;
        $this->repository = $repository;
    }

    /**
     * @return UserDenormalizer
     */
    public function getDenormalizer(): UserDenormalizer
    {
        return $this->denormalizer;
    }

    /**
     * @return UserRecorder
     */
    public function getRecorder(): UserRecorder
    {
        return $this->recorder;
    }

    /**
     * @return UsersRepository
     */
    public function getRepository(): UsersRepository
    {
        return $this->repository;
    }
}
