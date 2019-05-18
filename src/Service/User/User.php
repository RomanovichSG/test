<?php


namespace App\Service\User;

use App\Service\Recordable;

/**
 * Class User
 *
 * @package App\Service\User
 */
class User implements Recordable
{

    /**
     * @var string
     */
    private $firstName = '';

    /**
     * @var string
     */
    private $lastName = '';

    /**
     * @var array
     */
    private $phoneNumbers = [];

    /**
     * @var string
     */
    private $checksum = '';

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        if (empty($firstName)) {
            throw new \InvalidArgumentException('User first name can\'t be empty');
        }

        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        if (empty($lastName)) {
            throw new \InvalidArgumentException('User last name can\'t be empty');
        }

        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getChecksum(): string
    {
        return $this->checksum = hash(
            'sha256',
            $this->firstName
            . $this->lastName
            . implode('', $this->phoneNumbers)
        );
    }

    /**
     * @param array $phoneNumbers
     */
    public function setPhoneNumbers(array $phoneNumbers): void
    {
        foreach ($phoneNumbers as $number) {
            if (!is_string($number)) {
                continue;
            }

            $this->phoneNumbers[] = $number;
        }
    }

    /**
     * @return array
     */
    public function getPhoneNumbers(): array
    {
        return $this->phoneNumbers;
    }
}
