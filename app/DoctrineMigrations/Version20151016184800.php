<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151016184800 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PermanenceReport ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE PermanenceReport ADD CONSTRAINT FK_F014AAC17E3C61F9 FOREIGN KEY (owner_id) REFERENCES User (id)');
        $this->addSql('CREATE INDEX IDX_F014AAC17E3C61F9 ON PermanenceReport (owner_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PermanenceReport DROP FOREIGN KEY FK_F014AAC17E3C61F9');
        $this->addSql('DROP INDEX IDX_F014AAC17E3C61F9 ON PermanenceReport');
        $this->addSql('ALTER TABLE PermanenceReport DROP owner_id');
    }
}
