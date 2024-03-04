<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240304211134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE spare_part (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spare_part_model (spare_part_id INT NOT NULL, model_id INT NOT NULL, INDEX IDX_2BE84E3449B7A72 (spare_part_id), INDEX IDX_2BE84E347975B7E7 (model_id), PRIMARY KEY(spare_part_id, model_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE spare_part_brand (spare_part_id INT NOT NULL, brand_id INT NOT NULL, INDEX IDX_E02FC5B549B7A72 (spare_part_id), INDEX IDX_E02FC5B544F5D008 (brand_id), PRIMARY KEY(spare_part_id, brand_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE spare_part_model ADD CONSTRAINT FK_2BE84E3449B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spare_part_model ADD CONSTRAINT FK_2BE84E347975B7E7 FOREIGN KEY (model_id) REFERENCES model (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spare_part_brand ADD CONSTRAINT FK_E02FC5B549B7A72 FOREIGN KEY (spare_part_id) REFERENCES spare_part (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE spare_part_brand ADD CONSTRAINT FK_E02FC5B544F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE spare_part_model DROP FOREIGN KEY FK_2BE84E3449B7A72');
        $this->addSql('ALTER TABLE spare_part_model DROP FOREIGN KEY FK_2BE84E347975B7E7');
        $this->addSql('ALTER TABLE spare_part_brand DROP FOREIGN KEY FK_E02FC5B549B7A72');
        $this->addSql('ALTER TABLE spare_part_brand DROP FOREIGN KEY FK_E02FC5B544F5D008');
        $this->addSql('DROP TABLE spare_part');
        $this->addSql('DROP TABLE spare_part_model');
        $this->addSql('DROP TABLE spare_part_brand');
    }
}
