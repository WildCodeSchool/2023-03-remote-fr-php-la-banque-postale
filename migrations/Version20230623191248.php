<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623191248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tutorial_user (tutorial_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F255510489366B7B (tutorial_id), INDEX IDX_F2555104A76ED395 (user_id), PRIMARY KEY(tutorial_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tutorial_user ADD CONSTRAINT FK_F255510489366B7B FOREIGN KEY (tutorial_id) REFERENCES tutorial (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tutorial_user ADD CONSTRAINT FK_F2555104A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tutorial_user DROP FOREIGN KEY FK_F255510489366B7B');
        $this->addSql('ALTER TABLE tutorial_user DROP FOREIGN KEY FK_F2555104A76ED395');
        $this->addSql('DROP TABLE tutorial_user');
    }
}
