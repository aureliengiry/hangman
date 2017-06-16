<?php

namespace AppBundle\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170615154004 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE player_registration_token (id INTEGER NOT NULL, player_id INTEGER DEFAULT NULL, value VARCHAR(255) NOT NULL, expiration_date DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_419E51D999E6F5DF ON player_registration_token (player_id)');
        $this->addSql('ALTER TABLE player ADD COLUMN activated BOOLEAN DEFAULT \'0\' NOT NULL');
    }

    public function down(Schema $schema)
    {
        $this->addSql('DROP TABLE player_registration_token');
        $this->addSql('CREATE TEMPORARY TABLE __temp__player AS SELECT id, username, password, email FROM player');
        $this->addSql('DROP TABLE player');
        $this->addSql('CREATE TABLE player (id INTEGER NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO player (id, username, password, email) SELECT id, username, password, email FROM __temp__player');
        $this->addSql('DROP TABLE __temp__player');
    }
}
