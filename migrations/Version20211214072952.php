<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211214072952 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_bar DROP FOREIGN KEY FK_B244F815780D7474');
        $this->addSql('DROP INDEX IDX_B244F815780D7474 ON search_bar');
        $this->addSql('ALTER TABLE search_bar DROP keyword, CHANGE countrysearch_id keyword_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE search_bar ADD CONSTRAINT FK_B244F815115D4552 FOREIGN KEY (keyword_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_B244F815115D4552 ON search_bar (keyword_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE search_bar DROP FOREIGN KEY FK_B244F815115D4552');
        $this->addSql('DROP INDEX IDX_B244F815115D4552 ON search_bar');
        $this->addSql('ALTER TABLE search_bar ADD keyword VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE keyword_id countrysearch_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE search_bar ADD CONSTRAINT FK_B244F815780D7474 FOREIGN KEY (countrysearch_id) REFERENCES country (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B244F815780D7474 ON search_bar (countrysearch_id)');
    }
}
