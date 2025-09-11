<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250910082146 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dog_reservation DROP FOREIGN KEY FK_D1F8F97A634DFEB');
        $this->addSql('ALTER TABLE dog_reservation DROP FOREIGN KEY FK_D1F8F97AB83297E7');
        $this->addSql('DROP TABLE dog_reservation');
        $this->addSql('ALTER TABLE reservation ADD dog_id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id)');
        $this->addSql('CREATE INDEX IDX_42C84955634DFEB ON reservation (dog_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dog_reservation (dog_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_D1F8F97A634DFEB (dog_id), INDEX IDX_D1F8F97AB83297E7 (reservation_id), PRIMARY KEY(dog_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE dog_reservation ADD CONSTRAINT FK_D1F8F97A634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dog_reservation ADD CONSTRAINT FK_D1F8F97AB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955634DFEB');
        $this->addSql('DROP INDEX IDX_42C84955634DFEB ON reservation');
        $this->addSql('ALTER TABLE reservation DROP dog_id');
    }
}
