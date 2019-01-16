<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190114160253 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('ALTER TABLE server ADD COLUMN key_id INTEGER DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_5A6DD5F6A5E3B32D');
        $this->addSql('CREATE TEMPORARY TABLE __temp__server AS SELECT id, name, ip, created, description FROM server');
        $this->addSql('DROP TABLE server');
        $this->addSql('CREATE TABLE server (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, ip VARCHAR(255) NOT NULL, created DATETIME NOT NULL, description VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO server (id, name, ip, created, description) SELECT id, name, ip, created, description FROM __temp__server');
        $this->addSql('DROP TABLE __temp__server');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5A6DD5F6A5E3B32D ON server (ip)');
    }
}
