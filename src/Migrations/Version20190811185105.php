<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190811185105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE empresa_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE socio_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE empresa (id INT NOT NULL, nome VARCHAR(255) NOT NULL, cnpj VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE socio (id INT NOT NULL, empresa_id INT NOT NULL, nome VARCHAR(255) NOT NULL, cpf VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_38B65309521E1991 ON socio (empresa_id)');
        $this->addSql('ALTER TABLE socio ADD CONSTRAINT FK_38B65309521E1991 FOREIGN KEY (empresa_id) REFERENCES empresa (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE socio DROP CONSTRAINT FK_38B65309521E1991');
        $this->addSql('DROP SEQUENCE empresa_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE socio_id_seq CASCADE');
        $this->addSql('DROP TABLE empresa');
        $this->addSql('DROP TABLE socio');
    }
}
