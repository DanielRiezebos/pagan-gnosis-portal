<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260208151055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE UNIQUE INDEX UNIQ_USER_EMAIL ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user CHANGE strikes strikes INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE result_comment CHANGE content content TEXT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE setting ADD is_permanent TINYINT(1) DEFAULT 0 NOT NULL, CHANGE setting_value setting_value TEXT DEFAULT NULL');
    }
}
