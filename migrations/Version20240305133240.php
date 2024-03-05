<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305133240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE maintenance_job (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_job_spare_part (maintenance_job_id INT NOT NULL, spare_part_id INT NOT NULL, INDEX IDX_7F26BB0A211D78A0 (maintenance_job_id), INDEX IDX_7F26BB0A49B7A72 (spare_part_id), PRIMARY KEY(maintenance_job_id, spare_part_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE maintenance_job_spare_part ADD CONSTRAINT FK_7F26BB0A211D78A0 FOREIGN KEY (maintenance_job_id) REFERENCES maintenance_job (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenance_job_spare_part ADD CONSTRAINT FK_7F26BB0A49B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenance_job_spare_part DROP FOREIGN KEY FK_7F26BB0A211D78A0');
        $this->addSql('ALTER TABLE maintenance_job_spare_part DROP FOREIGN KEY FK_7F26BB0A49B7A72');
        $this->addSql('DROP TABLE maintenance_job');
        $this->addSql('DROP TABLE maintenance_job_spare_part');
    }
}
