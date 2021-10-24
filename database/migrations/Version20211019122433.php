<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20211019122433 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE patients ADD `barangay` VARCHAR(255) NOT NULL, ADD `city` VARCHAR(255) NOT NULL, ADD `country` VARCHAR(255) NOT NULL, ADD `province` VARCHAR(255) NOT NULL, ADD `street_address` VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user_guests ADD CONSTRAINT FK_2843A78FA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2843A78FA76ED395 ON user_guests (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE patients DROP `barangay`, DROP `city`, DROP `country`, DROP `province`, DROP `street_address`');
        $this->addSql('ALTER TABLE user_guests DROP FOREIGN KEY FK_2843A78FA76ED395');
        $this->addSql('DROP INDEX UNIQ_2843A78FA76ED395 ON user_guests');
    }
}
