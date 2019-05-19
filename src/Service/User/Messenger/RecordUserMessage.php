<?php


namespace App\Service\User\Messenger;

use App\Service\User\User;

/**
 * Class RecordUserMessage
 *
 * @package App\Service\User\Messager
 */
class RecordUserMessage
{

    /**
     * @var User
     */
    private $user = [];

    /**
     * RecordUserMessage constructor.
     *
     * @param User $userData
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}