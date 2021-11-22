<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

final class Version20211011092600 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE patient_visits (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, patient_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, attending_doctor VARCHAR(255) DEFAULT NULL, patient_bp VARCHAR(255) NOT NULL, patient_height VARCHAR(255) NOT NULL, patient_weight VARCHAR(255) NOT NULL, remarks VARCHAR(255) DEFAULT NULL, INDEX IDX_4F06D010B03A8386 (created_by_id), INDEX IDX_4F06D0106B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patients (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, `active` TINYINT(1) NOT NULL, `age` VARCHAR(255) NOT NULL, `birth_date` DATETIME NOT NULL, `civil_status` VARCHAR(255) NOT NULL, `email` VARCHAR(255) NOT NULL, `gender` VARCHAR(255) NOT NULL, `name` VARCHAR(255) NOT NULL, `patient_code` VARCHAR(255) NOT NULL, `phone_number` VARCHAR(255) NOT NULL, INDEX IDX_2CCC2E2CB03A8386 (created_by_id), INDEX IDX_2CCC2E2C896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_guests (user_guest_id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, `active` TINYINT(1) NOT NULL, `name` VARCHAR(255) NOT NULL, `type` VARCHAR(255) NOT NULL, PRIMARY KEY(user_guest_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, `active` TINYINT(1) NOT NULL, email VARCHAR(191) DEFAULT NULL, email_verified_at DATETIME DEFAULT NULL, first_name VARCHAR(191) DEFAULT NULL, last_name VARCHAR(191) DEFAULT NULL, password VARCHAR(191) NOT NULL, type VARCHAR(191) NOT NULL, remember_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_visits ADD CONSTRAINT FK_4F06D010B03A8386 FOREIGN KEY (created_by_id) REFERENCES user_guests (user_guest_id)');
        $this->addSql('ALTER TABLE patient_visits ADD CONSTRAINT FK_4F06D0106B899279 FOREIGN KEY (patient_id) REFERENCES patients (id)');
        $this->addSql('ALTER TABLE patients ADD CONSTRAINT FK_2CCC2E2CB03A8386 FOREIGN KEY (created_by_id) REFERENCES user_guests (user_guest_id)');
        $this->addSql('ALTER TABLE patients ADD CONSTRAINT FK_2CCC2E2C896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user_guests (user_guest_id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE patient_visits DROP FOREIGN KEY FK_4F06D0106B899279');
        $this->addSql('ALTER TABLE patient_visits DROP FOREIGN KEY FK_4F06D010B03A8386');
        $this->addSql('ALTER TABLE patients DROP FOREIGN KEY FK_2CCC2E2CB03A8386');
        $this->addSql('ALTER TABLE patients DROP FOREIGN KEY FK_2CCC2E2C896DBBDE');
        $this->addSql('DROP TABLE patient_visits');
        $this->addSql('DROP TABLE patients');
        $this->addSql('DROP TABLE user_guests');
        $this->addSql('DROP TABLE users');
    }
}
