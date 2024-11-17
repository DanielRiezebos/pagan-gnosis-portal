<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241117103800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gnosis_entry RENAME INDEX idx_ce80ff5287b274a8 TO IDX_CE80FF52305D7EB');
        $this->addSql('ALTER TABLE gnosis_entry RENAME INDEX idx_ce80ff529d86650f TO IDX_CE80FF528D93D649');
        $this->addSql('ALTER TABLE gnosis_project ADD is_closed TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gnosis_entry RENAME INDEX idx_ce80ff52305d7eb TO IDX_CE80FF5287B274A8');
        $this->addSql('ALTER TABLE gnosis_entry RENAME INDEX idx_ce80ff528d93d649 TO IDX_CE80FF529D86650F');
        $this->addSql('ALTER TABLE gnosis_project DROP is_closed');
    }
}
