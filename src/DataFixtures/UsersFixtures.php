<?php

namespace App\DataFixtures;

use App\Service\Exception\AlreadyExistException;
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

    /**
     * UsersFixtures constructor.
     *
     * @param UserDenormalizer $denormalizer
     * @param UserRecorder $recorder
     */
    public function __construct(UserDenormalizer $denormalizer, UserRecorder $recorder)
    {
        $this->denormalize = $denormalizer;
        $this->recorder = $recorder;
    }

    /**
     * Fill tables with the test data.
     *
     * @param ObjectManager $manager
     *
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i <= 60; $i++) {
            try {
                $data = ['phoneNumbers' => []];

                $maxPhoneNumbers = mt_rand(0, 5);
                for ($j = 0; $j <= $maxPhoneNumbers; $j++) {
                    $first = mt_rand(100, 999);
                    $second = mt_rand(100, 999);
                    $third = mt_rand(1000, 9999);

                    $data['phoneNumbers'][] = "{$first} {$second}-{$third}";
                }
                $data['firstName'] = ucfirst($this->words[mt_rand(0, 12)]);
                $data['lastName'] = ucfirst($this->words[mt_rand(0, 12)]);

                /* @var User $user */
                $user = $this->denormalize->denormalize($data, User::class);
                $this->recorder->makeRecord($user);
            } catch (\Throwable $exception) {
                echo $exception->getMessage();
            }
        }
    }
}
