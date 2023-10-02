<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230925095438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE extrait DROP FOREIGN KEY FK_C4B5D9541FBEEF7B');
        $this->addSql('DROP TABLE extrait');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE extrait (id INT AUTO_INCREMENT NOT NULL, chapitre_id INT NOT NULL, UNIQUE INDEX UNIQ_C4B5D9541FBEEF7B (chapitre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE extrait ADD CONSTRAINT FK_C4B5D9541FBEEF7B FOREIGN KEY (chapitre_id) REFERENCES chapitre (id)');
    }
}
