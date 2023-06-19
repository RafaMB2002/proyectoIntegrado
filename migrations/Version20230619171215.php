<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230619171215 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bebida CHANGE stock stock INT DEFAULT NULL, CHANGE stock_min stock_min INT DEFAULT NULL, CHANGE stock_max stock_max INT DEFAULT NULL, CHANGE foto foto LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bebida CHANGE stock stock INT NOT NULL, CHANGE stock_min stock_min INT NOT NULL, CHANGE stock_max stock_max INT NOT NULL, CHANGE foto foto LONGTEXT NOT NULL');
    }
}
