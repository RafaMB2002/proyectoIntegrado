<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515140617 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presencia ADD trabajador_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presencia ADD CONSTRAINT FK_E2D7D1EFEC3656E FOREIGN KEY (trabajador_id) REFERENCES trabajador (id)');
        $this->addSql('CREATE INDEX IDX_E2D7D1EFEC3656E ON presencia (trabajador_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presencia DROP FOREIGN KEY FK_E2D7D1EFEC3656E');
        $this->addSql('DROP INDEX IDX_E2D7D1EFEC3656E ON presencia');
        $this->addSql('ALTER TABLE presencia DROP trabajador_id');
    }
}
