<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230613085153 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presencia ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE presencia ADD CONSTRAINT FK_E2D7D1EFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E2D7D1EFA76ED395 ON presencia (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE presencia DROP FOREIGN KEY FK_E2D7D1EFA76ED395');
        $this->addSql('DROP INDEX IDX_E2D7D1EFA76ED395 ON presencia');
        $this->addSql('ALTER TABLE presencia DROP user_id');
    }
}
