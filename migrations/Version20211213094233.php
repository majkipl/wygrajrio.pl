<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211213094233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application ADD shop_id INT NOT NULL, ADD category_id INT NOT NULL, ADD firstname VARCHAR(128) NOT NULL, ADD lastname VARCHAR(128) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD paragon VARCHAR(255) NOT NULL, ADD birth DATE NOT NULL, ADD phone VARCHAR(9) NOT NULL, ADD product VARCHAR(255) NOT NULL, ADD legal_a TINYINT(1) NOT NULL, ADD legal_b TINYINT(1) NOT NULL, ADD legal_c TINYINT(1) NOT NULL, ADD legal_d TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC14D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE application ADD CONSTRAINT FK_A45BDDC112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC14D16C4DD ON application (shop_id)');
        $this->addSql('CREATE INDEX IDX_A45BDDC112469DE2 ON application (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC14D16C4DD');
        $this->addSql('ALTER TABLE application DROP FOREIGN KEY FK_A45BDDC112469DE2');
        $this->addSql('DROP INDEX IDX_A45BDDC14D16C4DD ON application');
        $this->addSql('DROP INDEX IDX_A45BDDC112469DE2 ON application');
        $this->addSql('ALTER TABLE application DROP shop_id, DROP category_id, DROP firstname, DROP lastname, DROP email, DROP paragon, DROP birth, DROP phone, DROP product, DROP legal_a, DROP legal_b, DROP legal_c, DROP legal_d');
    }
}
