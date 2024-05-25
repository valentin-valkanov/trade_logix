<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240525130044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE position_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE position (id INT NOT NULL, entry_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, position VARCHAR(255) NOT NULL, symbol VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, volume DOUBLE PRECISION NOT NULL, entry DOUBLE PRECISION NOT NULL, stop_loss DOUBLE PRECISION NOT NULL, take_profit DOUBLE PRECISION DEFAULT NULL, exit_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, exit DOUBLE PRECISION NOT NULL, commision DOUBLE PRECISION NOT NULL, swap DOUBLE PRECISION NOT NULL, profit DOUBLE PRECISION NOT NULL, system VARCHAR(255) NOT NULL, strategy VARCHAR(255) NOT NULL, asset_class VARCHAR(255) NOT NULL, grade VARCHAR(255) NOT NULL, week INT NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE position_id_seq CASCADE');
        $this->addSql('DROP TABLE position');
    }
}
