<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20211117102421 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE patient_procedures DROP FOREIGN KEY FK_205A58ADF077E3EC');
        $this->addSql('DROP INDEX UNIQ_205A58ADF077E3EC ON patient_procedures');
        $this->addSql('ALTER TABLE patient_procedures DROP patient_procedure_id');
        $this->addSql('ALTER TABLE patients ADD `mobile_number` VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE procedure_queues ADD CONSTRAINT FK_5920D1A7F077E3EC FOREIGN KEY (patient_procedure_id) REFERENCES patient_procedures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5920D1A7F077E3EC ON procedure_queues (patient_procedure_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE patient_procedures ADD patient_procedure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient_procedures ADD CONSTRAINT FK_205A58ADF077E3EC FOREIGN KEY (patient_procedure_id) REFERENCES procedure_queues (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_205A58ADF077E3EC ON patient_procedures (patient_procedure_id)');
        $this->addSql('ALTER TABLE patients DROP `mobile_number`');
        $this->addSql('ALTER TABLE procedure_queues DROP FOREIGN KEY FK_5920D1A7F077E3EC');
        $this->addSql('DROP INDEX UNIQ_5920D1A7F077E3EC ON procedure_queues');
    }
}
