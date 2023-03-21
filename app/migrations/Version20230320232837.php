<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320232837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recibo DROP FOREIGN KEY FK_42A928FAEB30D47A');
        $this->addSql('ALTER TABLE hospedagem DROP FOREIGN KEY FK_BDD7A47F2C458692');
        $this->addSql('ALTER TABLE hospedagem DROP FOREIGN KEY FK_BDD7A47FB837F0EA');
        $this->addSql('DROP TABLE hospedagem');
        $this->addSql('DROP INDEX UNIQ_42A928FAEB30D47A ON recibo');
        $this->addSql('ALTER TABLE recibo DROP hospedagem_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospedagem (id INT AUTO_INCREMENT NOT NULL, cachorro_id INT DEFAULT NULL, recibo_id INT DEFAULT NULL, data_inicio DATETIME NOT NULL, UNIQUE INDEX UNIQ_BDD7A47F2C458692 (recibo_id), INDEX IDX_BDD7A47FB837F0EA (cachorro_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE hospedagem ADD CONSTRAINT FK_BDD7A47F2C458692 FOREIGN KEY (recibo_id) REFERENCES recibo (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE hospedagem ADD CONSTRAINT FK_BDD7A47FB837F0EA FOREIGN KEY (cachorro_id) REFERENCES cachorro (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE recibo ADD hospedagem_id INT NOT NULL');
        $this->addSql('ALTER TABLE recibo ADD CONSTRAINT FK_42A928FAEB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42A928FAEB30D47A ON recibo (hospedagem_id)');
    }
}
