<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151014212555 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE User CHANGE university_id university_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE User CHANGE esncard esncard VARCHAR(50) DEFAULT NULL');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977419C3385 FOREIGN KEY (pole_id) REFERENCES Pole (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA179774B89032C FOREIGN KEY (post_id) REFERENCES Post (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA1797797C22770 FOREIGN KEY (erasmusProgramme_id) REFERENCES Country (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977DB403044 FOREIGN KEY (mentor_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977309D1878 FOREIGN KEY (university_id) REFERENCES University (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA179771C9DA55 FOREIGN KEY (nationality_id) REFERENCES Country (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977419C3385');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA179774B89032C');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA1797797C22770');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977DB403044');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977309D1878');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA179771C9DA55');
        $this->addSql('ALTER TABLE User CHANGE university_id university_id INT NOT NULL');
        $this->addSql('ALTER TABLE User CHANGE esncard esncard VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci');
    }
}
