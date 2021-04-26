<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422084718 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spend ADD supplier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE spend ADD CONSTRAINT FK_ECD2273D2ADD6D8C FOREIGN KEY (supplier_id) REFERENCES supplier (id)');
        $this->addSql('CREATE INDEX IDX_ECD2273D2ADD6D8C ON spend (supplier_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spend DROP FOREIGN KEY FK_ECD2273D2ADD6D8C');
        $this->addSql('DROP INDEX IDX_ECD2273D2ADD6D8C ON spend');
        $this->addSql('ALTER TABLE spend DROP supplier_id');
    }
}
