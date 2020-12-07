<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206031422 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promo_groupe (promo_id INT NOT NULL, groupe_id INT NOT NULL, INDEX IDX_1D3C936CD0C07AFF (promo_id), INDEX IDX_1D3C936C7A45358C (groupe_id), PRIMARY KEY(promo_id, groupe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promo_groupe ADD CONSTRAINT FK_1D3C936CD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_groupe ADD CONSTRAINT FK_1D3C936C7A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_ma_promo ADD promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_6E0C4800D0C07AFF ON brief_ma_promo (promo_id)');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AACAA392D2');
        $this->addSql('DROP INDEX IDX_659DF2AACAA392D2 ON chat');
        $this->addSql('ALTER TABLE chat CHANGE promos_id promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AAD0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_659DF2AAD0C07AFF ON chat (promo_id)');
        $this->addSql('ALTER TABLE competences_valides DROP FOREIGN KEY FK_9EEA096ECAA392D2');
        $this->addSql('DROP INDEX IDX_9EEA096ECAA392D2 ON competences_valides');
        $this->addSql('ALTER TABLE competences_valides CHANGE promos_id promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096ED0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_9EEA096ED0C07AFF ON competences_valides (promo_id)');
        $this->addSql('ALTER TABLE groupe DROP FOREIGN KEY FK_4B98C21CAA392D2');
        $this->addSql('DROP INDEX IDX_4B98C21CAA392D2 ON groupe');
        $this->addSql('ALTER TABLE groupe DROP promos_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE promo_groupe');
        $this->addSql('ALTER TABLE brief_ma_promo DROP FOREIGN KEY FK_6E0C4800D0C07AFF');
        $this->addSql('DROP INDEX IDX_6E0C4800D0C07AFF ON brief_ma_promo');
        $this->addSql('ALTER TABLE brief_ma_promo DROP promo_id');
        $this->addSql('ALTER TABLE chat DROP FOREIGN KEY FK_659DF2AAD0C07AFF');
        $this->addSql('DROP INDEX IDX_659DF2AAD0C07AFF ON chat');
        $this->addSql('ALTER TABLE chat CHANGE promo_id promos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AACAA392D2 FOREIGN KEY (promos_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_659DF2AACAA392D2 ON chat (promos_id)');
        $this->addSql('ALTER TABLE competences_valides DROP FOREIGN KEY FK_9EEA096ED0C07AFF');
        $this->addSql('DROP INDEX IDX_9EEA096ED0C07AFF ON competences_valides');
        $this->addSql('ALTER TABLE competences_valides CHANGE promo_id promos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE competences_valides ADD CONSTRAINT FK_9EEA096ECAA392D2 FOREIGN KEY (promos_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_9EEA096ECAA392D2 ON competences_valides (promos_id)');
        $this->addSql('ALTER TABLE groupe ADD promos_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C21CAA392D2 FOREIGN KEY (promos_id) REFERENCES promo (id)');
        $this->addSql('CREATE INDEX IDX_4B98C21CAA392D2 ON groupe (promos_id)');
    }
}
