<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230321021300 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE servicos (id INT AUTO_INCREMENT NOT NULL, hospedagem_id INT NOT NULL, nome VARCHAR(255) NOT NULL, preco INT NOT NULL, quantidade INT NOT NULL, INDEX IDX_89DD09E3EB30D47A (hospedagem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE servicos ADD CONSTRAINT FK_89DD09E3EB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id)');
        $this->addSql('ALTER TABLE recibo DROP servicos_adicionais');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servicos DROP FOREIGN KEY FK_89DD09E3EB30D47A');
        $this->addSql('DROP TABLE servicos');
        $this->addSql('ALTER TABLE recibo ADD servicos_adicionais VARCHAR(255) DEFAULT NULL');
    }
}
