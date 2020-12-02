<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202163616 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE apprenant_livrable_partiel (id INT AUTO_INCREMENT NOT NULL, apprenants_id INT DEFAULT NULL, livrable_partiels_id INT DEFAULT NULL, filde_discussion_id INT DEFAULT NULL, etat VARCHAR(255) NOT NULL, delai DATE NOT NULL, INDEX IDX_8572D6ADD4B7C9BD (apprenants_id), INDEX IDX_8572D6AD7B292AF4 (livrable_partiels_id), UNIQUE INDEX UNIQ_8572D6AD2D916732 (filde_discussion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_ma_promo (id INT AUTO_INCREMENT NOT NULL, briefs_id INT DEFAULT NULL, promos_id INT DEFAULT NULL, INDEX IDX_6E0C4800CA062D03 (briefs_id), INDEX IDX_6E0C4800CAA392D2 (promos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_brief_groupe (id INT AUTO_INCREMENT NOT NULL, brief_id INT DEFAULT NULL, groupes_id INT DEFAULT NULL, INDEX IDX_4C4C1AA4757FABFF (brief_id), INDEX IDX_4C4C1AA4305371B (groupes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_attendu (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_attendu_brief (livrable_attendu_id INT NOT NULL, brief_id INT NOT NULL, INDEX IDX_778854ED75180ACC (livrable_attendu_id), INDEX IDX_778854ED757FABFF (brief_id), PRIMARY KEY(livrable_attendu_id, brief_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_attendu_livrable_attendu_apprenant (livrable_attendu_id INT NOT NULL, livrable_attendu_apprenant_id INT NOT NULL, INDEX IDX_300B551175180ACC (livrable_attendu_id), INDEX IDX_300B5511EE63D1F4 (livrable_attendu_apprenant_id), PRIMARY KEY(livrable_attendu_id, livrable_attendu_apprenant_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_attendu_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenants_id INT DEFAULT NULL, INDEX IDX_BDB84E34D4B7C9BD (apprenants_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel (id INT AUTO_INCREMENT NOT NULL, brief_ma_promo_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, delai VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, nombre_rendu INT NOT NULL, description VARCHAR(255) NOT NULL, nombre_corrige INT NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_37F072C557574C78 (brief_ma_promo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE livrable_partiel_niveau (livrable_partiel_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_4FEB984B519178C4 (livrable_partiel_id), INDEX IDX_4FEB984BB3E9C81 (niveau_id), PRIMARY KEY(livrable_partiel_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ressource (id INT AUTO_INCREMENT NOT NULL, briefs_id INT DEFAULT NULL, libelle VARCHAR(255) NOT NULL, delai DATE NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_939F4544CA062D03 (briefs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6ADD4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6AD7B292AF4 FOREIGN KEY (livrable_partiels_id) REFERENCES livrable_partiel (id)');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel ADD CONSTRAINT FK_8572D6AD2D916732 FOREIGN KEY (filde_discussion_id) REFERENCES filde_discussion (id)');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800CA062D03 FOREIGN KEY (briefs_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE brief_ma_promo ADD CONSTRAINT FK_6E0C4800CAA392D2 FOREIGN KEY (promos_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE etat_brief_groupe ADD CONSTRAINT FK_4C4C1AA4757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE etat_brief_groupe ADD CONSTRAINT FK_4C4C1AA4305371B FOREIGN KEY (groupes_id) REFERENCES groupe (id)');
        $this->addSql('ALTER TABLE livrable_attendu_brief ADD CONSTRAINT FK_778854ED75180ACC FOREIGN KEY (livrable_attendu_id) REFERENCES livrable_attendu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_attendu_brief ADD CONSTRAINT FK_778854ED757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_attendu_livrable_attendu_apprenant ADD CONSTRAINT FK_300B551175180ACC FOREIGN KEY (livrable_attendu_id) REFERENCES livrable_attendu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_attendu_livrable_attendu_apprenant ADD CONSTRAINT FK_300B5511EE63D1F4 FOREIGN KEY (livrable_attendu_apprenant_id) REFERENCES livrable_attendu_apprenant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_attendu_apprenant ADD CONSTRAINT FK_BDB84E34D4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE livrable_partiel ADD CONSTRAINT FK_37F072C557574C78 FOREIGN KEY (brief_ma_promo_id) REFERENCES brief_ma_promo (id)');
        $this->addSql('ALTER TABLE livrable_partiel_niveau ADD CONSTRAINT FK_4FEB984B519178C4 FOREIGN KEY (livrable_partiel_id) REFERENCES livrable_partiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livrable_partiel_niveau ADD CONSTRAINT FK_4FEB984BB3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ressource ADD CONSTRAINT FK_939F4544CA062D03 FOREIGN KEY (briefs_id) REFERENCES brief (id)');
        $this->addSql('ALTER TABLE brief_apprenant ADD brief_ma_promo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198ED57574C78 FOREIGN KEY (brief_ma_promo_id) REFERENCES brief_ma_promo (id)');
        $this->addSql('CREATE INDEX IDX_DD6198ED57574C78 ON brief_apprenant (brief_ma_promo_id)');
        $this->addSql('ALTER TABLE commentaire ADD fil_de_discussion_id INT DEFAULT NULL, ADD filde_discussion_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9E665F32 FOREIGN KEY (fil_de_discussion_id) REFERENCES filde_discussion (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC2D916732 FOREIGN KEY (filde_discussion_id) REFERENCES filde_discussion (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC9E665F32 ON commentaire (fil_de_discussion_id)');
        $this->addSql('CREATE INDEX IDX_67F068BC2D916732 ON commentaire (filde_discussion_id)');
        $this->addSql('ALTER TABLE competences_valides CHANGE niveau1 niveau1 VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief_apprenant DROP FOREIGN KEY FK_DD6198ED57574C78');
        $this->addSql('ALTER TABLE livrable_partiel DROP FOREIGN KEY FK_37F072C557574C78');
        $this->addSql('ALTER TABLE livrable_attendu_brief DROP FOREIGN KEY FK_778854ED75180ACC');
        $this->addSql('ALTER TABLE livrable_attendu_livrable_attendu_apprenant DROP FOREIGN KEY FK_300B551175180ACC');
        $this->addSql('ALTER TABLE livrable_attendu_livrable_attendu_apprenant DROP FOREIGN KEY FK_300B5511EE63D1F4');
        $this->addSql('ALTER TABLE apprenant_livrable_partiel DROP FOREIGN KEY FK_8572D6AD7B292AF4');
        $this->addSql('ALTER TABLE livrable_partiel_niveau DROP FOREIGN KEY FK_4FEB984B519178C4');
        $this->addSql('DROP TABLE apprenant_livrable_partiel');
        $this->addSql('DROP TABLE brief_ma_promo');
        $this->addSql('DROP TABLE etat_brief_groupe');
        $this->addSql('DROP TABLE livrable_attendu');
        $this->addSql('DROP TABLE livrable_attendu_brief');
        $this->addSql('DROP TABLE livrable_attendu_livrable_attendu_apprenant');
        $this->addSql('DROP TABLE livrable_attendu_apprenant');
        $this->addSql('DROP TABLE livrable_partiel');
        $this->addSql('DROP TABLE livrable_partiel_niveau');
        $this->addSql('DROP TABLE ressource');
        $this->addSql('DROP INDEX IDX_DD6198ED57574C78 ON brief_apprenant');
        $this->addSql('ALTER TABLE brief_apprenant DROP brief_ma_promo_id');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9E665F32');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC2D916732');
        $this->addSql('DROP INDEX IDX_67F068BC9E665F32 ON commentaire');
        $this->addSql('DROP INDEX IDX_67F068BC2D916732 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP fil_de_discussion_id, DROP filde_discussion_id');
        $this->addSql('ALTER TABLE competences_valides CHANGE niveau1 niveau1 TINYINT(1) NOT NULL');
    }
}
