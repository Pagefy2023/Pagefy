<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231001222149 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE table_des_matieres_livre DROP FOREIGN KEY FK_488B84D837D925CB');
        $this->addSql('ALTER TABLE table_des_matieres_livre DROP FOREIGN KEY FK_488B84D874FEE4CB');
        $this->addSql('DROP TABLE table_des_matieres');
        $this->addSql('DROP TABLE table_des_matieres_livre');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE table_des_matieres (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE table_des_matieres_livre (table_des_matieres_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_488B84D837D925CB (livre_id), INDEX IDX_488B84D874FEE4CB (table_des_matieres_id), PRIMARY KEY(table_des_matieres_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE table_des_matieres_livre ADD CONSTRAINT FK_488B84D837D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE table_des_matieres_livre ADD CONSTRAINT FK_488B84D874FEE4CB FOREIGN KEY (table_des_matieres_id) REFERENCES table_des_matieres (id) ON DELETE CASCADE');
    }
}
