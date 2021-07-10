<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210627080510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66697936B');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A674F9C519');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6F69CDB32');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP INDEX IDX_964685A66697936B ON consultation');
        $this->addSql('DROP INDEX IDX_964685A6F69CDB32 ON consultation');
        $this->addSql('DROP INDEX IDX_964685A674F9C519 ON consultation');
        $this->addSql('ALTER TABLE consultation ADD fumeur VARCHAR(255) NOT NULL, ADD alcoolique VARCHAR(255) NOT NULL, ADD diabetique VARCHAR(255) NOT NULL, DROP fumeur_id, DROP alcoolique_id, DROP diabetique_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE consultation ADD fumeur_id INT DEFAULT NULL, ADD alcoolique_id INT DEFAULT NULL, ADD diabetique_id INT DEFAULT NULL, DROP fumeur, DROP alcoolique, DROP diabetique');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66697936B FOREIGN KEY (alcoolique_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A674F9C519 FOREIGN KEY (diabetique_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6F69CDB32 FOREIGN KEY (fumeur_id) REFERENCES reponse (id)');
        $this->addSql('CREATE INDEX IDX_964685A66697936B ON consultation (alcoolique_id)');
        $this->addSql('CREATE INDEX IDX_964685A6F69CDB32 ON consultation (fumeur_id)');
        $this->addSql('CREATE INDEX IDX_964685A674F9C519 ON consultation (diabetique_id)');
    }
}
