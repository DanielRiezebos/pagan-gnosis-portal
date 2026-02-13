<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260208134852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("ALTER TABLE setting ADD is_permanent TINYINT(1) NOT NULL DEFAULT 0");
        $this->addSQL("INSERT INTO setting (setting_key, setting_value, is_permanent) VALUES ('admin_email', 'administration@pagangnosisportal.nl', 1)");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("ALTER TABLE settings DROP COLUMN is_permanent");
    }
}
