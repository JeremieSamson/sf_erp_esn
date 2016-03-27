<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160327173928 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE PermanenceReport DROP FOREIGN KEY FK_F014AAC13D7A0C28');
        $this->addSql('DROP TABLE Cash');
        $this->addSql('DROP INDEX UNIQ_F014AAC13D7A0C28 ON PermanenceReport');
        $this->addSql('ALTER TABLE PermanenceReport ADD hundred INT NOT NULL, ADD fivty INT NOT NULL, ADD twenty INT NOT NULL, ADD ten INT NOT NULL, ADD five INT NOT NULL, ADD two INT NOT NULL, ADD one INT NOT NULL, ADD fivtycent INT NOT NULL, ADD twentycent INT NOT NULL, ADD tencent INT NOT NULL, ADD fivecent INT NOT NULL, ADD twocent INT NOT NULL, ADD onecent INT NOT NULL, DROP cash_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Cash (id INT AUTO_INCREMENT NOT NULL, hundred INT NOT NULL, fivty INT NOT NULL, twenty INT NOT NULL, ten INT NOT NULL, five INT NOT NULL, two INT NOT NULL, one INT NOT NULL, fivtycent INT NOT NULL, twentycent INT NOT NULL, tencent INT NOT NULL, fivecent INT NOT NULL, twocent INT NOT NULL, onecent INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE PermanenceReport DROP FOREIGN KEY FK_F014AAC17E3C61F9');
        $this->addSql('ALTER TABLE PermanenceReport ADD cash_id INT DEFAULT NULL, DROP hundred, DROP fivty, DROP twenty, DROP ten, DROP five, DROP two, DROP one, DROP fivtycent, DROP twentycent, DROP tencent, DROP fivecent, DROP twocent, DROP onecent');
        $this->addSql('ALTER TABLE PermanenceReport ADD CONSTRAINT FK_F014AAC13D7A0C28 FOREIGN KEY (cash_id) REFERENCES Cash (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F014AAC13D7A0C28 ON PermanenceReport (cash_id)');
    }
}
