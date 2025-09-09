<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250904100845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE dog (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, race VARCHAR(255) NOT NULL, INDEX IDX_812C397DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dog_reservation (dog_id INT NOT NULL, reservation_id INT NOT NULL, INDEX IDX_D1F8F97A634DFEB (dog_id), INDEX IDX_D1F8F97AB83297E7 (reservation_id), PRIMARY KEY(dog_id, reservation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dog ADD CONSTRAINT FK_812C397DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE dog_reservation ADD CONSTRAINT FK_D1F8F97A634DFEB FOREIGN KEY (dog_id) REFERENCES dog (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dog_reservation ADD CONSTRAINT FK_D1F8F97AB83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_service DROP FOREIGN KEY FK_B99084D8A76ED395');
        $this->addSql('ALTER TABLE user_service DROP FOREIGN KEY FK_B99084D8ED5CA9E6');
        $this->addSql('DROP TABLE user_service');
        $this->addSql('ALTER TABLE reservation ADD created_at DATETIME NOT NULL, ADD price INT NOT NULL, ADD reservation_date DATETIME NOT NULL, ADD status INT NOT NULL, ADD historical JSON NOT NULL, DROP race_dog, DROP name_of_dog');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_service (user_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_B99084D8A76ED395 (user_id), INDEX IDX_B99084D8ED5CA9E6 (service_id), PRIMARY KEY(user_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_service ADD CONSTRAINT FK_B99084D8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_service ADD CONSTRAINT FK_B99084D8ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dog DROP FOREIGN KEY FK_812C397DA76ED395');
        $this->addSql('ALTER TABLE dog_reservation DROP FOREIGN KEY FK_D1F8F97A634DFEB');
        $this->addSql('ALTER TABLE dog_reservation DROP FOREIGN KEY FK_D1F8F97AB83297E7');
        $this->addSql('DROP TABLE dog');
        $this->addSql('DROP TABLE dog_reservation');
        $this->addSql('ALTER TABLE reservation ADD race_dog VARCHAR(255) NOT NULL, ADD name_of_dog VARCHAR(255) NOT NULL, DROP created_at, DROP price, DROP reservation_date, DROP status, DROP historical');
    }
}
