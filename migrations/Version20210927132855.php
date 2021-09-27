<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210927132855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beer ADD country_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_58F666ADF92F3E70 ON beer (country_id)');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C96615C325FB');
        $this->addSql('DROP INDEX IDX_5373C96615C325FB ON country');
        $this->addSql('ALTER TABLE country DROP beers_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADF92F3E70');
        $this->addSql('DROP INDEX IDX_58F666ADF92F3E70 ON beer');
        $this->addSql('ALTER TABLE beer DROP country_id');
        $this->addSql('ALTER TABLE country ADD beers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C96615C325FB FOREIGN KEY (beers_id) REFERENCES beer (id)');
        $this->addSql('CREATE INDEX IDX_5373C96615C325FB ON country (beers_id)');
    }
}
