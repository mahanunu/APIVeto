<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320143433 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE consult (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, assistant_id INT NOT NULL, veterinary_id INT NOT NULL, creation_date DATETIME NOT NULL, consult_date DATE NOT NULL, reason VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_4D02C9E28E962C16 (animal_id), INDEX IDX_4D02C9E2E05387EF (assistant_id), INDEX IDX_4D02C9E2D954EB99 (veterinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consult_treatment (consult_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_9517E6B73811CC98 (consult_id), INDEX IDX_9517E6B7471C0366 (treatment_id), PRIMARY KEY(consult_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE consult ADD CONSTRAINT FK_4D02C9E28E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE consult ADD CONSTRAINT FK_4D02C9E2E05387EF FOREIGN KEY (assistant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consult ADD CONSTRAINT FK_4D02C9E2D954EB99 FOREIGN KEY (veterinary_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consult_treatment ADD CONSTRAINT FK_9517E6B73811CC98 FOREIGN KEY (consult_id) REFERENCES consult (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consult_treatment ADD CONSTRAINT FK_9517E6B7471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consult DROP FOREIGN KEY FK_4D02C9E28E962C16');
        $this->addSql('ALTER TABLE consult DROP FOREIGN KEY FK_4D02C9E2E05387EF');
        $this->addSql('ALTER TABLE consult DROP FOREIGN KEY FK_4D02C9E2D954EB99');
        $this->addSql('ALTER TABLE consult_treatment DROP FOREIGN KEY FK_9517E6B73811CC98');
        $this->addSql('ALTER TABLE consult_treatment DROP FOREIGN KEY FK_9517E6B7471C0366');
        $this->addSql('DROP TABLE consult');
        $this->addSql('DROP TABLE consult_treatment');
        $this->addSql('DROP TABLE treatment');
    }
}
