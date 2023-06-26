<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623081916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question ADD tutorial_id INT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494E89366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494E89366B7B ON question (tutorial_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494E89366B7B');
        $this->addSql('DROP INDEX IDX_B6F7494E89366B7B ON question');
        $this->addSql('ALTER TABLE question DROP tutorial_id');
    }
}
