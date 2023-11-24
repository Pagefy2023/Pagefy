<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231121075620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livres_categories (categorie_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_96B809B8BCF5E72D (categorie_id), INDEX IDX_96B809B837D925CB (livre_id), PRIMARY KEY(categorie_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livres_categories ADD CONSTRAINT FK_96B809B8BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livres_categories ADD CONSTRAINT FK_96B809B837D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livres_categories DROP FOREIGN KEY FK_96B809B8BCF5E72D');
        $this->addSql('ALTER TABLE livres_categories DROP FOREIGN KEY FK_96B809B837D925CB');
        $this->addSql('DROP TABLE livres_categories');
    }
}
