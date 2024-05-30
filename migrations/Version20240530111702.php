<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240530111702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE daily_metrics_id_seq CASCADE');
        $this->addSql('DROP TABLE daily_metrics');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE daily_metrics_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE daily_metrics (id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, combined_risk DOUBLE PRECISION NOT NULL, combined_risk_percent DOUBLE PRECISION NOT NULL, open_positions DOUBLE PRECISION NOT NULL, new_trades INT NOT NULL, closed_trades DOUBLE PRECISION NOT NULL, closed_pn_l DOUBLE PRECISION NOT NULL, open_pnl DOUBLE PRECISION NOT NULL, current_account_value DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
    }
}
