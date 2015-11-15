<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151115184104 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Activity (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, createdAt DATETIME NOT NULL, old VARCHAR(255) NOT NULL, new VARCHAR(255) NOT NULL, INDEX IDX_55026B0CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Activity ADD CONSTRAINT FK_55026B0CA76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Activity CHANGE old old VARCHAR(255) DEFAULT NULL, CHANGE new new VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE Activity ADD action VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE Activity');
    }
}
