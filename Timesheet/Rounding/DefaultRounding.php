<?php

/*
 * This file is part of the DemoBundle for Kimai 2.
 * All rights reserved by Kevin Papst (www.kevinpapst.de).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\GlorpenDurationBundle\Timesheet\Rounding;

use App\Entity\Timesheet;
use KimaiPlugin\GlorpenDurationBundle\Timesheet\Rounding\Vendor\DefaultRounding as VendorDefaultRounding;

class DefaultRounding extends VendorDefaultRounding
{
    public function getId(): string
    {
        return 'glorpen.default';
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

        parent::roundDuration($record, $minutes);
    }
}
