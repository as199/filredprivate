<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201202140330 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brief (id INT AUTO_INCREMENT NOT NULL, formateurs_id INT DEFAULT NULL, langue VARCHAR(255) NOT NULL, nom_brief VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_1FBB1007FB0881C8 (formateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_tags (brief_id INT NOT NULL, tags_id INT NOT NULL, INDEX IDX_D4F170DD757FABFF (brief_id), INDEX IDX_D4F170DD8D7B4FB4 (tags_id), PRIMARY KEY(brief_id, tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_niveau (brief_id INT NOT NULL, niveau_id INT NOT NULL, INDEX IDX_1BF05631757FABFF (brief_id), INDEX IDX_1BF05631B3E9C81 (niveau_id), PRIMARY KEY(brief_id, niveau_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE brief_apprenant (id INT AUTO_INCREMENT NOT NULL, apprenants_id INT DEFAULT NULL, status TINYINT(1) NOT NULL, INDEX IDX_DD6198EDD4B7C9BD (apprenants_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE chat (id INT AUTO_INCREMENT NOT NULL, users_id INT DEFAULT NULL, promos_id INT DEFAULT NULL, message LONGTEXT NOT NULL, pieces_jointes LONGBLOB DEFAULT NULL, INDEX IDX_659DF2AA67B3B43D (users_id), INDEX IDX_659DF2AACAA392D2 (promos_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, formateurs_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_67F068BCFB0881C8 (formateurs_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE brief ADD CONSTRAINT FK_1FBB1007FB0881C8 FOREIGN KEY (formateurs_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE brief_tags ADD CONSTRAINT FK_D4F170DD757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_tags ADD CONSTRAINT FK_D4F170DD8D7B4FB4 FOREIGN KEY (tags_id) REFERENCES tags (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_niveau ADD CONSTRAINT FK_1BF05631757FABFF FOREIGN KEY (brief_id) REFERENCES brief (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_niveau ADD CONSTRAINT FK_1BF05631B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE brief_apprenant ADD CONSTRAINT FK_DD6198EDD4B7C9BD FOREIGN KEY (apprenants_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AA67B3B43D FOREIGN KEY (users_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE chat ADD CONSTRAINT FK_659DF2AACAA392D2 FOREIGN KEY (promos_id) REFERENCES promo (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB0881C8 FOREIGN KEY (formateurs_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brief_tags DROP FOREIGN KEY FK_D4F170DD757FABFF');
        $this->addSql('ALTER TABLE brief_niveau DROP FOREIGN KEY FK_1BF05631757FABFF');
        $this->addSql('DROP TABLE brief');
        $this->addSql('DROP TABLE brief_tags');
        $this->addSql('DROP TABLE brief_niveau');
        $this->addSql('DROP TABLE brief_apprenant');
        $this->addSql('DROP TABLE chat');
        $this->addSql('DROP TABLE commentaire');
    }
}
