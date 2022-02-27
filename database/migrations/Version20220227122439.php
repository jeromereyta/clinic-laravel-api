<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220227122439 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE format  format VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE patient_procedures CHANGE description description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE patients ADD `first_name` VARCHAR(255) NOT NULL, ADD `middle_name` VARCHAR(255) DEFAULT NULL, ADD `last_name` VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users CHANGE updated_at updated_at DATETIME NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE  format format VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE patient_procedures CHANGE description description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE patients DROP `first_name`, DROP `middle_name`, DROP `last_name`');
        $this->addSql('ALTER TABLE users CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
