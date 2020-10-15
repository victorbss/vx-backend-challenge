<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20190811195105 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('INSERT INTO empresa (id, nome, cnpj) VALUES (1, \'Empresa 1\', \'34243423424\')');
        $this->addSql('INSERT INTO empresa (id, nome, cnpj) VALUES (2, \'Empresa 2\', \'64565654645\')');

        $this->addSql('INSERT INTO socio (id, empresa_id, nome, cpf) VALUES (1, 1,\'Sócio 1\', \'23123123123\')');
        $this->addSql('INSERT INTO socio (id, empresa_id, nome, cpf) VALUES (2, 1,\'Sócio 2\', \'24342423424\')');
        $this->addSql('INSERT INTO socio (id, empresa_id, nome, cpf) VALUES (3, 2,\'Sócio 3\', \'75676756765\')');
        $this->addSql('INSERT INTO socio (id, empresa_id, nome, cpf) VALUES (4, 2,\'Sócio 4\', \'65756756756\')');
    }

    public function down(Schema $schema) : void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');
    }
}
