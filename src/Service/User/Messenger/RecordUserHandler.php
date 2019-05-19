<?php

namespace App\Service\User\Messenger;

use App\Service\User\User;
use App\Service\User\UserDenormalizer;
use App\Service\User\UserRecorder;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Class RecordUserHandler
 *
 * @package App\Service\User\Messenger
 */
class RecordUserHandler implements MessageHandlerInterface
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
     * @var LoggerInterface
     */
    private $logger;

    /**
     * RecordUserHandler constructor.
     *
     * @param UserDenormalizer $denormalizer
     * @param UserRecorder $recorder
     */
    public function __construct(
        UserDenormalizer $denormalizer,
        UserRecorder $recorder,
        LoggerInterface $logger
    ) {
        $this->denormalizer = $denormalizer;
        $this->recorder = $recorder;
        $this->logger = $logger;
    }

    /**
     * @param RecordUserMessage $message
     */
    public function __invoke(RecordUserMessage $message)
    {
        try {
            /* @var User $user */
            $user = $this->denormalizer->denormalize($message->getUserData());
            $this->recorder->makeRecord($user);
        } catch (\Throwable $exception) {
            $this->logger->warning(
                $exception->getMessage(),
                [
                    $exception->getFile(),
                    $exception->getLine()
                ]
            );
        }
    }
}
