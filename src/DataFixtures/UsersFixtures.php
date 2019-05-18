<?php

namespace App\DataFixtures;

use App\Service\User\User;
use App\Service\User\UserDenormalizer;
use App\Service\User\UserRecorder;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UsersFixtures extends Fixture
{

    /**
     * @var UserDenormalizer
     */
    private $denormalize;

    /**
     * @var UserRecorder
     */
    private $recorder;

    /**
     * @var array
     */
    private $words = [
        'foo',
        'bar',
        'baz',
        'qux',
        'quux',
        'corge',
        'grault',
        'garply',
        'waldo',
        'fred',
        'plugh',
        'xyzzy',
        'thud',
    ];

    public function __construct(UserDenormalizer $denormalizer, UserRecorder $recorder)
    {
        $this->denormalize = $denormalizer;
        $this->recorder = $recorder;
    }

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i <= 60; $i++) {
            $data = ['phoneNumbers' => []];

            $maxPhoneNumbers = mt_rand(0, 5);
            for ($j = 0; $j <= $maxPhoneNumbers; $j++) {
                $first = mt_rand(100, 999);
                $second = mt_rand(100, 999);
                $third = mt_rand(1000, 9999);

                $data['phoneNumbers'][] = "{$first} {$second}-{$third}";
            }
            $data['firstName'] = $this->words[mt_rand(0, 12)];
            $data['lastName'] = $this->words[mt_rand(0, 12)];

            /* @var User $user */
            $user = $this->denormalize->denormalize($data, User::class);
            $this->recorder->makeRecord($user);
        }
    }
}
