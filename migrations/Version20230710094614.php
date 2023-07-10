<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230710094614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE friend_list (id INT AUTO_INCREMENT NOT NULL, send_by_id INT DEFAULT NULL, send_to_id INT DEFAULT NULL, created DATETIME DEFAULT NULL, status VARCHAR(20) DEFAULT NULL, INDEX IDX_DEB224F8C3852542 (send_by_id), INDEX IDX_DEB224F859574F23 (send_to_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE friend_list ADD CONSTRAINT FK_DEB224F8C3852542 FOREIGN KEY (send_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE friend_list ADD CONSTRAINT FK_DEB224F859574F23 FOREIGN KEY (send_to_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE friend_list DROP FOREIGN KEY FK_DEB224F8C3852542');
        $this->addSql('ALTER TABLE friend_list DROP FOREIGN KEY FK_DEB224F859574F23');
        $this->addSql('DROP TABLE friend_list');
    }
}
