<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305150132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD car_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE scheduled_maintenance_job ADD CONSTRAINT FK_DFA05AD5C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
        $this->addSql('CREATE INDEX IDX_DFA05AD5C3C6F69F ON scheduled_maintenance_job (car_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP FOREIGN KEY FK_DFA05AD5C3C6F69F');
        $this->addSql('DROP INDEX IDX_DFA05AD5C3C6F69F ON scheduled_maintenance_job');
        $this->addSql('ALTER TABLE scheduled_maintenance_job DROP car_id');
    }
}
