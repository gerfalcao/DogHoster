<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320115059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE servicos_extras DROP FOREIGN KEY FK_2BDB2D49EB30D47A');
        $this->addSql('DROP TABLE servicos_extras');
        $this->addSql('ALTER TABLE hospedagem DROP tem_banho, DROP tem_adestramento');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE servicos_extras (id INT AUTO_INCREMENT NOT NULL, hospedagem_id INT DEFAULT NULL, banho TINYINT(1) NOT NULL, sessao_adestramento TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_2BDB2D49EB30D47A (hospedagem_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE servicos_extras ADD CONSTRAINT FK_2BDB2D49EB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE hospedagem ADD tem_banho TINYINT(1) NOT NULL, ADD tem_adestramento TINYINT(1) NOT NULL');
    }
}
