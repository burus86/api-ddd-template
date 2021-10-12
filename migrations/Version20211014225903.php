<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211014225903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table user';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE IF NOT EXISTS user (
                id INT AUTO_INCREMENT NOT NULL,
                fullname VARCHAR(100) NOT NULL,
                api_token VARCHAR(255) DEFAULT NULL,
                username VARCHAR(180) NOT NULL,
                password VARCHAR(255) NOT NULL,
                roles JSON NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
                PRIMARY KEY(id),
                UNIQUE INDEX UNIQ_8D93D6497BA2F5EB (api_token),
                UNIQUE INDEX UNIQ_8D93D649F85E0677 (username)
            )
            DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE IF EXISTS user');
    }
}
