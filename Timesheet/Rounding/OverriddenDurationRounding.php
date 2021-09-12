<?php

/*
 * This file is part of the GlorpenDurationBundle for Kimai 2.
 * All rights reserved by Arkadiusz Dzięgiel (https://glorpen.eu).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\GlorpenDurationBundle\Timesheet\Rounding;

use App\Entity\Timesheet;
use App\Timesheet\Rounding\RoundingInterface;

class OverriddenDurationRounding implements RoundingInterface
{
    /**
     * @var RoundingInterface
     */
    private $vendorRounding;
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name, RoundingInterface $vendorRounding)
    {
        $this->vendorRounding = $vendorRounding;
        $this->name = $name;
    }

    public function getId(): string
    {
        return $this->name;
    }

    public function roundDuration(Timesheet $record, $minutes)
    {
        $metaFieldName = 'glorpen.duration';
        $duration = $record->getActivity()->getMetaField($metaFieldName);
        if ($duration === null) {
            $duration = $record->getProject()->getMetaField($metaFieldName);
        }
        if ($duration === null) {
            $duration = $record->getProject()->getCustomer()->getMetaField($metaFieldName);
        }

        if ($duration !== null) {
            $minutes = $duration->getValue();
        }

        $this->vendorRounding->roundDuration($record, $minutes);
    }

    public function roundBegin(Timesheet $record, $minutes): void
    {
        $this->vendorRounding->roundBegin($record, $minutes);
    }

    public function roundEnd(Timesheet $record, $minutes): void
    {
        $this->vendorRounding->roundEnd($record, $minutes);
    }
}
