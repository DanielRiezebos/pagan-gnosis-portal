<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240914121210 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gnosis_entry (id INT AUTO_INCREMENT NOT NULL, gnosisproject_id INT NOT NULL, user_id INT NOT NULL, gnosis LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CE80FF5287B274A8 (gnosisproject_id_id), INDEX IDX_CE80FF529D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE gnosis_entry ADD CONSTRAINT FK_CE80FF5287B274A8 FOREIGN KEY (gnosisproject_id) REFERENCES gnosis_project (id)');
        $this->addSql('ALTER TABLE gnosis_entry ADD CONSTRAINT FK_CE80FF529D86650F FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gnosis_entry DROP FOREIGN KEY FK_CE80FF5287B274A8');
        $this->addSql('ALTER TABLE gnosis_entry DROP FOREIGN KEY FK_CE80FF529D86650F');
        $this->addSql('DROP TABLE gnosis_entry');
    }
}
