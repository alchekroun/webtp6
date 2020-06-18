<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200618123957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_pokemon');
        $this->addSql('ALTER TABLE type ADD montagne INT DEFAULT NULL, ADD prairie INT DEFAULT NULL, ADD ville INT DEFAULT NULL, ADD foret INT DEFAULT NULL, ADD plage INT DEFAULT NULL');
        $this->addSql('ALTER TABLE espece ADD evolution VARCHAR(3) NOT NULL');
        $this->addSql('ALTER TABLE pokemon ADD user_id INT DEFAULT NULL, ADD niveau INT DEFAULT 1 NOT NULL, CHANGE xp xp INT DEFAULT 1 NOT NULL, CHANGE elo elo INT DEFAULT 1500 NOT NULL, CHANGE status status VARCHAR(255) DEFAULT \'libre\' NOT NULL');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_62DC90F3A76ED395 ON pokemon (user_id)');
        $this->addSql('ALTER TABLE user ADD status VARCHAR(255) DEFAULT \'newbie\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_pokemon (user_id INT NOT NULL, pokemon_id INT NOT NULL, INDEX IDX_3AD18EF9A76ED395 (user_id), INDEX IDX_3AD18EF92FE71C3E (pokemon_id), PRIMARY KEY(user_id, pokemon_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_pokemon ADD CONSTRAINT FK_3AD18EF92FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_pokemon ADD CONSTRAINT FK_3AD18EF9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE espece DROP evolution');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F3A76ED395');
        $this->addSql('DROP INDEX IDX_62DC90F3A76ED395 ON pokemon');
        $this->addSql('ALTER TABLE pokemon DROP user_id, DROP niveau, CHANGE xp xp INT NOT NULL, CHANGE elo elo INT NOT NULL, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE type DROP montagne, DROP prairie, DROP ville, DROP foret, DROP plage');
        $this->addSql('ALTER TABLE user DROP status');
    }
}
