<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527191046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bebida ADD detalle_comanda_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE bebida ADD CONSTRAINT FK_4821C785E847589 FOREIGN KEY (detalle_comanda_id) REFERENCES detalle_comanda (id)');
        $this->addSql('CREATE INDEX IDX_4821C785E847589 ON bebida (detalle_comanda_id)');
        $this->addSql('ALTER TABLE plato ADD detalle_comanda_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plato ADD CONSTRAINT FK_914B3E45E847589 FOREIGN KEY (detalle_comanda_id) REFERENCES detalle_comanda (id)');
        $this->addSql('CREATE INDEX IDX_914B3E45E847589 ON plato (detalle_comanda_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bebida DROP FOREIGN KEY FK_4821C785E847589');
        $this->addSql('DROP INDEX IDX_4821C785E847589 ON bebida');
        $this->addSql('ALTER TABLE bebida DROP detalle_comanda_id');
        $this->addSql('ALTER TABLE plato DROP FOREIGN KEY FK_914B3E45E847589');
        $this->addSql('DROP INDEX IDX_914B3E45E847589 ON plato');
        $this->addSql('ALTER TABLE plato DROP detalle_comanda_id');
    }
}
