<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190510124108 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_E19D9AD27E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__service AS SELECT id, owner_id, name, address, replicas, service_id, file_base64, type FROM service');
        $this->addSql('DROP TABLE service');
        $this->addSql('CREATE TABLE service (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL COLLATE BINARY, address VARCHAR(255) NOT NULL COLLATE BINARY, replicas INTEGER NOT NULL, service_id VARCHAR(255) DEFAULT NULL COLLATE BINARY, file_base64 VARCHAR(255) NOT NULL COLLATE BINARY, type VARCHAR(255) NOT NULL COLLATE BINARY, port VARCHAR(255) NOT NULL, CONSTRAINT FK_E19D9AD27E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO service (id, owner_id, name, address, replicas, service_id, file_base64, type) SELECT id, owner_id, name, address, replicas, service_id, file_base64, type FROM __temp__service');
        $this->addSql('DROP TABLE __temp__service');
        $this->addSql('CREATE INDEX IDX_E19D9AD27E3C61F9 ON service (owner_id)');
        $this->addSql('DROP INDEX IDX_B9096CB1C2F67723');
        $this->addSql('DROP INDEX IDX_B9096CB1ED5CA9E6');
        $this->addSql('CREATE TEMPORARY TABLE __temp__service_dependency AS SELECT service_id, dependency_id FROM service_dependency');
        $this->addSql('DROP TABLE service_dependency');
        $this->addSql('CREATE TABLE service_dependency (service_id INTEGER NOT NULL, dependency_id INTEGER NOT NULL, PRIMARY KEY(service_id, dependency_id), CONSTRAINT FK_B9096CB1ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B9096CB1C2F67723 FOREIGN KEY (dependency_id) REFERENCES dependency (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO service_dependency (service_id, dependency_id) SELECT service_id, dependency_id FROM __temp__service_dependency');
        $this->addSql('DROP TABLE __temp__service_dependency');
        $this->addSql('CREATE INDEX IDX_B9096CB1C2F67723 ON service_dependency (dependency_id)');
        $this->addSql('CREATE INDEX IDX_B9096CB1ED5CA9E6 ON service_dependency (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX IDX_E19D9AD27E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__service AS SELECT id, owner_id, name, address, replicas, service_id, file_base64, type FROM service');
        $this->addSql('DROP TABLE service');
        $this->addSql('CREATE TABLE service (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, replicas INTEGER NOT NULL, service_id VARCHAR(255) DEFAULT NULL, file_base64 VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO service (id, owner_id, name, address, replicas, service_id, file_base64, type) SELECT id, owner_id, name, address, replicas, service_id, file_base64, type FROM __temp__service');
        $this->addSql('DROP TABLE __temp__service');
        $this->addSql('CREATE INDEX IDX_E19D9AD27E3C61F9 ON service (owner_id)');
        $this->addSql('DROP INDEX IDX_B9096CB1ED5CA9E6');
        $this->addSql('DROP INDEX IDX_B9096CB1C2F67723');
        $this->addSql('CREATE TEMPORARY TABLE __temp__service_dependency AS SELECT service_id, dependency_id FROM service_dependency');
        $this->addSql('DROP TABLE service_dependency');
        $this->addSql('CREATE TABLE service_dependency (service_id INTEGER NOT NULL, dependency_id INTEGER NOT NULL, PRIMARY KEY(service_id, dependency_id))');
        $this->addSql('INSERT INTO service_dependency (service_id, dependency_id) SELECT service_id, dependency_id FROM __temp__service_dependency');
        $this->addSql('DROP TABLE __temp__service_dependency');
        $this->addSql('CREATE INDEX IDX_B9096CB1ED5CA9E6 ON service_dependency (service_id)');
        $this->addSql('CREATE INDEX IDX_B9096CB1C2F67723 ON service_dependency (dependency_id)');
    }
}
