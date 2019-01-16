<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190113140009 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE server_keys ADD COLUMN valid BOOLEAN DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TEMPORARY TABLE __temp__server_keys AS SELECT id, server_id, hash, uploaded_at FROM server_keys');
        $this->addSql('DROP TABLE server_keys');
        $this->addSql('CREATE TABLE server_keys (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, server_id INTEGER NOT NULL, hash CLOB NOT NULL, uploaded_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO server_keys (id, server_id, hash, uploaded_at) SELECT id, server_id, hash, uploaded_at FROM __temp__server_keys');
        $this->addSql('DROP TABLE __temp__server_keys');
    }
}
