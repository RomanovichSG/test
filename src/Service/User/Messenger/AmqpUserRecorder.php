<?php

namespace App\Service\User\Messenger;

use App\Service\Recordable;
use App\Service\User\UserRecorder;
use PDOException;

/**
 * Class AmqpUserRecorder
 *
 * @package App\Service\User\Messenger
 */
class AmqpUserRecorder extends UserRecorder
{

    /**
     * @inheritDoc
     */
    public function makeRecord(Recordable $unit): int
    {
        gc_enable();

        $connection = $this->entityManager->getConnection();

        try {
            if (!$connection->ping()) {
                $connection->close();
                $connection->connect();
            }
        } catch (PDOException $exception) {
            $connection->close();
            $connection->connect();
        }

        $result = parent::makeRecord($unit);

        $this->entityManager->clear();

        gc_collect_cycles();

        return $result;
    }
}
