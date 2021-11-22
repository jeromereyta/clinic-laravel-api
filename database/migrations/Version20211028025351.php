<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

final class Version20211028025351 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE patient_procedures (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, patient_visit_id INT NOT NULL, updated_by_id INT DEFAULT NULL, procedure_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, procedureId INT NOT NULL, INDEX IDX_205A58AD1624BCD2 (procedure_id), INDEX IDX_205A58ADB03A8386 (created_by_id), INDEX IDX_205A58AD427F5757 (patient_visit_id), INDEX IDX_205A58AD896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE patient_procedures ADD CONSTRAINT FK_205A58AD1624BCD2 FOREIGN KEY (procedure_id) REFERENCES procedures (id)');
        $this->addSql('ALTER TABLE patient_procedures ADD CONSTRAINT FK_205A58ADB03A8386 FOREIGN KEY (created_by_id) REFERENCES user_guests (user_guest_id)');
        $this->addSql('ALTER TABLE patient_procedures ADD CONSTRAINT FK_205A58AD427F5757 FOREIGN KEY (patient_visit_id) REFERENCES patient_visits (id)');
        $this->addSql('ALTER TABLE patient_procedures ADD CONSTRAINT FK_205A58AD896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user_guests (user_guest_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE patient_procedures');
    }
}
