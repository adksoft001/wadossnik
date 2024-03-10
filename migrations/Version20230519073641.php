<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519073641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD order_by_tehnicheskoe_obsluzhivanie INT NOT NULL, ADD order_by_remont_akpp_moskva INT NOT NULL');
        $this->addSql('INSERT INTO service (`name`, `slug`, `is_domain`, `seo_text`,
                     `order_by_remont_forsunki`, `order_by_remont_dizelnogo_dvigatelya`,`order_by_remont_dvigatelya`, `order_by_remont_tnvd`, 
                     `order_by_remont_turbiny`, `order_by_remont_rulevyh_reek`, `order_by_remont_avtokondicionerov`,`order_by_tehnicheskoe_obsluzhivanie`, `order_by_remont_akpp_moskva` )
        VALUES ("Техническое обслуживание авто", "tehnicheskoe-obsluzhivanie", 1, " ", 15, 15, 15, 15, 15, 0, 0, 0, 0)');
        $this->addSql('INSERT INTO service (`name`, `slug`, `is_domain`, `seo_text`,
                     `order_by_remont_forsunki`, `order_by_remont_dizelnogo_dvigatelya`,`order_by_remont_dvigatelya`, `order_by_remont_tnvd`, 
                     `order_by_remont_turbiny`, `order_by_remont_rulevyh_reek`, `order_by_remont_avtokondicionerov`,`order_by_tehnicheskoe_obsluzhivanie`, `order_by_remont_akpp_moskva`
                     ) VALUES ("Ремонт АКПП", "remont-akpp-moskva", 1, " ", 16, 16, 16, 16, 16, 0, 0, 0, 0)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP order_by_tehnicheskoe_obsluzhivanie, DROP order_by_remont_akpp_moskva');
    }
}
