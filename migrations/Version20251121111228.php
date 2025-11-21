<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251121111228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE setting (
            id INT AUTO_INCREMENT NOT NULL,
            setting_key VARCHAR(255) NOT NULL,
            setting_value TEXT DEFAULT NULL,
            PRIMARY KEY(id))
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`
            ENGINE = InnoDB'
        );
        $this->addSql("INSERT INTO setting
            (setting_key, setting_value)
            VALUES
            ('intro_text', '<p>We are delighted to hail you into the PaganGnosisPortal, an online space dedicated to the sharing, exploration and ultimately the understanding of our Pagan spiritual experiences. Our mission is to foster a vibrant community where we can collectively delve into the mysteries of the Gods we worship and deepen our understanding of their divine nature.</p>
                <b>Why are we doing this?</b>
                <p>We believe that the root of any religious tradition lies in the spiritual experiences that humans have and humans remember. They remember them through stories, myths, legends, norms and values. Given that Pagan religious tradition has been forbidden, forgotten and destroyed we mostly no longer have access to the original stories that once explained facets of the religion that mattered to our ancestors.</p>
                <p>However, what mortal hands cannot make illegal are the very Gods & Goddesses themselves. Through our spiritual experiences we get to know them. In this Portal, we can analyze and talk about those experiences, anonymously.</p>
                <b>What are we doing?</b>
                <p>In this Portal, we will host Gnosis-Projects. These are projects that involve one, or several, specific deities that we will be gnostically investigating for a set time. We ask of you to work with the deities in this set time and to share your experiences as rich as you can with us in the projects. Afterwards, the experiences will be shared anonymously and will be analyzed in a result page.</p>                        
                <p>Further discussions can be had on the same result page. We ask of you some courtesy when engaging with your fellow Pagans within the PaganGnosisPortal. Any breaches of conduct will result in your removal from this website.</p>
                <p>May our Portal be a beacon of knowledge, a source of inspiration, and a testament to the enduring power of our Pagan spirituality.</p>
            ');
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE setting');
    }
}
