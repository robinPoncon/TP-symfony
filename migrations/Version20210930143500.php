<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210930143500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE statistic_beer');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045553B6268F');
        $this->addSql('DROP INDEX IDX_C744045553B6268F ON client');
        $this->addSql('ALTER TABLE client DROP statistic_id');
        $this->addSql('ALTER TABLE statistic ADD beer_id_id INT DEFAULT NULL, ADD client_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469C872EC465 FOREIGN KEY (beer_id_id) REFERENCES beer (id)');
        $this->addSql('ALTER TABLE statistic ADD CONSTRAINT FK_649B469CDC2902E0 FOREIGN KEY (client_id_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_649B469C872EC465 ON statistic (beer_id_id)');
        $this->addSql('CREATE INDEX IDX_649B469CDC2902E0 ON statistic (client_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statistic_beer (statistic_id INT NOT NULL, beer_id INT NOT NULL, INDEX IDX_5F8D22F453B6268F (statistic_id), INDEX IDX_5F8D22F4D0989053 (beer_id), PRIMARY KEY(statistic_id, beer_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE statistic_beer ADD CONSTRAINT FK_5F8D22F453B6268F FOREIGN KEY (statistic_id) REFERENCES statistic (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE statistic_beer ADD CONSTRAINT FK_5F8D22F4D0989053 FOREIGN KEY (beer_id) REFERENCES beer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE client ADD statistic_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045553B6268F FOREIGN KEY (statistic_id) REFERENCES statistic (id)');
        $this->addSql('CREATE INDEX IDX_C744045553B6268F ON client (statistic_id)');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469C872EC465');
        $this->addSql('ALTER TABLE statistic DROP FOREIGN KEY FK_649B469CDC2902E0');
        $this->addSql('DROP INDEX IDX_649B469C872EC465 ON statistic');
        $this->addSql('DROP INDEX IDX_649B469CDC2902E0 ON statistic');
        $this->addSql('ALTER TABLE statistic DROP beer_id_id, DROP client_id_id');
    }
}
