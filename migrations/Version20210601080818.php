<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210601080818 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD specialite_id INT DEFAULT NULL, ADD service_id INT DEFAULT NULL, ADD nom VARCHAR(255) DEFAULT NULL, ADD prenom VARCHAR(255) DEFAULT NULL, ADD tel VARCHAR(255) DEFAULT NULL, ADD adresse VARCHAR(255) DEFAULT NULL, ADD assurance VARCHAR(255) DEFAULT NULL, DROP is_verified');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6492195E0F0 FOREIGN KEY (specialite_id) REFERENCES specialite (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6492195E0F0 ON user (specialite_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649ED5CA9E6 ON user (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6492195E0F0');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649ED5CA9E6');
        $this->addSql('DROP INDEX IDX_8D93D6492195E0F0 ON `user`');
        $this->addSql('DROP INDEX IDX_8D93D649ED5CA9E6 ON `user`');
        $this->addSql('ALTER TABLE `user` ADD is_verified TINYINT(1) NOT NULL, DROP specialite_id, DROP service_id, DROP nom, DROP prenom, DROP tel, DROP adresse, DROP assurance');
    }
}
