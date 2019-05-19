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
     * @param null $page
     * @param null $firstName
     * @param null $sorting
     *
     * @return array
     */
    public function getUsersListing(
        ?int $page = null,
        ?string $firstName = null,
        ?string $sorting = null
    ): array {
        $page = is_numeric($page) ? (integer) $page : 1;
        $firstName = is_string($firstName) ? $firstName : '';
        $sorting = is_string($sorting) ? $sorting : '';

        $users = $this->repository->getUsers($page, $firstName, $sorting);

        foreach ($users as &$user) {
            $phoneNumbers = $user->getUserPhoneNumbers();
            $numbers = [];
            foreach ($phoneNumbers as $number) {
                $numbers[] = $number->getPhoneNumber();
            }

            $user = [
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'phoneNumbers' => $numbers,
            ];
        }
        unset($user);

        return $users;
    }
}
