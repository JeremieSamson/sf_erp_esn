<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160327161149 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Cash (id INT AUTO_INCREMENT NOT NULL, hundred INT NOT NULL, fivty INT NOT NULL, twenty INT NOT NULL, ten INT NOT NULL, five INT NOT NULL, two INT NOT NULL, one INT NOT NULL, fivtycent INT NOT NULL, twentycent INT NOT NULL, tencent INT NOT NULL, fivecent INT NOT NULL, twocent INT NOT NULL, onecent INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE PermanenceReport ADD cash_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE PermanenceReport ADD CONSTRAINT FK_F014AAC13D7A0C28 FOREIGN KEY (cash_id) REFERENCES Cash (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F014AAC13D7A0C28 ON PermanenceReport (cash_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Cash');
        $this->addSql('DROP INDEX UNIQ_F014AAC13D7A0C28 ON PermanenceReport');
        $this->addSql('ALTER TABLE PermanenceReport DROP cash_id');
    }
}
