<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151018182513 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE apply_country (apply_id INT NOT NULL, country_id INT NOT NULL, INDEX IDX_D3BBF05C4DDCCBDE (apply_id), INDEX IDX_D3BBF05CF92F3E70 (country_id), PRIMARY KEY(apply_id, country_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE apply_country ADD CONSTRAINT FK_D3BBF05C4DDCCBDE FOREIGN KEY (apply_id) REFERENCES Apply (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE apply_country ADD CONSTRAINT FK_D3BBF05CF92F3E70 FOREIGN KEY (country_id) REFERENCES Country (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE Apply ADD availabletime INT NOT NULL, CHANGE knowEsn knowEsn LONGTEXT DEFAULT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE apply_country');
        $this->addSql('ALTER TABLE Apply DROP availabletime, CHANGE knowEsn knowEsn TINYINT(1) NOT NULL');
    }
}
