<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210605232657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE student (id INT NOT NULL, promo_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B723AF33D0C07AFF ON student (promo_id)');
        $this->addSql('CREATE TABLE teacher (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33BF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher ADD CONSTRAINT FK_B0F6A6D5BF396750 FOREIGN KEY (id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mark DROP CONSTRAINT FK_6674F271CB944F1A');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT FK_6674F271CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT FK_FBCE3E7A41807E1D');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT FK_FBCE3E7A41807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE teacher_promo DROP CONSTRAINT FK_E1EC26A641807E1D');
        $this->addSql('ALTER TABLE teacher_promo ADD CONSTRAINT FK_E1EC26A641807E1D FOREIGN KEY (teacher_id) REFERENCES teacher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649d0c07aff');
        $this->addSql('DROP INDEX idx_8d93d649d0c07aff');
        $this->addSql('ALTER TABLE "user" DROP promo_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE mark DROP CONSTRAINT FK_6674F271CB944F1A');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT FK_FBCE3E7A41807E1D');
        $this->addSql('ALTER TABLE teacher_promo DROP CONSTRAINT FK_E1EC26A641807E1D');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE teacher');
        $this->addSql('ALTER TABLE subject DROP CONSTRAINT fk_fbce3e7a41807e1d');
        $this->addSql('ALTER TABLE subject ADD CONSTRAINT fk_fbce3e7a41807e1d FOREIGN KEY (teacher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE mark DROP CONSTRAINT fk_6674f271cb944f1a');
        $this->addSql('ALTER TABLE mark ADD CONSTRAINT fk_6674f271cb944f1a FOREIGN KEY (student_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD promo_id INT NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT fk_8d93d649d0c07aff FOREIGN KEY (promo_id) REFERENCES promo (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_8d93d649d0c07aff ON "user" (promo_id)');
        $this->addSql('ALTER TABLE teacher_promo DROP CONSTRAINT fk_e1ec26a641807e1d');
        $this->addSql('ALTER TABLE teacher_promo ADD CONSTRAINT fk_e1ec26a641807e1d FOREIGN KEY (teacher_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
