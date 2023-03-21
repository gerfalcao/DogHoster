<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320140106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospedagem ADD recibo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE hospedagem ADD CONSTRAINT FK_BDD7A47F2C458692 FOREIGN KEY (recibo_id) REFERENCES recibo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDD7A47F2C458692 ON hospedagem (recibo_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospedagem DROP FOREIGN KEY FK_BDD7A47F2C458692');
        $this->addSql('DROP INDEX UNIQ_BDD7A47F2C458692 ON hospedagem');
        $this->addSql('ALTER TABLE hospedagem DROP recibo_id');
    }
}
