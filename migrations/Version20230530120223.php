<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230530120223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_comanda_bebida ADD detalle_comanda_id INT DEFAULT NULL, ADD bebida_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE detalle_comanda_bebida ADD CONSTRAINT FK_E1D21567E847589 FOREIGN KEY (detalle_comanda_id) REFERENCES detalle_comanda (id)');
        $this->addSql('ALTER TABLE detalle_comanda_bebida ADD CONSTRAINT FK_E1D21567496D4DC4 FOREIGN KEY (bebida_id) REFERENCES bebida (id)');
        $this->addSql('CREATE INDEX IDX_E1D21567E847589 ON detalle_comanda_bebida (detalle_comanda_id)');
        $this->addSql('CREATE INDEX IDX_E1D21567496D4DC4 ON detalle_comanda_bebida (bebida_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detalle_comanda_bebida DROP FOREIGN KEY FK_E1D21567E847589');
        $this->addSql('ALTER TABLE detalle_comanda_bebida DROP FOREIGN KEY FK_E1D21567496D4DC4');
        $this->addSql('DROP INDEX IDX_E1D21567E847589 ON detalle_comanda_bebida');
        $this->addSql('DROP INDEX IDX_E1D21567496D4DC4 ON detalle_comanda_bebida');
        $this->addSql('ALTER TABLE detalle_comanda_bebida DROP detalle_comanda_id, DROP bebida_id');
    }
}
