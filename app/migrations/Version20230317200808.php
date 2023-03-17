<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317200808 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cachorro (id INT AUTO_INCREMENT NOT NULL, dono_id INT NOT NULL, nome VARCHAR(255) NOT NULL, porte INT NOT NULL, agressividade DOUBLE PRECISION NOT NULL, INDEX IDX_C59142CEC770385C (dono_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dono (id INT AUTO_INCREMENT NOT NULL, nome VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospedagem (id INT AUTO_INCREMENT NOT NULL, cachorro_id INT NOT NULL, data_inicio DATETIME NOT NULL, data_fim DATETIME NOT NULL, UNIQUE INDEX UNIQ_BDD7A47FB837F0EA (cachorro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicos_extras (id INT AUTO_INCREMENT NOT NULL, hospedagem_id INT DEFAULT NULL, banho TINYINT(1) NOT NULL, sessao_adestramento TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_2BDB2D49EB30D47A (hospedagem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cachorro ADD CONSTRAINT FK_C59142CEC770385C FOREIGN KEY (dono_id) REFERENCES dono (id)');
        $this->addSql('ALTER TABLE hospedagem ADD CONSTRAINT FK_BDD7A47FB837F0EA FOREIGN KEY (cachorro_id) REFERENCES cachorro (id)');
        $this->addSql('ALTER TABLE servicos_extras ADD CONSTRAINT FK_2BDB2D49EB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cachorro DROP FOREIGN KEY FK_C59142CEC770385C');
        $this->addSql('ALTER TABLE hospedagem DROP FOREIGN KEY FK_BDD7A47FB837F0EA');
        $this->addSql('ALTER TABLE servicos_extras DROP FOREIGN KEY FK_2BDB2D49EB30D47A');
        $this->addSql('DROP TABLE cachorro');
        $this->addSql('DROP TABLE dono');
        $this->addSql('DROP TABLE hospedagem');
        $this->addSql('DROP TABLE servicos_extras');
        $this->addSql('DROP TABLE user');
    }
}
