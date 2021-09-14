<?php

/*
 * This file is part of the GlorpenDurationBundle for Kimai 2.
 * All rights reserved by Arkadiusz Dzięgiel (https://glorpen.eu).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\GlorpenDurationBundle\Timesheet\Rounding;

use App\Entity\EntityWithMetaFields;
use App\Entity\Timesheet;
use App\Timesheet\Rounding\RoundingInterface;

class OverriddenDurationRounding implements RoundingInterface
{
    public const META_FIELD_NAME = 'glorpen.duration';

    /**
     * @var RoundingInterface
     */
    private $vendorRounding;

    public function __construct(RoundingInterface $vendorRounding)
    {
        $this->vendorRounding = $vendorRounding;
    }

    public function getId(): string
    {
        return $this->vendorRounding->getId();
    }

    /**
     * @param EntityWithMetaFields|null $entity
     * @return int|null
     */
    private function getValue(?EntityWithMetaFields $entity): ?int
    {
        if ($entity === null) {
            return null;
        }

        $metaField = $entity->getMetaField(self::META_FIELD_NAME);

        if ($metaField !== null) {
            return $metaField->getValue();
        }

        return null;
    }

    public function roundDuration(Timesheet $record, $minutes)
    {
        $duration = $this->getValue($record->getActivity());
        if ($duration === null) {
            $duration = $this->getValue($record->getProject());
        }
        if ($duration === null && $record->getProject() !== null) {
            $duration = $this->getValue($record->getProject()->getCustomer());
        }

        if ($duration !== null) {
            $minutes = $duration;
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
