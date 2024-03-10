<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230428140844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand DROP title, DROP description, DROP keywords, DROP g_rate, DROP g_feeds, DROP old_id, CHANGE text seo_text LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE brand ADD title VARCHAR(255) NOT NULL, ADD description VARCHAR(400) NOT NULL, ADD keywords VARCHAR(255) NOT NULL, ADD g_rate DOUBLE PRECISION NOT NULL, ADD g_feeds INT NOT NULL, ADD old_id INT NOT NULL, CHANGE seo_text text LONGTEXT NOT NULL');
    }
}
