<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305150000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE scheduled_maintenance_job_car DROP FOREIGN KEY FK_F29C6E067B812402');
        $this->addSql('ALTER TABLE scheduled_maintenance_job_car DROP FOREIGN KEY FK_F29C6E06C3C6F69F');
        $this->addSql('DROP TABLE scheduled_maintenance_job_car');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE scheduled_maintenance_job_car (scheduled_maintenance_job_id INT NOT NULL, car_id INT NOT NULL, INDEX IDX_F29C6E06C3C6F69F (car_id), INDEX IDX_F29C6E067B812402 (scheduled_maintenance_job_id), PRIMARY KEY(scheduled_maintenance_job_id, car_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE scheduled_maintenance_job_car ADD CONSTRAINT FK_F29C6E067B812402 FOREIGN KEY (scheduled_maintenance_job_id) REFERENCES scheduled_maintenance_job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE scheduled_maintenance_job_car ADD CONSTRAINT FK_F29C6E06C3C6F69F FOREIGN KEY (car_id) REFERENCES car (id) ON DELETE CASCADE');
    }
}
