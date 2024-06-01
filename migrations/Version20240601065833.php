<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240601065833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE portfolio_heat_metrics_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE portfolio_heat_metrics (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, combined_risk DOUBLE PRECISION NOT NULL, combined_risk_percent DOUBLE PRECISION NOT NULL, total_open_positions DOUBLE PRECISION NOT NULL, new_trades INT NOT NULL, closed_positions DOUBLE PRECISION NOT NULL, closed_pn_l DOUBLE PRECISION NOT NULL, open_pn_l DOUBLE PRECISION DEFAULT NULL, account DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN portfolio_heat_metrics.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE position ALTER entry_time TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE position ALTER exit_time TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN position.entry_time IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN position.exit_time IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE portfolio_heat_metrics_id_seq CASCADE');
        $this->addSql('DROP TABLE portfolio_heat_metrics');
        $this->addSql('ALTER TABLE position ALTER entry_time TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE position ALTER exit_time TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN position.entry_time IS NULL');
        $this->addSql('COMMENT ON COLUMN position.exit_time IS NULL');
    }
}
