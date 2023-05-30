<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530102113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_comanda_plato ADD detalle_comanda_id INT DEFAULT NULL, ADD plato_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detalle_comanda_plato ADD CONSTRAINT FK_DE378FA9E847589 FOREIGN KEY (detalle_comanda_id) REFERENCES detalle_comanda (id)');
        $this->addSql('ALTER TABLE detalle_comanda_plato ADD CONSTRAINT FK_DE378FA9B0DB09EF FOREIGN KEY (plato_id) REFERENCES plato (id)');
        $this->addSql('CREATE INDEX IDX_DE378FA9E847589 ON detalle_comanda_plato (detalle_comanda_id)');
        $this->addSql('CREATE INDEX IDX_DE378FA9B0DB09EF ON detalle_comanda_plato (plato_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_comanda_plato DROP FOREIGN KEY FK_DE378FA9E847589');
        $this->addSql('ALTER TABLE detalle_comanda_plato DROP FOREIGN KEY FK_DE378FA9B0DB09EF');
        $this->addSql('DROP INDEX IDX_DE378FA9E847589 ON detalle_comanda_plato');
        $this->addSql('DROP INDEX IDX_DE378FA9B0DB09EF ON detalle_comanda_plato');
        $this->addSql('ALTER TABLE detalle_comanda_plato DROP detalle_comanda_id, DROP plato_id');
    }
}
