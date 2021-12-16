<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213094723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application ADD from_where_id INT NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC173D293AD FOREIGN KEY (from_where_id) REFERENCES `where` (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC173D293AD ON application (from_where_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC173D293AD');
        $this->addSql('DROP INDEX IDX_A45BDDC173D293AD ON application');
        $this->addSql('ALTER TABLE application DROP from_where_id');
    }
}
