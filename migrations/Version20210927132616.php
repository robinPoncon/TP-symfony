<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210927132616 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE beer_category');
        $this->addSql('ALTER TABLE beer DROP FOREIGN KEY FK_58F666ADF92F3E70');
        $this->addSql('DROP INDEX IDX_58F666ADF92F3E70 ON beer');
        $this->addSql('ALTER TABLE beer DROP country_id, DROP price');
        $this->addSql('ALTER TABLE country ADD beers_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C96615C325FB FOREIGN KEY (beers_id) REFERENCES beer (id)');
        $this->addSql('CREATE INDEX IDX_5373C96615C325FB ON country (beers_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE beer_category (beer_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_CC90155FD0989053 (beer_id), INDEX IDX_CC90155F12469DE2 (category_id), PRIMARY KEY(beer_id, category_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE beer_category ADD CONSTRAINT FK_CC90155F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE beer_category ADD CONSTRAINT FK_CC90155FD0989053 FOREIGN KEY (beer_id) REFERENCES beer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE beer ADD country_id INT DEFAULT NULL, ADD price NUMERIC(5, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE beer ADD CONSTRAINT FK_58F666ADF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('CREATE INDEX IDX_58F666ADF92F3E70 ON beer (country_id)');
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C96615C325FB');
        $this->addSql('DROP INDEX IDX_5373C96615C325FB ON country');
        $this->addSql('ALTER TABLE country DROP beers_id');
    }
}
