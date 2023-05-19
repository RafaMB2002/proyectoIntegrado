<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230519091811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comanda ADD mesa_id INT DEFAULT NULL, ADD trabajador_id INT DEFAULT NULL, ADD precio_total DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE comanda ADD CONSTRAINT FK_45C50E548BDC7AE9 FOREIGN KEY (mesa_id) REFERENCES mesa (id)');
        $this->addSql('ALTER TABLE comanda ADD CONSTRAINT FK_45C50E54EC3656E FOREIGN KEY (trabajador_id) REFERENCES trabajador (id)');
        $this->addSql('CREATE INDEX IDX_45C50E548BDC7AE9 ON comanda (mesa_id)');
        $this->addSql('CREATE INDEX IDX_45C50E54EC3656E ON comanda (trabajador_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comanda DROP FOREIGN KEY FK_45C50E548BDC7AE9');
        $this->addSql('ALTER TABLE comanda DROP FOREIGN KEY FK_45C50E54EC3656E');
        $this->addSql('DROP INDEX IDX_45C50E548BDC7AE9 ON comanda');
        $this->addSql('DROP INDEX IDX_45C50E54EC3656E ON comanda');
        $this->addSql('ALTER TABLE comanda DROP mesa_id, DROP trabajador_id, DROP precio_total');
    }
}
