<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20190404211025 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PermanenceReport ADD CONSTRAINT FK_F014AAC17E3C61F9 FOREIGN KEY (owner_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Apply RENAME INDEX idx_7ceea31b1c9da55a TO IDX_7CEEA31B1C9DA55');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Apply RENAME INDEX idx_7ceea31b1c9da55 TO IDX_7CEEA31B1C9DA55A');
        $this->addSql('ALTER TABLE PermanenceReport DROP FOREIGN KEY FK_F014AAC17E3C61F9');
    }
}
