<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230323142201 extends AbstractMigration
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
        $this->addSql('CREATE TABLE hospedagem (id INT AUTO_INCREMENT NOT NULL, recibo_id INT DEFAULT NULL, cachorro_id INT NOT NULL, data_inicio DATETIME NOT NULL, data_fim DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_BDD7A47F2C458692 (recibo_id), INDEX IDX_BDD7A47FB837F0EA (cachorro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ocorrencias (id INT AUTO_INCREMENT NOT NULL, hospedagem_id INT NOT NULL, ocorrencia LONGTEXT NOT NULL, INDEX IDX_2167F01CEB30D47A (hospedagem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recibo (id INT AUTO_INCREMENT NOT NULL, cachorro_dono VARCHAR(255) NOT NULL, preco_servicos DOUBLE PRECISION DEFAULT NULL, preco_diaria DOUBLE PRECISION NOT NULL, preco_total DOUBLE PRECISION NOT NULL, data_fechamento DATETIME DEFAULT NULL, tempo_total_ VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicos (id INT AUTO_INCREMENT NOT NULL, hospedagem_id INT NOT NULL, nome VARCHAR(255) NOT NULL, preco INT NOT NULL, quantidade INT NOT NULL, INDEX IDX_89DD09E3EB30D47A (hospedagem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cachorro ADD CONSTRAINT FK_C59142CEC770385C FOREIGN KEY (dono_id) REFERENCES dono (id)');
        $this->addSql('ALTER TABLE hospedagem ADD CONSTRAINT FK_BDD7A47F2C458692 FOREIGN KEY (recibo_id) REFERENCES recibo (id)');
        $this->addSql('ALTER TABLE hospedagem ADD CONSTRAINT FK_BDD7A47FB837F0EA FOREIGN KEY (cachorro_id) REFERENCES cachorro (id)');
        $this->addSql('ALTER TABLE ocorrencias ADD CONSTRAINT FK_2167F01CEB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id)');
        $this->addSql('ALTER TABLE servicos ADD CONSTRAINT FK_89DD09E3EB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cachorro DROP FOREIGN KEY FK_C59142CEC770385C');
        $this->addSql('ALTER TABLE hospedagem DROP FOREIGN KEY FK_BDD7A47F2C458692');
        $this->addSql('ALTER TABLE hospedagem DROP FOREIGN KEY FK_BDD7A47FB837F0EA');
        $this->addSql('ALTER TABLE ocorrencias DROP FOREIGN KEY FK_2167F01CEB30D47A');
        $this->addSql('ALTER TABLE servicos DROP FOREIGN KEY FK_89DD09E3EB30D47A');
        $this->addSql('DROP TABLE cachorro');
        $this->addSql('DROP TABLE dono');
        $this->addSql('DROP TABLE hospedagem');
        $this->addSql('DROP TABLE ocorrencias');
        $this->addSql('DROP TABLE recibo');
        $this->addSql('DROP TABLE servicos');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
