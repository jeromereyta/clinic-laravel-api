<?php

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

class Version20220115054717 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE format  format VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE package_procedures ADD CONSTRAINT FK_9A860BB7F44CABFF FOREIGN KEY (package_id) REFERENCES packages (id)');
        $this->addSql('CREATE INDEX IDX_9A860BB7F44CABFF ON package_procedures (package_id)');
        $this->addSql('ALTER TABLE packages DROP FOREIGN KEY FK_9BB5C0A7F44CABFF');
        $this->addSql('DROP INDEX UNIQ_9BB5C0A7F44CABFF ON packages');
        $this->addSql('ALTER TABLE packages DROP package_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE file_uploads CHANGE  format format VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE package_procedures DROP FOREIGN KEY FK_9A860BB7F44CABFF');
        $this->addSql('DROP INDEX IDX_9A860BB7F44CABFF ON package_procedures');
        $this->addSql('ALTER TABLE packages ADD package_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE packages ADD CONSTRAINT FK_9BB5C0A7F44CABFF FOREIGN KEY (package_id) REFERENCES package_procedures (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9BB5C0A7F44CABFF ON packages (package_id)');
    }
}
