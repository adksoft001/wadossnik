<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230420174749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE child_service (id INT AUTO_INCREMENT NOT NULL, sub_service_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, hours DOUBLE PRECISION NOT NULL, seo_text LONGTEXT NOT NULL, INDEX IDX_8329D2C9C1973A2B (sub_service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE child_service ADD CONSTRAINT FK_8329D2C9C1973A2B FOREIGN KEY (sub_service_id) REFERENCES sub_service (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE child_service DROP FOREIGN KEY FK_8329D2C9C1973A2B');
        $this->addSql('DROP TABLE child_service');
    }
}
