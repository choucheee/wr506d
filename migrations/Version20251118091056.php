<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migration pour créer les tables Movie et LogAction
 */
final class Version20251118091056 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Création des tables movie et log_action';
    }

    public function up(Schema $schema): void
    {
        // Création de la table movie
        $this->addSql('CREATE TABLE movie (
            id INT AUTO_INCREMENT NOT NULL,
            title VARCHAR(255) NOT NULL,
            director VARCHAR(255) DEFAULT NULL,
            year INT DEFAULT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Création de la table log_action
        $this->addSql('CREATE TABLE log_action (
            id INT AUTO_INCREMENT NOT NULL,
            action VARCHAR(255) NOT NULL,
            entity_type VARCHAR(255) NOT NULL,
            entity_id INT NOT NULL,
            details LONGTEXT DEFAULT NULL,
            created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
            PRIMARY KEY(id),
            INDEX idx_entity_type (entity_type),
            INDEX idx_entity_id (entity_id),
            INDEX idx_created_at (created_at)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // Suppression des tables
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE log_action');
    }
}

