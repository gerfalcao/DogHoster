<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321124123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ocorrencias (id INT AUTO_INCREMENT NOT NULL, hospedagem_id INT NOT NULL, ocorrencia LONGTEXT NOT NULL, INDEX IDX_2167F01CEB30D47A (hospedagem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ocorrencias ADD CONSTRAINT FK_2167F01CEB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ocorrencias DROP FOREIGN KEY FK_2167F01CEB30D47A');
        $this->addSql('DROP TABLE ocorrencias');
    }
}
