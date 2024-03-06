<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240305205023 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenance_job ADD brand_id INT DEFAULT NULL, ADD model_id INT DEFAULT NULL, ADD generic TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE maintenance_job ADD CONSTRAINT FK_522DB5CE44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE maintenance_job ADD CONSTRAINT FK_522DB5CE7975B7E7 FOREIGN KEY (model_id) REFERENCES model (id)');
        $this->addSql('CREATE INDEX IDX_522DB5CE44F5D008 ON maintenance_job (brand_id)');
        $this->addSql('CREATE INDEX IDX_522DB5CE7975B7E7 ON maintenance_job (model_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE maintenance_job DROP FOREIGN KEY FK_522DB5CE44F5D008');
        $this->addSql('ALTER TABLE maintenance_job DROP FOREIGN KEY FK_522DB5CE7975B7E7');
        $this->addSql('DROP INDEX IDX_522DB5CE44F5D008 ON maintenance_job');
        $this->addSql('DROP INDEX IDX_522DB5CE7975B7E7 ON maintenance_job');
        $this->addSql('ALTER TABLE maintenance_job DROP brand_id, DROP model_id, DROP generic');
    }
}
