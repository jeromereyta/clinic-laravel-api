<?php

declare(strict_types=1);

namespace Database\Migrations;

use Doctrine\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema as Schema;

final class Version20211026100007 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE procedures (id INT AUTO_INCREMENT NOT NULL, category_procedure_id INT NOT NULL, active TINYINT(1) NOT NULL, description LONGTEXT NOT NULL, test LONGTEXT NOT NULL, price VARCHAR(255) NOT NULL, INDEX IDX_969AFE42CCF39F40 (category_procedure_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE procedures ADD CONSTRAINT FK_969AFE42CCF39F40 FOREIGN KEY (category_procedure_id) REFERENCES category_procedures (id)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE procedures');
    }
}
