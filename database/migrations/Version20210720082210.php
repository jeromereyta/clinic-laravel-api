<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20210720082210 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE users (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, `active` TINYINT(1) NOT NULL, email VARCHAR(191) DEFAULT NULL, first_name VARCHAR(191) DEFAULT NULL, last_name VARCHAR(191) DEFAULT NULL, password VARCHAR(191) NOT NULL, type VARCHAR(191) NOT NULL, remember_token VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE users');
    }
}
