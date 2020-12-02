<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202092048 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE referenciel_groupe_competence (referenciel_id INT NOT NULL, groupe_competence_id INT NOT NULL, INDEX IDX_2016095A22241379 (referenciel_id), INDEX IDX_2016095A89034830 (groupe_competence_id), PRIMARY KEY(referenciel_id, groupe_competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE referenciel_groupe_competence ADD CONSTRAINT FK_2016095A22241379 FOREIGN KEY (referenciel_id) REFERENCES referenciel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE referenciel_groupe_competence ADD CONSTRAINT FK_2016095A89034830 FOREIGN KEY (groupe_competence_id) REFERENCES groupe_competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE referenciel_groupe_competence');
    }
}
