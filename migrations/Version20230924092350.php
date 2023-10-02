<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230924092350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE extrait DROP FOREIGN KEY FK_C4B5D95437D925CB');
        $this->addSql('DROP INDEX UNIQ_C4B5D95437D925CB ON extrait');
        $this->addSql('ALTER TABLE extrait DROP livre_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE extrait ADD livre_id INT NOT NULL');
        $this->addSql('ALTER TABLE extrait ADD CONSTRAINT FK_C4B5D95437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C4B5D95437D925CB ON extrait (livre_id)');
    }
}
