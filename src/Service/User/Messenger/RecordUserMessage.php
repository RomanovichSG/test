<?php


namespace App\Service\User\Messenger;

/**
 * Class RecordUserMessage
 *
 * @package App\Service\User\Messager
 */
class RecordUserMessage
{

    /**
     * @var array
     */
    private $userData = [];

    /**
     * RecordUserMessage constructor.
     *
     * @param array $userData
     */
    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    /**
     * @return array
     */
    public function getUserData(): array
    {
        return $this->userData;
    }
}