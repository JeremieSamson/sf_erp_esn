<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150424140121 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Esner ADD CONSTRAINT FK_CB73468E97C22770 FOREIGN KEY (erasmusProgramme_id) REFERENCES Country (id)');
        $this->addSql('CREATE INDEX IDX_CB73468E97C22770 ON Esner (erasmusProgramme_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Esner DROP FOREIGN KEY FK_CB73468E97C22770');
        $this->addSql('DROP INDEX IDX_CB73468E97C22770 ON Esner');
    }
}
