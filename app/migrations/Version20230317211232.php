<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230317211232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospedagem_cachorro (hospedagem_id INT NOT NULL, cachorro_id INT NOT NULL, INDEX IDX_227CDFBCEB30D47A (hospedagem_id), INDEX IDX_227CDFBCB837F0EA (cachorro_id), PRIMARY KEY(hospedagem_id, cachorro_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE hospedagem_cachorro ADD CONSTRAINT FK_227CDFBCEB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospedagem_cachorro ADD CONSTRAINT FK_227CDFBCB837F0EA FOREIGN KEY (cachorro_id) REFERENCES cachorro (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospedagem DROP FOREIGN KEY FK_BDD7A47FB837F0EA');
        $this->addSql('DROP INDEX UNIQ_BDD7A47FB837F0EA ON hospedagem');
        $this->addSql('ALTER TABLE hospedagem DROP cachorro_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospedagem_cachorro DROP FOREIGN KEY FK_227CDFBCEB30D47A');
        $this->addSql('ALTER TABLE hospedagem_cachorro DROP FOREIGN KEY FK_227CDFBCB837F0EA');
        $this->addSql('DROP TABLE hospedagem_cachorro');
        $this->addSql('ALTER TABLE hospedagem ADD cachorro_id INT NOT NULL');
        $this->addSql('ALTER TABLE hospedagem ADD CONSTRAINT FK_BDD7A47FB837F0EA FOREIGN KEY (cachorro_id) REFERENCES cachorro (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_BDD7A47FB837F0EA ON hospedagem (cachorro_id)');
    }
}
