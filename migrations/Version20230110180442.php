<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230110180442 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD order_by_remont_dizelnogo_dvigatelya INT NOT NULL, ADD order_by_remont_dvigatelya INT NOT NULL, ADD order_by_remont_tnvd INT NOT NULL, ADD order_by_remont_turbiny INT NOT NULL, CHANGE order_by order_by_remont_forsunki INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD order_by INT NOT NULL, DROP order_by_remont_forsunki, DROP order_by_remont_dizelnogo_dvigatelya, DROP order_by_remont_dvigatelya, DROP order_by_remont_tnvd, DROP order_by_remont_turbiny');
    }
}
