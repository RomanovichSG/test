<?php

namespace App\Service\User\Messenger;

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
        UserRecorder $recorder,
        LoggerInterface $logger
    ) {
        $this->recorder = $recorder;
        $this->logger = $logger;
    }

    /**
     * Recording incoming user to the database.
     *
     * @param RecordUserMessage $message
     *
     * @return void
     */
    public function __invoke(RecordUserMessage $message) :void
    {
        try {
            $this->recorder->makeRecord($message->getUser());
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
