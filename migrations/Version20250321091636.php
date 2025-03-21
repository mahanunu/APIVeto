<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321091636 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, media_id INT NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, birthday DATE DEFAULT NULL, UNIQUE INDEX UNIQ_6AAB231FEA9FDD75 (media_id), INDEX IDX_6AAB231F7E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consult (id INT AUTO_INCREMENT NOT NULL, animal_id INT NOT NULL, assistant_id INT NOT NULL, veterinary_id INT NOT NULL, creation_date DATETIME NOT NULL, consult_date DATE NOT NULL, reason VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_4D02C9E28E962C16 (animal_id), INDEX IDX_4D02C9E2E05387EF (assistant_id), INDEX IDX_4D02C9E2D954EB99 (veterinary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE consult_treatment (consult_id INT NOT NULL, treatment_id INT NOT NULL, INDEX IDX_9517E6B73811CC98 (consult_id), INDEX IDX_9517E6B7471C0366 (treatment_id), PRIMARY KEY(consult_id, treatment_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, duration INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consult ADD CONSTRAINT FK_4D02C9E28E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('ALTER TABLE consult ADD CONSTRAINT FK_4D02C9E2E05387EF FOREIGN KEY (assistant_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consult ADD CONSTRAINT FK_4D02C9E2D954EB99 FOREIGN KEY (veterinary_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE consult_treatment ADD CONSTRAINT FK_9517E6B73811CC98 FOREIGN KEY (consult_id) REFERENCES consult (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE consult_treatment ADD CONSTRAINT FK_9517E6B7471C0366 FOREIGN KEY (treatment_id) REFERENCES treatment (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FEA9FDD75');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F7E3C61F9');
        $this->addSql('ALTER TABLE consult DROP FOREIGN KEY FK_4D02C9E28E962C16');
        $this->addSql('ALTER TABLE consult DROP FOREIGN KEY FK_4D02C9E2E05387EF');
        $this->addSql('ALTER TABLE consult DROP FOREIGN KEY FK_4D02C9E2D954EB99');
        $this->addSql('ALTER TABLE consult_treatment DROP FOREIGN KEY FK_9517E6B73811CC98');
        $this->addSql('ALTER TABLE consult_treatment DROP FOREIGN KEY FK_9517E6B7471C0366');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE consult');
        $this->addSql('DROP TABLE consult_treatment');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE treatment');
        $this->addSql('DROP TABLE user');
    }
}
