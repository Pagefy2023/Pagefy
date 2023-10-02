<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231001215002 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D6494419DE7D');
        $this->addSql('ALTER TABLE bibliotheque_livre DROP FOREIGN KEY FK_929FAFE837D925CB');
        $this->addSql('ALTER TABLE bibliotheque_livre DROP FOREIGN KEY FK_929FAFE84419DE7D');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('DROP TABLE bibliotheque_livre');
        $this->addSql('DROP TABLE note');
        $this->addSql('ALTER TABLE livre DROP note');
        $this->addSql('DROP INDEX IDX_8D93D6494419DE7D ON user');
        $this->addSql('ALTER TABLE user DROP bibliotheque_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bibliotheque (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bibliotheque_livre (bibliotheque_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_929FAFE837D925CB (livre_id), INDEX IDX_929FAFE84419DE7D (bibliotheque_id), PRIMARY KEY(bibliotheque_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, valeur INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE bibliotheque_livre ADD CONSTRAINT FK_929FAFE837D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE bibliotheque_livre ADD CONSTRAINT FK_929FAFE84419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre ADD note INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD bibliotheque_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D6494419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('CREATE INDEX IDX_8D93D6494419DE7D ON user (bibliotheque_id)');
    }
}
