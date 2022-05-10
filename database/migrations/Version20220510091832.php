<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220510091832 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE format  format VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE package_procedures ADD CONSTRAINT FK_9A860BB71624BCD2 FOREIGN KEY (procedure_id) REFERENCES procedures (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9A860BB71624BCD2 ON package_procedures (procedure_id)');
        $this->addSql('ALTER TABLE patient_visits CHANGE patient_bp patient_bp VARCHAR(255) DEFAULT NULL, CHANGE patient_height patient_height VARCHAR(255) DEFAULT NULL, CHANGE patient_weight patient_weight VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE procedures DROP FOREIGN KEY FK_969AFE421624BCD2');
        $this->addSql('DROP INDEX UNIQ_969AFE421624BCD2 ON procedures');
        $this->addSql('ALTER TABLE procedures DROP procedure_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE  format format VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE package_procedures DROP FOREIGN KEY FK_9A860BB71624BCD2');
        $this->addSql('DROP INDEX UNIQ_9A860BB71624BCD2 ON package_procedures');
        $this->addSql('ALTER TABLE patient_visits CHANGE patient_bp patient_bp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE patient_height patient_height VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE patient_weight patient_weight VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE procedures ADD procedure_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE procedures ADD CONSTRAINT FK_969AFE421624BCD2 FOREIGN KEY (procedure_id) REFERENCES package_procedures (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_969AFE421624BCD2 ON procedures (procedure_id)');
    }
}
