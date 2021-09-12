<?php

/*
 * This file is part of the Kimai time-tracking app.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\GlorpenDurationBundle\Timesheet\Rounding\Vendor;

use App\Entity\Timesheet;
use App\Timesheet\Rounding\RoundingInterface;

/**
 * 1:1 copy of Kimai final DefaultRounding.
 */
abstract class DefaultRounding implements RoundingInterface
{
    /**
     * @param Timesheet $record
     * @param int $minutes
     */
    public function roundBegin(Timesheet $record, $minutes)
    {
        if ($minutes <= 0) {
            return;
        }

        $timestamp = $record->getBegin()->getTimestamp();
        $seconds = $minutes * 60;
        $diff = $timestamp % $seconds;

        if (0 === $diff) {
            return;
        }

        $newBegin = clone $record->getBegin();
        $newBegin->setTimestamp($timestamp - $diff);
        $record->setBegin($newBegin);
    }

    /**
     * @param Timesheet $record
     * @param int $minutes
     */
    public function roundEnd(Timesheet $record, $minutes)
    {
        if ($minutes <= 0) {
            return;
        }

        $timestamp = $record->getEnd()->getTimestamp();
        $seconds = $minutes * 60;
        $diff = $timestamp % $seconds;

        if (0 === $diff) {
            return;
        }

        $newEnd = clone $record->getEnd();
        $newEnd->setTimestamp($timestamp - $diff + $seconds);
        $record->setEnd($newEnd);
    }

    /**
     * @param Timesheet $record
     * @param int $minutes
     */
    public function roundDuration(Timesheet $record, $minutes)
    {
        if ($minutes <= 0) {
            return;
        }

        $timestamp = $record->getDuration();
        $seconds = $minutes * 60;
        $diff = $timestamp % $seconds;

        if (0 === $diff) {
            return;
        }

        $record->setDuration($timestamp - $diff + $seconds);
    }
}
