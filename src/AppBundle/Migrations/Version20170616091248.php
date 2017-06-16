<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170616091248 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE player ADD COLUMN games_count SMALLINT DEFAULT 0 NOT NULL');
        $this->addSql('DROP INDEX UNIQ_419E51D999E6F5DF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__player_registration_token AS SELECT id, player_id, value, expiration_date FROM player_registration_token');
        $this->addSql('DROP TABLE player_registration_token');
        $this->addSql('CREATE TABLE player_registration_token (id INTEGER NOT NULL, player_id INTEGER DEFAULT NULL, value VARCHAR(255) NOT NULL COLLATE BINARY, expiration_date DATETIME NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_419E51D999E6F5DF FOREIGN KEY (player_id) REFERENCES player (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO player_registration_token (id, player_id, value, expiration_date) SELECT id, player_id, value, expiration_date FROM __temp__player_registration_token');
        $this->addSql('DROP TABLE __temp__player_registration_token');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_419E51D999E6F5DF ON player_registration_token (player_id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('CREATE TEMPORARY TABLE __temp__player AS SELECT id, username, password, email, activated FROM player');
        $this->addSql('DROP TABLE player');
        $this->addSql('CREATE TABLE player (id INTEGER NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, activated BOOLEAN DEFAULT \'0\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO player (id, username, password, email, activated) SELECT id, username, password, email, activated FROM __temp__player');
        $this->addSql('DROP TABLE __temp__player');
        $this->addSql('DROP INDEX UNIQ_419E51D999E6F5DF');
        $this->addSql('CREATE TEMPORARY TABLE __temp__player_registration_token AS SELECT id, player_id, value, expiration_date FROM player_registration_token');
        $this->addSql('DROP TABLE player_registration_token');
        $this->addSql('CREATE TABLE player_registration_token (id INTEGER NOT NULL, player_id INTEGER DEFAULT NULL, value VARCHAR(255) NOT NULL, expiration_date DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO player_registration_token (id, player_id, value, expiration_date) SELECT id, player_id, value, expiration_date FROM __temp__player_registration_token');
        $this->addSql('DROP TABLE __temp__player_registration_token');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_419E51D999E6F5DF ON player_registration_token (player_id)');
    }
}
