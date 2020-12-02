<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202133155 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competences_valides (id INT AUTO_INCREMENT NOT NULL, competences_id INT DEFAULT NULL, apprenants_id INT DEFAULT NULL, referenciels_id INT DEFAULT NULL, promos_id INT DEFAULT NULL, niveau1 TINYINT(1) NOT NULL, niveau2 TINYINT(1) NOT NULL, niveau3 TINYINT(1) NOT NULL, INDEX IDX_9EEA096EA660B158 (competences_id), INDEX IDX_9EEA096ED4B7C9BD (apprenants_id), INDEX IDX_9EEA096ECE8A50AE (referenciels_id), INDEX IDX_9EEA096ECAA392D2 (promos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096EA660B158 FOREIGN KEY (competences_id) REFERENCES competence (id)');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096ED4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096ECE8A50AE FOREIGN KEY (referenciels_id) REFERENCES referenciel (id)');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096ECAA392D2 FOREIGN KEY (promos_id) REFERENCES promo (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE competences_valides');
    }
}
