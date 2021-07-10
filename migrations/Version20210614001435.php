<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210614001435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE allergie (id INT AUTO_INCREMENT NOT NULL, consultation_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, INDEX IDX_1ED89E4A62FF6CDF (consultation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plainte (id INT AUTO_INCREMENT NOT NULL, consultation_id INT DEFAULT NULL, designation VARCHAR(255) NOT NULL, date DATE DEFAULT NULL, INDEX IDX_D88CE90F62FF6CDF (consultation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reponse (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE allergie ADD CONSTRAINT FK_1ED89E4A62FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE plainte ADD CONSTRAINT FK_D88CE90F62FF6CDF FOREIGN KEY (consultation_id) REFERENCES consultation (id)');
        $this->addSql('ALTER TABLE consultation ADD fumeur_id INT DEFAULT NULL, ADD alcoolique_id INT DEFAULT NULL, ADD diabetique_id INT DEFAULT NULL, ADD autre VARCHAR(255) DEFAULT NULL, DROP statut, DROP slug');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A6F69CDB32 FOREIGN KEY (fumeur_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66697936B FOREIGN KEY (alcoolique_id) REFERENCES reponse (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A674F9C519 FOREIGN KEY (diabetique_id) REFERENCES reponse (id)');
        $this->addSql('CREATE INDEX IDX_964685A6F69CDB32 ON consultation (fumeur_id)');
        $this->addSql('CREATE INDEX IDX_964685A66697936B ON consultation (alcoolique_id)');
        $this->addSql('CREATE INDEX IDX_964685A674F9C519 ON consultation (diabetique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A6F69CDB32');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A66697936B');
        $this->addSql('ALTER TABLE consultation DROP FOREIGN KEY FK_964685A674F9C519');
        $this->addSql('DROP TABLE allergie');
        $this->addSql('DROP TABLE plainte');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP INDEX IDX_964685A6F69CDB32 ON consultation');
        $this->addSql('DROP INDEX IDX_964685A66697936B ON consultation');
        $this->addSql('DROP INDEX IDX_964685A674F9C519 ON consultation');
        $this->addSql('ALTER TABLE consultation ADD statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP fumeur_id, DROP alcoolique_id, DROP diabetique_id, DROP autre');
    }
}
