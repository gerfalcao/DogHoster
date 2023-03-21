<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320132351 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospedagem_servicos_adicionais (hospedagem_id INT NOT NULL, servicos_adicionais_id INT NOT NULL, INDEX IDX_2A5ED11DEB30D47A (hospedagem_id), INDEX IDX_2A5ED11DE63B5DED (servicos_adicionais_id), PRIMARY KEY(hospedagem_id, servicos_adicionais_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recibo (id INT AUTO_INCREMENT NOT NULL, hospedagem_id INT NOT NULL, UNIQUE INDEX UNIQ_42A928FAEB30D47A (hospedagem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE servicos_adicionais (id INT AUTO_INCREMENT NOT NULL, banho INT DEFAULT NULL, sessao_adestramento INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hospedagem_servicos_adicionais ADD CONSTRAINT FK_2A5ED11DEB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospedagem_servicos_adicionais ADD CONSTRAINT FK_2A5ED11DE63B5DED FOREIGN KEY (servicos_adicionais_id) REFERENCES servicos_adicionais (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recibo ADD CONSTRAINT FK_42A928FAEB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospedagem_servicos_adicionais DROP FOREIGN KEY FK_2A5ED11DEB30D47A');
        $this->addSql('ALTER TABLE hospedagem_servicos_adicionais DROP FOREIGN KEY FK_2A5ED11DE63B5DED');
        $this->addSql('ALTER TABLE recibo DROP FOREIGN KEY FK_42A928FAEB30D47A');
        $this->addSql('DROP TABLE hospedagem_servicos_adicionais');
        $this->addSql('DROP TABLE recibo');
        $this->addSql('DROP TABLE servicos_adicionais');
    }
}
