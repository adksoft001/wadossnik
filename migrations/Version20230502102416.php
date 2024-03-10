<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230502102416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model ADD created_at DATETIME DEFAULT CURRENT_TIMESTAMP, ADD updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, DROP header, DROP title, DROP description, DROP keywords, DROP g_rate, DROP g_feeds, DROP update_at, DROP create_at, DROP old_id, DROP parent_old_id, DROP hide_url_price_list, CHANGE brand_id brand_id INT DEFAULT NULL, CHANGE name name VARCHAR(255) NOT NULL, CHANGE rus_name rus_name VARCHAR(255) NOT NULL, CHANGE url url VARCHAR(255) NOT NULL, CHANGE text text LONGTEXT NOT NULL, CHANGE `order` `order` INT NOT NULL, CHANGE status status INT NOT NULL');
        $this->addSql('ALTER TABLE model ADD CONSTRAINT FK_D79572D944F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('CREATE INDEX IDX_D79572D944F5D008 ON model (brand_id)');
        $this->addSql('CREATE INDEX idx_model_url ON model (url)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE model DROP FOREIGN KEY FK_D79572D944F5D008');
        $this->addSql('DROP INDEX IDX_D79572D944F5D008 ON model');
        $this->addSql('DROP INDEX idx_model_url ON model');
        $this->addSql('ALTER TABLE model ADD header VARCHAR(180) DEFAULT NULL, ADD title VARCHAR(180) DEFAULT NULL, ADD description VARCHAR(400) DEFAULT NULL, ADD keywords VARCHAR(255) DEFAULT NULL, ADD g_rate DOUBLE PRECISION DEFAULT NULL, ADD g_feeds INT DEFAULT 0, ADD update_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD create_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, ADD old_id INT DEFAULT NULL, ADD parent_old_id INT DEFAULT NULL, ADD hide_url_price_list INT DEFAULT 0 NOT NULL, DROP created_at, DROP updated_at, CHANGE brand_id brand_id INT NOT NULL, CHANGE name name VARCHAR(100) NOT NULL, CHANGE rus_name rus_name VARCHAR(100) NOT NULL, CHANGE url url VARCHAR(100) NOT NULL, CHANGE text text TEXT DEFAULT NULL, CHANGE status status INT DEFAULT 0, CHANGE `order` `order` INT DEFAULT 0');
    }
}
