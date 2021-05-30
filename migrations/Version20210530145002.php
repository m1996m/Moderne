<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210530145002 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE chambre (id INT AUTO_INCREMENT NOT NULL, niveau INT NOT NULL, capacite INT NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consultation (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, medecin_id INT DEFAULT NULL, date DATE NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_964685A66B899279 (patient_id), INDEX IDX_964685A64F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE created_at (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, medecin_id INT DEFAULT NULL, produit VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_8B8E84286B899279 (patient_id), INDEX IDX_8B8E84284F31A84 (medecin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examen (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, resultat_id INT DEFAULT NULL, INDEX IDX_514C8FECC54C8C93 (type_id), INDEX IDX_514C8FECD233E95C (resultat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, traitement_id INT DEFAULT NULL, created_at DATETIME NOT NULL, total DOUBLE PRECISION NOT NULL, INDEX IDX_FE866410DDA344B6 (traitement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospilisation (id INT AUTO_INCREMENT NOT NULL, medecin_id INT DEFAULT NULL, patient_id INT DEFAULT NULL, motif_sortie_id INT DEFAULT NULL, chambre_id INT DEFAULT NULL, date_admission DATE NOT NULL, motif_admission VARCHAR(255) NOT NULL, nom_accompagnant VARCHAR(255) DEFAULT NULL, lien VARCHAR(255) DEFAULT NULL, date_sortie DATE NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_3BB15B5E4F31A84 (medecin_id), INDEX IDX_3BB15B5E6B899279 (patient_id), INDEX IDX_3BB15B5EA619031F (motif_sortie_id), INDEX IDX_3BB15B5E9B177F54 (chambre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE medecin (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motif (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rendez_vous (id INT AUTO_INCREMENT NOT NULL, patient_id INT DEFAULT NULL, medecin_id INT NOT NULL, service_id INT DEFAULT NULL, date DATE NOT NULL, statut VARCHAR(255) NOT NULL, INDEX IDX_65E8AA0A6B899279 (patient_id), INDEX IDX_65E8AA0A4F31A84 (medecin_id), INDEX IDX_65E8AA0AED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE resultat (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, conclusion VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE specialite (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE traitement (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, medecin_id INT DEFAULT NULL, type_id INT DEFAULT NULL, debut DATE NOT NULL, fin DATE NOT NULL, INDEX IDX_2A356D276B899279 (patient_id), INDEX IDX_2A356D274F31A84 (medecin_id), INDEX IDX_2A356D27C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_consultation (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_examen (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_traitement (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A66B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE consultation ADD CONSTRAINT FK_964685A64F31A84 FOREIGN KEY (medecin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE created_at ADD CONSTRAINT FK_8B8E84286B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE created_at ADD CONSTRAINT FK_8B8E84284F31A84 FOREIGN KEY (medecin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECC54C8C93 FOREIGN KEY (type_id) REFERENCES type_examen (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FECD233E95C FOREIGN KEY (resultat_id) REFERENCES examen (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410DDA344B6 FOREIGN KEY (traitement_id) REFERENCES traitement (id)');
        $this->addSql('ALTER TABLE hospilisation ADD CONSTRAINT FK_3BB15B5E4F31A84 FOREIGN KEY (medecin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE hospilisation ADD CONSTRAINT FK_3BB15B5E6B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE hospilisation ADD CONSTRAINT FK_3BB15B5EA619031F FOREIGN KEY (motif_sortie_id) REFERENCES motif (id)');
        $this->addSql('ALTER TABLE hospilisation ADD CONSTRAINT FK_3BB15B5E9B177F54 FOREIGN KEY (chambre_id) REFERENCES chambre (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A6B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0A4F31A84 FOREIGN KEY (medecin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE rendez_vous ADD CONSTRAINT FK_65E8AA0AED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D276B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D274F31A84 FOREIGN KEY (medecin_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE traitement ADD CONSTRAINT FK_2A356D27C54C8C93 FOREIGN KEY (type_id) REFERENCES type_traitement (id)');
        $this->addSql('DROP TABLE essai');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospilisation DROP FOREIGN KEY FK_3BB15B5E9B177F54');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECD233E95C');
        $this->addSql('ALTER TABLE hospilisation DROP FOREIGN KEY FK_3BB15B5EA619031F');
        $this->addSql('ALTER TABLE rendez_vous DROP FOREIGN KEY FK_65E8AA0AED5CA9E6');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410DDA344B6');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FECC54C8C93');
        $this->addSql('ALTER TABLE traitement DROP FOREIGN KEY FK_2A356D27C54C8C93');
        $this->addSql('CREATE TABLE essai (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_F0455541A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE essai ADD CONSTRAINT FK_F0455541A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE chambre');
        $this->addSql('DROP TABLE consultation');
        $this->addSql('DROP TABLE created_at');
        $this->addSql('DROP TABLE examen');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE hospilisation');
        $this->addSql('DROP TABLE medecin');
        $this->addSql('DROP TABLE motif');
        $this->addSql('DROP TABLE rendez_vous');
        $this->addSql('DROP TABLE resultat');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE specialite');
        $this->addSql('DROP TABLE traitement');
        $this->addSql('DROP TABLE type_consultation');
        $this->addSql('DROP TABLE type_examen');
        $this->addSql('DROP TABLE type_traitement');
    }
}
