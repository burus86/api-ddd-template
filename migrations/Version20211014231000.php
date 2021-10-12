<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211014231000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add user records';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("
            INSERT INTO `user` (`id`, `fullname`, `api_token`, `username`, `password`, `roles`, `created_at`) VALUES
                (1, 'Juan Jesús Gómez Noya', 'cU70Sbr0qKrUQHE0tw60XQVMwBP8hJrdRMY61xhX', 'juanjesus.gomeznoya', 'root.2021', '[\"ROLE_SUPER_ADMIN\"]', '2021-06-13 21:12:44'),
                (2, 'Administrator', 'WZzRhP2UdIeEDZCAtO2V4uFtRzFrKx3MMfq5iEsX', 'admin', 'admin.2021', '[\"ROLE_ADMIN\"]', '2021-06-13 21:12:44')
        ");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql("DELETE FROM `user` WHERE 1 = 1");
    }
}
