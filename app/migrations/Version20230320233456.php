<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230320233456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE hospedagem_cachorro DROP FOREIGN KEY FK_227CDFBCB837F0EA');
        $this->addSql('ALTER TABLE hospedagem_cachorro DROP FOREIGN KEY FK_227CDFBCEB30D47A');
        $this->addSql('DROP TABLE hospedagem_cachorro');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE hospedagem_cachorro (hospedagem_id INT NOT NULL, cachorro_id INT NOT NULL, INDEX IDX_227CDFBCB837F0EA (cachorro_id), INDEX IDX_227CDFBCEB30D47A (hospedagem_id), PRIMARY KEY(hospedagem_id, cachorro_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE hospedagem_cachorro ADD CONSTRAINT FK_227CDFBCB837F0EA FOREIGN KEY (cachorro_id) REFERENCES cachorro (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hospedagem_cachorro ADD CONSTRAINT FK_227CDFBCEB30D47A FOREIGN KEY (hospedagem_id) REFERENCES hospedagem (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
