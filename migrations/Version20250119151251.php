<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250119151251 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE result_comment (
                id INT AUTO_INCREMENT NOT NULL,
                parent_comment_id INT DEFAULT NULL,
                user_id INT NOT NULL,
                gnosis_project_id INT NOT NULL,
                content TEXT NOT NULL,
                created_at DATETIME NOT NULL,
                INDEX IDX_RESULT_COMMENT_PARENT (parent_comment_id),
                INDEX IDX_RESULT_COMMENT_USER (user_id),
                INDEX IDX_RESULT_COMMENT_GNOSIS_PROJECT (gnosis_project_id),
                PRIMARY KEY(id),                
                CONSTRAINT FK_RESULT_COMMENT_PARENT FOREIGN KEY (parent_comment_id) REFERENCES result_comment (id) ON DELETE SET NULL,
                CONSTRAINT FK_RESULT_COMMENT_USER FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE,
                CONSTRAINT FK_RESULT_COMMENT_GNOSIS_PROJECT_ID FOREIGN KEY (gnosis_project_id) REFERENCES gnosis_project (id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE result_comment');
    }
}
