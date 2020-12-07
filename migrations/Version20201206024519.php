<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206024519 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promo_referenciel (promo_id INT NOT NULL, referenciel_id INT NOT NULL, INDEX IDX_AE45E44DD0C07AFF (promo_id), INDEX IDX_AE45E44D22241379 (referenciel_id), PRIMARY KEY(promo_id, referenciel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promo_referenciel ADD CONSTRAINT FK_AE45E44DD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_referenciel ADD CONSTRAINT FK_AE45E44D22241379 FOREIGN KEY (referenciel_id) REFERENCES referenciel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo DROP FOREIGN KEY FK_B0139AFBCE8A50AE');
        $this->addSql('DROP INDEX IDX_B0139AFBCE8A50AE ON promo');
        $this->addSql('ALTER TABLE promo DROP referenciels_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE promo_referenciel');
        $this->addSql('ALTER TABLE promo ADD referenciels_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE promo ADD CONSTRAINT FK_B0139AFBCE8A50AE FOREIGN KEY (referenciels_id) REFERENCES referenciel (id)');
        $this->addSql('CREATE INDEX IDX_B0139AFBCE8A50AE ON promo (referenciels_id)');
    }
}
