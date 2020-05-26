<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200526091311 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espece (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, courbe_xp VARCHAR(3) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE espece_type (espece_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_CA6CC0B92D191E7A (espece_id), INDEX IDX_CA6CC0B9C54C8C93 (type_id), PRIMARY KEY(espece_id, type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE espece_type ADD CONSTRAINT FK_CA6CC0B92D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE espece_type ADD CONSTRAINT FK_CA6CC0B9C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE pokemon_type');
        $this->addSql('ALTER TABLE pokemon ADD xp INT NOT NULL, ADD elo INT NOT NULL, ADD repos DATETIME DEFAULT NULL, DROP courbe_xp, DROP evolution, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE type1 espece_id INT NOT NULL, CHANGE type2 prix INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F32D191E7A FOREIGN KEY (espece_id) REFERENCES espece (id)');
        $this->addSql('CREATE INDEX IDX_62DC90F32D191E7A ON pokemon (espece_id)');
        $this->addSql('ALTER TABLE user ADD argent INT NOT NULL, ADD elo INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE espece_type DROP FOREIGN KEY FK_CA6CC0B9C54C8C93');
        $this->addSql('ALTER TABLE espece_type DROP FOREIGN KEY FK_CA6CC0B92D191E7A');
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F32D191E7A');
        $this->addSql('CREATE TABLE pokemon_type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE espece');
        $this->addSql('DROP TABLE espece_type');
        $this->addSql('DROP INDEX IDX_62DC90F32D191E7A ON pokemon');
        $this->addSql('ALTER TABLE pokemon ADD courbe_xp VARCHAR(5) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD evolution TINYINT(1) NOT NULL, ADD type1 INT NOT NULL, DROP espece_id, DROP xp, DROP elo, DROP repos, CHANGE nom nom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE prix type2 INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP argent, DROP elo');
    }
}
