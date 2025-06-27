<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250626205123 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE poll_answer (id INT AUTO_INCREMENT NOT NULL, poll_id INT NOT NULL, option_id INT NOT NULL, user_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', INDEX IDX_36D8097E3C947C0F (poll_id), INDEX IDX_36D8097EA7C41D6F (option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE poll_answer ADD CONSTRAINT FK_36D8097E3C947C0F FOREIGN KEY (poll_id) REFERENCES poll (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE poll_answer ADD CONSTRAINT FK_36D8097EA7C41D6F FOREIGN KEY (option_id) REFERENCES poll_option (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE poll_answer DROP FOREIGN KEY FK_36D8097E3C947C0F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE poll_answer DROP FOREIGN KEY FK_36D8097EA7C41D6F
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE poll_answer
        SQL);
    }
}
