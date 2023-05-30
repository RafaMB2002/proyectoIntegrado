<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530101404 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_comanda_plato DROP FOREIGN KEY FK_DE378FA9E847589');
        $this->addSql('ALTER TABLE detalle_comanda_plato DROP FOREIGN KEY FK_DE378FA9B0DB09EF');
        $this->addSql('DROP TABLE detalle_comanda_plato');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE detalle_comanda_plato (detalle_comanda_id INT NOT NULL, plato_id INT NOT NULL, INDEX IDX_DE378FA9E847589 (detalle_comanda_id), INDEX IDX_DE378FA9B0DB09EF (plato_id), PRIMARY KEY(detalle_comanda_id, plato_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE detalle_comanda_plato ADD CONSTRAINT FK_DE378FA9E847589 FOREIGN KEY (detalle_comanda_id) REFERENCES detalle_comanda (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE detalle_comanda_plato ADD CONSTRAINT FK_DE378FA9B0DB09EF FOREIGN KEY (plato_id) REFERENCES plato (id) ON DELETE CASCADE');
    }
}
