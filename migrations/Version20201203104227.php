<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201203104227 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9E665F32');
        $this->addSql('DROP INDEX IDX_67F068BC9E665F32 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE fil_de_discussion_id filde_discussion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC2D916732 FOREIGN KEY (filde_discussion_id) REFERENCES filde_discussion (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC2D916732 ON commentaire (filde_discussion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC2D916732');
        $this->addSql('DROP INDEX IDX_67F068BC2D916732 ON commentaire');
        $this->addSql('ALTER TABLE commentaire CHANGE filde_discussion_id fil_de_discussion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9E665F32 FOREIGN KEY (fil_de_discussion_id) REFERENCES filde_discussion (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC9E665F32 ON commentaire (fil_de_discussion_id)');
    }
}
