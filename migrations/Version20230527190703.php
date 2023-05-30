<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230527190703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plato DROP FOREIGN KEY FK_914B3E45E847589');
        $this->addSql('DROP INDEX IDX_914B3E45E847589 ON plato');
        $this->addSql('ALTER TABLE plato DROP detalle_comanda_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plato ADD detalle_comanda_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plato ADD CONSTRAINT FK_914B3E45E847589 FOREIGN KEY (detalle_comanda_id) REFERENCES detalle_comanda (id)');
        $this->addSql('CREATE INDEX IDX_914B3E45E847589 ON plato (detalle_comanda_id)');
    }
}
