<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151018160529 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Apply ADD nationality_id INT NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD lastname VARCHAR(255) NOT NULL, ADD facebook_id VARCHAR(255) DEFAULT NULL, ADD student TINYINT(1) NOT NULL, ADD olderasmus TINYINT(1) NOT NULL, DROP name, DROP surname, CHANGE email email VARCHAR(255) NOT NULL, CHANGE motivation motivation LONGTEXT DEFAULT NULL, CHANGE skill skill LONGTEXT DEFAULT NULL, CHANGE knowEsn knowEsn TINYINT(1) NOT NULL, CHANGE date birthdate DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE Apply ADD CONSTRAINT FK_7CEEA31B1C9DA55 FOREIGN KEY (nationality_id) REFERENCES Country (id)');
        $this->addSql('CREATE INDEX IDX_7CEEA31B1C9DA55 ON Apply (nationality_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Apply DROP FOREIGN KEY FK_7CEEA31B1C9DA55');
        $this->addSql('DROP INDEX IDX_7CEEA31B1C9DA55 ON Apply');
        $this->addSql('ALTER TABLE Apply ADD surname VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, DROP nationality_id, DROP firstname, DROP lastname, DROP student, DROP olderasmus, CHANGE email email VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE motivation motivation VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE skill skill VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE knowEsn knowEsn VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE facebook_id name VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, CHANGE birthdate date DATE DEFAULT NULL');
    }
}
