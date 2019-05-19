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
     * Receive user listing.
     *
     * @param null|int    $id
     * @param null|string $firstName
     * @param null|string $sorting
     *
     * @return array
     */
    public function getUsersListing(
        ?int $id = null,
        ?string $firstName = null,
        ?string $sorting = null
    ): array {
        $id = is_numeric($id) ? (integer) $id : 1;
        $firstName = is_string($firstName) ? $firstName : '';
        $sorting = is_string($sorting) ? $sorting : '';

        $users = $this->repository->getUsers($id, $firstName, $sorting);

        foreach ($users as &$user) {
            $phoneNumbers = $user->getUserPhoneNumbers();
            $numbers = [];
            foreach ($phoneNumbers as $number) {
                $numbers[] = $number->getPhoneNumber();
            }

            $user = [
                'id' => $user->getId(),
                'firstName' => $user->getFirstName(),
                'lastName' => $user->getLastName(),
                'phoneNumbers' => $numbers,
            ];
        }
        unset($user);

        return $users;
    }
}
