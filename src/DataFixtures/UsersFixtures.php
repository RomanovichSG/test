<?php

namespace App\DataFixtures;

use App\Entity\UserPhoneNumbers;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{
    private $firstNames = [
        'Foo',
        'Bar',
        'Baz',
    ];

    private $lasNames = [
        'Foo',
        'Bar',
        'Baz',
    ];

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 60; $i++) {
            $user = new Users();

            $maxPhoneNumbers = mt_rand(0, 3);
            for ($j = 0; $j <= $maxPhoneNumbers; $j++) {
                $phones = new UserPhoneNumbers();

                $first = mt_rand(100, 999);
                $second = mt_rand(100, 999);
                $third = mt_rand(1000, 9999);

                //812 123-1234
                $phones->setPhoneNumber("{$first} {$second}-{$third}");
                $manager->persist($phones);
                $user->addUserPhoneNumber($phones);
            }

            $firstNameIndex = mt_rand(0, 2);
            $user->setFirstName($this->firstNames[$firstNameIndex]);

            $lastNameIndex = mt_rand(0, 2);
            $user->setLastName($this->lasNames[$lastNameIndex]);

            $manager->persist($user);
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
