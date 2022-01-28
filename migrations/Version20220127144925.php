<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220127144925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE ingredient_type ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE potion ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE potion_type ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE recipe ADD status VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE tool ADD status VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ingredient DROP status');
        $this->addSql('ALTER TABLE ingredient_type DROP status');
        $this->addSql('ALTER TABLE potion DROP status');
        $this->addSql('ALTER TABLE potion_type DROP status');
        $this->addSql('ALTER TABLE recipe DROP status');
        $this->addSql('ALTER TABLE tool DROP status');
    }
}
