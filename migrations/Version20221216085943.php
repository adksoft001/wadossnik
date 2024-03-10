<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221216085943 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE rus_name rus_name VARCHAR(255) NOT NULL, CHANGE url url VARCHAR(255) NOT NULL, CHANGE header header VARCHAR(255) NOT NULL, CHANGE title title VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(400) NOT NULL, CHANGE keywords keywords VARCHAR(255) NOT NULL, CHANGE text text LONGTEXT NOT NULL, CHANGE `order` `order` INT NOT NULL, CHANGE status status INT NOT NULL, CHANGE g_rate g_rate DOUBLE PRECISION NOT NULL, CHANGE g_feeds g_feeds INT NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE old_id old_id INT NOT NULL, ADD PRIMARY KEY (id)');
        $this->addSql('CREATE INDEX idx_brands_url ON brand (url)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON brand');
        $this->addSql('DROP INDEX idx_brands_url ON brand');
        $this->addSql('ALTER TABLE brand CHANGE id id INT DEFAULT NULL, CHANGE name name VARCHAR(100) DEFAULT NULL, CHANGE rus_name rus_name VARCHAR(100) DEFAULT NULL, CHANGE url url VARCHAR(100) DEFAULT NULL, CHANGE header header VARCHAR(180) DEFAULT NULL, CHANGE title title VARCHAR(180) DEFAULT NULL, CHANGE description description VARCHAR(400) DEFAULT NULL, CHANGE keywords keywords VARCHAR(255) DEFAULT NULL, CHANGE text text TEXT DEFAULT NULL, CHANGE status status INT DEFAULT NULL, CHANGE `order` `order` INT DEFAULT NULL, CHANGE g_rate g_rate DOUBLE PRECISION DEFAULT NULL, CHANGE g_feeds g_feeds INT DEFAULT NULL, CHANGE old_id old_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
