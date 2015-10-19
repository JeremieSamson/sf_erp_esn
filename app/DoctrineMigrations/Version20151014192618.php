<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20151014192618 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Esner DROP FOREIGN KEY FK_CB73468EDB403044');
        $this->addSql('ALTER TABLE InfoEsner DROP FOREIGN KEY FK_4DCC66B8E43728BA');
        $this->addSql('ALTER TABLE Erasmus DROP FOREIGN KEY FK_CB268DA356D34F95');
        $this->addSql('ALTER TABLE Esner DROP FOREIGN KEY FK_CB73468E56D34F95');
        $this->addSql('DROP TABLE Erasmus');
        $this->addSql('DROP TABLE Esner');
        $this->addSql('DROP TABLE InfoEsner');
        $this->addSql('DROP TABLE Member');
        $this->addSql('ALTER TABLE ParticipateTrip DROP FOREIGN KEY FK_E3253ECD70E4FA78');
        $this->addSql('DROP INDEX IDX_E3253ECD70E4FA78 ON ParticipateTrip');
        $this->addSql('ALTER TABLE ParticipateTrip CHANGE member user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ParticipateTrip ADD CONSTRAINT FK_E3253ECD8D93D649 FOREIGN KEY (user) REFERENCES User (id)');
        $this->addSql('CREATE INDEX IDX_E3253ECD8D93D649 ON ParticipateTrip (user)');
        $this->addSql('ALTER TABLE User ADD pole_id INT DEFAULT NULL, ADD post_id INT DEFAULT NULL, ADD mentor_id INT DEFAULT NULL, ADD university_id INT NOT NULL, ADD nationality_id INT NOT NULL, ADD address VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(50) DEFAULT NULL, ADD zipcode VARCHAR(5) DEFAULT NULL, ADD hascare TINYINT(1) DEFAULT NULL, ADD active TINYINT(1) DEFAULT NULL, ADD erasmus_year_start DATE DEFAULT NULL, ADD erasmus_year_end DATE DEFAULT NULL, ADD esncard VARCHAR(50) NOT NULL, ADD arrivalDate DATE DEFAULT NULL, ADD leavingDate DATE DEFAULT NULL, ADD esner TINYINT(1) NOT NULL, ADD inscription DATE DEFAULT NULL, ADD study VARCHAR(255) DEFAULT NULL, ADD facebook_id VARCHAR(255) DEFAULT NULL, ADD erasmusProgramme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977419C3385 FOREIGN KEY (pole_id) REFERENCES Pole (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA179774B89032C FOREIGN KEY (post_id) REFERENCES Post (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA1797797C22770 FOREIGN KEY (erasmusProgramme_id) REFERENCES Country (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977DB403044 FOREIGN KEY (mentor_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA17977309D1878 FOREIGN KEY (university_id) REFERENCES University (id)');
        $this->addSql('ALTER TABLE User ADD CONSTRAINT FK_2DA179771C9DA55 FOREIGN KEY (nationality_id) REFERENCES Country (id)');
        $this->addSql('CREATE INDEX IDX_2DA17977419C3385 ON User (pole_id)');
        $this->addSql('CREATE INDEX IDX_2DA179774B89032C ON User (post_id)');
        $this->addSql('CREATE INDEX IDX_2DA1797797C22770 ON User (erasmusProgramme_id)');
        $this->addSql('CREATE INDEX IDX_2DA17977DB403044 ON User (mentor_id)');
        $this->addSql('CREATE INDEX IDX_2DA17977309D1878 ON User (university_id)');
        $this->addSql('CREATE INDEX IDX_2DA179771C9DA55 ON User (nationality_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE Erasmus (id INT AUTO_INCREMENT NOT NULL, id_member INT NOT NULL, esncard VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, arrivalDate DATE DEFAULT NULL, leavingDate DATE DEFAULT NULL, UNIQUE INDEX UNIQ_CB268DA356D34F95 (id_member), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Esner (id INT AUTO_INCREMENT NOT NULL, pole_id INT DEFAULT NULL, post_id INT DEFAULT NULL, id_member INT NOT NULL, mentor_id INT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, city VARCHAR(50) DEFAULT NULL COLLATE utf8_unicode_ci, zipcode INT DEFAULT NULL, hascare TINYINT(1) DEFAULT NULL, erasmus_year_start DATE DEFAULT NULL, erasmus_year_end DATE DEFAULT NULL, erasmusProgramme_id INT DEFAULT NULL, active TINYINT(1) DEFAULT NULL, UNIQUE INDEX UNIQ_CB73468E56D34F95 (id_member), INDEX IDX_CB73468E419C3385 (pole_id), INDEX IDX_CB73468E97C22770 (erasmusProgramme_id), INDEX IDX_CB73468E4B89032C (post_id), INDEX IDX_CB73468EDB403044 (mentor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE InfoEsner (id INT AUTO_INCREMENT NOT NULL, id_esner INT NOT NULL, cotisation DATE DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, UNIQUE INDEX UNIQ_4DCC66B8E43728BA (id_esner), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Member (id INT AUTO_INCREMENT NOT NULL, nationality_id INT NOT NULL, university_id INT NOT NULL, name VARCHAR(30) NOT NULL COLLATE utf8_unicode_ci, surname VARCHAR(30) NOT NULL COLLATE utf8_unicode_ci, email VARCHAR(50) NOT NULL COLLATE utf8_unicode_ci, sexe VARCHAR(5) DEFAULT NULL COLLATE utf8_unicode_ci, inscription DATE DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL COLLATE utf8_unicode_ci, study VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, birthday DATE DEFAULT NULL, facebook_id VARCHAR(255) DEFAULT NULL COLLATE utf8_unicode_ci, INDEX IDX_7748FF4E309D1878 (university_id), INDEX IDX_7748FF4E1C9DA55 (nationality_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Erasmus ADD CONSTRAINT FK_CB268DA356D34F95 FOREIGN KEY (id_member) REFERENCES Member (id)');
        $this->addSql('ALTER TABLE Esner ADD CONSTRAINT FK_CB73468E419C3385 FOREIGN KEY (pole_id) REFERENCES Pole (id)');
        $this->addSql('ALTER TABLE Esner ADD CONSTRAINT FK_CB73468E4B89032C FOREIGN KEY (post_id) REFERENCES Post (id)');
        $this->addSql('ALTER TABLE Esner ADD CONSTRAINT FK_CB73468E56D34F95 FOREIGN KEY (id_member) REFERENCES Member (id)');
        $this->addSql('ALTER TABLE Esner ADD CONSTRAINT FK_CB73468E97C22770 FOREIGN KEY (erasmusProgramme_id) REFERENCES Country (id)');
        $this->addSql('ALTER TABLE Esner ADD CONSTRAINT FK_CB73468EDB403044 FOREIGN KEY (mentor_id) REFERENCES Esner (id)');
        $this->addSql('ALTER TABLE InfoEsner ADD CONSTRAINT FK_4DCC66B8E43728BA FOREIGN KEY (id_esner) REFERENCES Esner (id)');
        $this->addSql('ALTER TABLE Member ADD CONSTRAINT FK_7748FF4E1C9DA55 FOREIGN KEY (nationality_id) REFERENCES Country (id)');
        $this->addSql('ALTER TABLE Member ADD CONSTRAINT FK_7748FF4E309D1878 FOREIGN KEY (university_id) REFERENCES University (id)');
        $this->addSql('ALTER TABLE ParticipateTrip DROP FOREIGN KEY FK_E3253ECD8D93D649');
        $this->addSql('DROP INDEX IDX_E3253ECD8D93D649 ON ParticipateTrip');
        $this->addSql('ALTER TABLE ParticipateTrip CHANGE user member INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ParticipateTrip ADD CONSTRAINT FK_E3253ECD70E4FA78 FOREIGN KEY (member) REFERENCES Trip (id)');
        $this->addSql('CREATE INDEX IDX_E3253ECD70E4FA78 ON ParticipateTrip (member)');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977419C3385');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA179774B89032C');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA1797797C22770');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977DB403044');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA17977309D1878');
        $this->addSql('ALTER TABLE User DROP FOREIGN KEY FK_2DA179771C9DA55');
        $this->addSql('DROP INDEX IDX_2DA17977419C3385 ON User');
        $this->addSql('DROP INDEX IDX_2DA179774B89032C ON User');
        $this->addSql('DROP INDEX IDX_2DA1797797C22770 ON User');
        $this->addSql('DROP INDEX IDX_2DA17977DB403044 ON User');
        $this->addSql('DROP INDEX IDX_2DA17977309D1878 ON User');
        $this->addSql('DROP INDEX IDX_2DA179771C9DA55 ON User');
        $this->addSql('ALTER TABLE User DROP pole_id, DROP post_id, DROP mentor_id, DROP university_id, DROP nationality_id, DROP address, DROP city, DROP zipcode, DROP hascare, DROP active, DROP erasmus_year_start, DROP erasmus_year_end, DROP esncard, DROP arrivalDate, DROP leavingDate, DROP esner, DROP inscription, DROP study, DROP facebook_id, DROP erasmusProgramme_id');
    }
}
