<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210629125019 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECD233E95C');
        $this->addSql('DROP INDEX IDX_514C8FECD233E95C ON examen');
        $this->addSql('ALTER TABLE examen ADD description LONGTEXT DEFAULT NULL, DROP resultat_id');
        $this->addSql('ALTER TABLE rendez_vous ADD resultat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AD233E95C FOREIGN KEY (resultat_id) REFERENCES examen (id)');
        $this->addSql('CREATE INDEX IDX_65E8AA0AD233E95C ON rendez_vous (resultat_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE examen ADD resultat_id INT DEFAULT NULL, DROP description');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECD233E95C FOREIGN KEY (resultat_id) REFERENCES examen (id)');
        $this->addSql('CREATE INDEX IDX_514C8FECD233E95C ON examen (resultat_id)');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AD233E95C');
        $this->addSql('DROP INDEX IDX_65E8AA0AD233E95C ON rendez_vous');
        $this->addSql('ALTER TABLE rendez_vous DROP resultat_id');
    }
}
