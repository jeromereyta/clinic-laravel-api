<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

final class Version20211121082235 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE file_types (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE file_uploads (id INT AUTO_INCREMENT NOT NULL, file_type_id INT NOT NULL, patient_visit_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, deleted_at DATETIME NOT NULL, description LONGTEXT NOT NULL,  format VARCHAR(255) NOT NULL, name LONGTEXT NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_CD77C6239E2A35A8 (file_type_id), INDEX IDX_CD77C623427F5757 (patient_visit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE file_uploads ADD CONSTRAINT FK_CD77C6239E2A35A8 FOREIGN KEY (file_type_id) REFERENCES file_types (id)');
        $this->addSql('ALTER TABLE file_uploads ADD CONSTRAINT FK_CD77C623427F5757 FOREIGN KEY (patient_visit_id) REFERENCES patient_visits (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads DROP FOREIGN KEY FK_CD77C6239E2A35A8');
        $this->addSql('DROP TABLE file_types');
        $this->addSql('DROP TABLE file_uploads');
    }
}
