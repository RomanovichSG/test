<?php


namespace App\Service;

/**
 * Interface Recorder
 *
 * Any service which can record data somewhere must implement this interface
 *
 * @package App\Service
 */
interface Recorder
{
    /**
     * @param Recordable $unit
     *
     * @return integer Id of the row
     */
    public function makeRecord(Recordable $unit): int;
}