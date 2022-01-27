<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220126175556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_81398E0986CC499D ON customer (pseudo)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D28FE7BF5E237E06 ON ingredient_type (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8F7B17A25E237E06 ON potion_type (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_20F33ED15E237E06 ON tool (name)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_81398E0986CC499D ON customer');
        $this->addSql('DROP INDEX UNIQ_D28FE7BF5E237E06 ON ingredient_type');
        $this->addSql('DROP INDEX UNIQ_8F7B17A25E237E06 ON potion_type');
        $this->addSql('DROP INDEX UNIQ_20F33ED15E237E06 ON tool');
    }
}
