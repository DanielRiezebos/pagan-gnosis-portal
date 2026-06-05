<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260419130443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gnosis_entry (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gnosisproject INTEGER NOT NULL, user INTEGER NOT NULL, gnosis CLOB NOT NULL, created_at DATETIME NOT NULL, CONSTRAINT FK_CE80FF52305D7EB FOREIGN KEY (gnosisproject) REFERENCES gnosis_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CE80FF528D93D649 FOREIGN KEY (user) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_CE80FF52305D7EB ON gnosis_entry (gnosisproject)');
        $this->addSql('CREATE INDEX IDX_CE80FF528D93D649 ON gnosis_entry (user)');
        $this->addSql('CREATE TABLE gnosis_project (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, created_at DATETIME DEFAULT NULL, finished_at DATETIME DEFAULT NULL, is_closed BOOLEAN DEFAULT 0 NOT NULL)');
        $this->addSql('CREATE TABLE gnosis_project_tag (gnosis_project_id INTEGER NOT NULL, tag_id INTEGER NOT NULL, PRIMARY KEY(gnosis_project_id, tag_id), CONSTRAINT FK_629A815BC7F06C8E FOREIGN KEY (gnosis_project_id) REFERENCES gnosis_project (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_629A815BBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_629A815BC7F06C8E ON gnosis_project_tag (gnosis_project_id)');
        $this->addSql('CREATE INDEX IDX_629A815BBAD26311 ON gnosis_project_tag (tag_id)');
        $this->addSql('CREATE TABLE result_comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, gnosis_project_id INTEGER NOT NULL, user_id INTEGER NOT NULL, parent_comment_id INTEGER DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, deleted_at DATETIME DEFAULT NULL, CONSTRAINT FK_F64DD088C7F06C8E FOREIGN KEY (gnosis_project_id) REFERENCES gnosis_project (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F64DD088A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F64DD088BF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES result_comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F64DD088C7F06C8E ON result_comment (gnosis_project_id)');
        $this->addSql('CREATE INDEX IDX_F64DD088A76ED395 ON result_comment (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F64DD088BF2AF943 ON result_comment (parent_comment_id)');
        $this->addSql('CREATE TABLE role (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE setting (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, setting_key VARCHAR(255) NOT NULL, setting_value VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, label VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, strikes INTEGER NOT NULL DEFAULT 0, CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8D93D649D60322AC ON user (role_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE gnosis_entry');
        $this->addSql('DROP TABLE gnosis_project');
        $this->addSql('DROP TABLE gnosis_project_tag');
        $this->addSql('DROP TABLE result_comment');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
    }
}
