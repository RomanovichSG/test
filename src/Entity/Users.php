<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $checksum;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserPhoneNumbers", mappedBy="user", orphanRemoval=true)
     */
    private $userPhoneNumbers;

    public function __construct()
    {
        $this->userPhoneNumbers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getChecksum(): ?string
    {
        return $this->checksum;
    }

    public function setChecksum(string $checksum): self
    {
        $this->checksum = $checksum;

        return $this;
    }

    /**
     * @return Collection|UserPhoneNumbers[]
     */
    public function getUserPhoneNumbers(): Collection
    {
        return $this->userPhoneNumbers;
    }

    public function addUserPhoneNumber(UserPhoneNumbers $userPhoneNumber): self
    {
        if (!$this->userPhoneNumbers->contains($userPhoneNumber)) {
            $this->userPhoneNumbers[] = $userPhoneNumber;
            $userPhoneNumber->setUser($this);
        }

        return $this;
    }

    public function removeUserPhoneNumber(UserPhoneNumbers $userPhoneNumber): self
    {
        if ($this->userPhoneNumbers->contains($userPhoneNumber)) {
            $this->userPhoneNumbers->removeElement($userPhoneNumber);
            // set the owning side to null (unless already changed)
            if ($userPhoneNumber->getUser() === $this) {
                $userPhoneNumber->setUser(null);
            }
        }

        return $this;
    }
}
