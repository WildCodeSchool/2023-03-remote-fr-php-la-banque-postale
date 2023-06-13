<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230609074050 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tutorial ADD category_id INT NOT NULL');
        $this->addSql('ALTER TABLE tutorial ADD CONSTRAINT FK_C66BFFE912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_C66BFFE912469DE2 ON tutorial (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tutorial DROP FOREIGN KEY FK_C66BFFE912469DE2');
        $this->addSql('DROP INDEX IDX_C66BFFE912469DE2 ON tutorial');
        $this->addSql('ALTER TABLE tutorial DROP category_id');
    }
}
