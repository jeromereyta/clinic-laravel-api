<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220107130127 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE package_procedures (id INT AUTO_INCREMENT NOT NULL, deleted_at DATE NOT NULL, description LONGTEXT NOT NULL, name LONGTEXT NOT NULL, package_id INT NOT NULL, price VARCHAR(255) NOT NULL, procedure_id INT NOT NULL, updated_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_uploads CHANGE format  format VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE packages ADD package_id INT DEFAULT NULL, DROP created_at');
        $this->addSql('ALTER TABLE packages ADD CONSTRAINT FK_9BB5C0A7F44CABFF FOREIGN KEY (package_id) REFERENCES package_procedures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BB5C0A7F44CABFF ON packages (package_id)');
        $this->addSql('ALTER TABLE procedures ADD procedure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE procedures ADD CONSTRAINT FK_969AFE421624BCD2 FOREIGN KEY (procedure_id) REFERENCES package_procedures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_969AFE421624BCD2 ON procedures (procedure_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE packages DROP FOREIGN KEY FK_9BB5C0A7F44CABFF');
        $this->addSql('ALTER TABLE procedures DROP FOREIGN KEY FK_969AFE421624BCD2');
        $this->addSql('DROP TABLE package_procedures');
        $this->addSql('ALTER TABLE file_uploads CHANGE  format format VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP INDEX UNIQ_9BB5C0A7F44CABFF ON packages');
        $this->addSql('ALTER TABLE packages ADD created_at DATE NOT NULL, DROP package_id');
        $this->addSql('DROP INDEX UNIQ_969AFE421624BCD2 ON procedures');
        $this->addSql('ALTER TABLE procedures DROP procedure_id');
    }
}
