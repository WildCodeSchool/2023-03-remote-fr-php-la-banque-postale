<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230627203059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_tutorial (user_id INT NOT NULL, tutorial_id INT NOT NULL, INDEX IDX_26E61BE9A76ED395 (user_id), INDEX IDX_26E61BE989366B7B (tutorial_id), PRIMARY KEY(user_id, tutorial_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_tutorial ADD CONSTRAINT FK_26E61BE9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_tutorial ADD CONSTRAINT FK_26E61BE989366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_tutorial DROP FOREIGN KEY FK_26E61BE9A76ED395');
        $this->addSql('ALTER TABLE user_tutorial DROP FOREIGN KEY FK_26E61BE989366B7B');
        $this->addSql('DROP TABLE user_tutorial');
    }
}
