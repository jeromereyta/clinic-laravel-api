<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220130095804 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE format  format VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE patient_procedures ADD package_procedure_id INT DEFAULT NULL, DROP procedureId, CHANGE procedure_id procedure_id INT NOT NULL');
        $this->addSql('ALTER TABLE patient_procedures ADD CONSTRAINT FK_205A58ADB238A3A5 FOREIGN KEY (package_procedure_id) REFERENCES package_procedures (id)');
        $this->addSql('CREATE INDEX IDX_205A58ADB238A3A5 ON patient_procedures (package_procedure_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE  format format VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE patient_procedures DROP FOREIGN KEY FK_205A58ADB238A3A5');
        $this->addSql('DROP INDEX IDX_205A58ADB238A3A5 ON patient_procedures');
        $this->addSql('ALTER TABLE patient_procedures ADD procedureId INT NOT NULL, DROP package_procedure_id, CHANGE procedure_id procedure_id INT DEFAULT NULL');
    }
}
