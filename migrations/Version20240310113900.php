<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240310113900 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP order_by_remont_forsunki, DROP is_domain, DROP order_by_remont_dizelnogo_dvigatelya, DROP order_by_wadossnk, DROP order_by_remont_tnvd, DROP order_by_remont_turbiny, DROP order_by_remont_rulevyh_reek, DROP order_by_remont_avtokondicionerov, DROP order_by_tehnicheskoe_obsluzhivanie, DROP order_by_remont_akpp_moskva');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service ADD order_by_remont_forsunki INT NOT NULL, ADD is_domain TINYINT(1) NOT NULL, ADD order_by_remont_dizelnogo_dvigatelya INT NOT NULL, ADD order_by_wadossnk INT NOT NULL, ADD order_by_remont_tnvd INT NOT NULL, ADD order_by_remont_turbiny INT NOT NULL, ADD order_by_remont_rulevyh_reek INT NOT NULL, ADD order_by_remont_avtokondicionerov INT NOT NULL, ADD order_by_tehnicheskoe_obsluzhivanie INT NOT NULL, ADD order_by_remont_akpp_moskva INT NOT NULL');
    }
}
