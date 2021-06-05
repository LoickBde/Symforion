<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210605163513 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE mark_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE promo_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subject_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE mark (id INT NOT NULL, subject_id INT NOT NULL, student_id INT NOT NULL, mark INT NOT NULL, coef INT NOT NULL, type VARCHAR(2) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6674F27123EDC87 ON mark (subject_id)');
        $this->addSql('CREATE INDEX IDX_6674F271CB944F1A ON mark (student_id)');
        $this->addSql('CREATE TABLE promo (id INT NOT NULL, name VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subject (id INT NOT NULL, teacher_id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FBCE3E7A41807E1D ON subject (teacher_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, promo_id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, lastname VARCHAR(50) NOT NULL, firstname VARCHAR(50) NOT NULL, resource_type VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
        $this->addSql('CREATE INDEX IDX_8D93D649D0C07AFF ON "user" (promo_id)');
        $this->addSql('CREATE TABLE teacher_promo (teacher_id INT NOT NULL, promo_id INT NOT NULL, PRIMARY KEY(teacher_id, promo_id))');
        $this->addSql('CREATE INDEX IDX_E1EC26A641807E1D ON teacher_promo (teacher_id)');
        $this->addSql('CREATE INDEX IDX_E1EC26A6D0C07AFF ON teacher_promo (promo_id)');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT FK_6674F27123EDC87 FOREIGN KEY (subject_id) REFERENCES subject (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT FK_6674F271CB944F1A FOREIGN KEY (student_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A41807E1D FOREIGN KEY (teacher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_promo ADD CONSTRAINT FK_E1EC26A641807E1D FOREIGN KEY (teacher_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_promo ADD CONSTRAINT FK_E1EC26A6D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649D0C07AFF');
        $this->addSql('ALTER TABLE teacher_promo DROP CONSTRAINT FK_E1EC26A6D0C07AFF');
        $this->addSql('ALTER TABLE mark DROP CONSTRAINT FK_6674F27123EDC87');
        $this->addSql('ALTER TABLE mark DROP CONSTRAINT FK_6674F271CB944F1A');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT FK_FBCE3E7A41807E1D');
        $this->addSql('ALTER TABLE teacher_promo DROP CONSTRAINT FK_E1EC26A641807E1D');
        $this->addSql('DROP SEQUENCE mark_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE promo_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subject_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP TABLE mark');
        $this->addSql('DROP TABLE promo');
        $this->addSql('DROP TABLE subject');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE teacher_promo');
    }
}
