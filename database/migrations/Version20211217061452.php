<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20211217061452 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE format  format VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE procedure_queues ADD date VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE transaction_summary ADD CONSTRAINT FK_B8825A81427F5757 FOREIGN KEY (patient_visit_id) REFERENCES patient_visits (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B8825A81427F5757 ON transaction_summary (patient_visit_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE  format format VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE procedure_queues DROP date');
        $this->addSql('ALTER TABLE transaction_summary DROP FOREIGN KEY FK_B8825A81427F5757');
        $this->addSql('DROP INDEX UNIQ_B8825A81427F5757 ON transaction_summary');
    }
}
