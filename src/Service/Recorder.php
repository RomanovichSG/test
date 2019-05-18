<?php


namespace App\Service;

/**
 * Interface Recorder
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
    public function makeRecord(Recordable $unit);
}