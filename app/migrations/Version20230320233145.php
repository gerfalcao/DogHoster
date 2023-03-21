<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320233145 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospedagem (id INT AUTO_INCREMENT NOT NULL, recibo_id INT DEFAULT NULL, data_inicio DATETIME NOT NULL, data_fim DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_BDD7A47F2C458692 (recibo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hospedagem_cachorro (hospedagem_id INT NOT NULL, cachorro_id INT NOT NULL, INDEX IDX_227CDFBCEB30D47A (hospedagem_id), INDEX IDX_227CDFBCB837F0EA (cachorro_id), PRIMARY KEY(hospedagem_id, cachorro_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hospedagem ADD CONSTRAINT FK_BDD7A47F2C458692 FOREIGN KEY (recibo_id) REFERENCES recibo (id)');
        $this->addSql('ALTER TABLE hospedagem_cachorro ADD CONSTRAINT FK_227CDFBCEB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospedagem_cachorro ADD CONSTRAINT FK_227CDFBCB837F0EA FOREIGN KEY (cachorro_id) REFERENCES cachorro (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospedagem DROP FOREIGN KEY FK_BDD7A47F2C458692');
        $this->addSql('ALTER TABLE hospedagem_cachorro DROP FOREIGN KEY FK_227CDFBCEB30D47A');
        $this->addSql('ALTER TABLE hospedagem_cachorro DROP FOREIGN KEY FK_227CDFBCB837F0EA');
        $this->addSql('DROP TABLE hospedagem');
        $this->addSql('DROP TABLE hospedagem_cachorro');
    }
}
