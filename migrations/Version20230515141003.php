<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515141003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_comanda ADD comanda_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detalle_comanda ADD CONSTRAINT FK_D1BE0FC787958A8 FOREIGN KEY (comanda_id) REFERENCES comanda (id)');
        $this->addSql('CREATE INDEX IDX_D1BE0FC787958A8 ON detalle_comanda (comanda_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_comanda DROP FOREIGN KEY FK_D1BE0FC787958A8');
        $this->addSql('DROP INDEX IDX_D1BE0FC787958A8 ON detalle_comanda');
        $this->addSql('ALTER TABLE detalle_comanda DROP comanda_id');
    }
}
