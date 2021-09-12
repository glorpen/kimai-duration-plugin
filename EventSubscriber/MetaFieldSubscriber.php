<?php

/*
 * This file is part of the GlorpenDurationBundle for Kimai 2.
 * All rights reserved by Arkadiusz Dzięgiel (https://glorpen.eu).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\GlorpenDurationBundle\EventSubscriber;

use App\Entity\ActivityMeta;
use App\Entity\CustomerMeta;
use App\Entity\MetaTableTypeInterface;
use App\Entity\ProjectMeta;
use App\Event\ActivityMetaDefinitionEvent;
use App\Event\ActivityMetaDisplayEvent;
use App\Event\CustomerMetaDefinitionEvent;
use App\Event\CustomerMetaDisplayEvent;
use App\Event\ProjectMetaDefinitionEvent;
use App\Event\ProjectMetaDisplayEvent;
use KimaiPlugin\GlorpenDurationBundle\Timesheet\Rounding\OverriddenDurationRounding;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints as Constraints;

class MetaFieldSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            ActivityMetaDefinitionEvent::class => ['loadActivityMeta', 200],
            ActivityMetaDisplayEvent::class => ['loadActivityFields', 200],
            ProjectMetaDefinitionEvent::class => ['loadProjectMeta', 200],
            ProjectMetaDisplayEvent::class => ['loadProjectFields', 200],
            CustomerMetaDefinitionEvent::class => ['loadCustomerMeta', 200],
            CustomerMetaDisplayEvent::class => ['loadCustomerFields', 200]
        ];
    }

    public function loadActivityMeta(ActivityMetaDefinitionEvent $event)
    {
        $event->getEntity()->setMetaField($this->setUpMetaField(new ActivityMeta()));
    }

    private function setUpMetaField(MetaTableTypeInterface $field): MetaTableTypeInterface
    {
        return $field->setName(OverriddenDurationRounding::META_FIELD_NAME)
            ->setLabel('Duration rounding')
            ->setOptions(['label' => 'Rounding of the duration in minutes (0 = deactivated)', 'help' => 'Leave empty to use global values'])
            ->setType(NumberType::class)
            ->addConstraint(new Constraints\PositiveOrZero())
            ->setIsVisible(true);
    }

    public function loadActivityFields(ActivityMetaDisplayEvent $event)
    {
        $event->addField($this->setUpMetaField(new ActivityMeta()));
    }

    public function loadProjectMeta(ProjectMetaDefinitionEvent $event)
    {
        $event->getEntity()->setMetaField($this->setUpMetaField(new ProjectMeta()));
    }

    public function loadProjectFields(ProjectMetaDisplayEvent $event)
    {
        $event->addField($this->setUpMetaField(new ProjectMeta()));
    }

    public function loadCustomerMeta(CustomerMetaDefinitionEvent $event)
    {
        $event->getEntity()->setMetaField($this->setUpMetaField(new CustomerMeta()));
    }

    public function loadCustomerFields(CustomerMetaDisplayEvent $event)
    {
        $event->addField($this->setUpMetaField(new CustomerMeta()));
    }
}
