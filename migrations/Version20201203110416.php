<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203110416 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo ADD referenciels_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBCE8A50AE FOREIGN KEY (referenciels_id) REFERENCES referenciel (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFBCE8A50AE ON promo (referenciels_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBCE8A50AE');
        $this->addSql('DROP INDEX IDX_B0139AFBCE8A50AE ON promo');
        $this->addSql('ALTER TABLE promo DROP referenciels_id');
    }
}
