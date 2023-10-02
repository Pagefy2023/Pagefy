<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230924220711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre ADD extrait_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F99E6057ACD FOREIGN KEY (extrait_id) REFERENCES extrait (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AC634F99E6057ACD ON livre (extrait_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre DROP FOREIGN KEY FK_AC634F99E6057ACD');
        $this->addSql('DROP INDEX UNIQ_AC634F99E6057ACD ON livre');
        $this->addSql('ALTER TABLE livre DROP extrait_id');
    }
}
