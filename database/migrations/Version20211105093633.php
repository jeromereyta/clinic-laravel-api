<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20211105093633 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE procedure_queues (id INT AUTO_INCREMENT NOT NULL, created_by_id INT NOT NULL, updated_by_id INT DEFAULT NULL, patient_procedure_id INT NOT NULL, status LONGTEXT NOT NULL, queue_number INT NOT NULL, INDEX IDX_5920D1A7B03A8386 (created_by_id), INDEX IDX_5920D1A7896DBBDE (updated_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE procedure_queues ADD CONSTRAINT FK_5920D1A7B03A8386 FOREIGN KEY (created_by_id) REFERENCES user_guests (user_guest_id)');
        $this->addSql('ALTER TABLE procedure_queues ADD CONSTRAINT FK_5920D1A7896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user_guests (user_guest_id)');
        $this->addSql('ALTER TABLE patient_procedures ADD patient_procedure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient_procedures ADD CONSTRAINT FK_205A58ADF077E3EC FOREIGN KEY (patient_procedure_id) REFERENCES procedure_queues (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_205A58ADF077E3EC ON patient_procedures (patient_procedure_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE patient_procedures DROP FOREIGN KEY FK_205A58ADF077E3EC');
        $this->addSql('DROP TABLE procedure_queues');
        $this->addSql('DROP INDEX UNIQ_205A58ADF077E3EC ON patient_procedures');
        $this->addSql('ALTER TABLE patient_procedures DROP patient_procedure_id');
    }
}
