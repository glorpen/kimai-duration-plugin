<?php

declare(strict_types=1);

/*
 * This file is part of the GlorpenDurationBundle for Kimai 2.
 * All rights reserved by Arkadiusz Dzięgiel (https://glorpen.eu).
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiPlugin\GlorpenDurationBundle\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220506091813 extends AbstractMigration
{
    /**
     * @var string[]
     */
    private $metaTables = [
        'kimai2_customers_meta',
        'kimai2_projects_meta',
        'kimai2_activities_meta'
    ];

    public function getDescription(): string
    {
        return 'Update meta fields name';
    }

    public function up(Schema $schema): void
    {
        foreach ($this->metaTables as $metaTable) {
            $this->addSql('UPDATE ' . $metaTable . ' SET name = "glorpen_duration" WHERE name = "glorpen.duration"');
        }
    }

    public function down(Schema $schema): void
    {
        foreach ($this->metaTables as $metaTable) {
            $this->addSql('UPDATE ' . $metaTable . ' SET name = "glorpen.duration" WHERE name = "glorpen_duration"');
        }
    }
}
