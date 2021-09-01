<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210901185347 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add relation between message and room';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages ADD room_id INT NOT NULL');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E9654177093 FOREIGN KEY (room_id) REFERENCES rooms (id)');
        $this->addSql('CREATE INDEX IDX_DB021E9654177093 ON messages (room_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E9654177093');
        $this->addSql('DROP INDEX IDX_DB021E9654177093 ON messages');
        $this->addSql('ALTER TABLE messages DROP room_id');
    }
}
