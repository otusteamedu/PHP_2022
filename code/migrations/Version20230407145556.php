<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230407145556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task_answers (id BIGSERIAL NOT NULL, task_id BIGINT DEFAULT NULL, is_correct BOOLEAN NOT NULL, text TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX inx__task_answers__task_id ON task_answers (task_id)');
        $this->addSql('ALTER TABLE task_answers ADD CONSTRAINT FK__task_answers__task_id FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
       // $this->addSql('ALTER INDEX inx_unq__user__login RENAME TO UNIQ_8D93D649AA08CB10');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE task_answers DROP CONSTRAINT FK__task_answers__task_id');
        $this->addSql('DROP TABLE task_answers');
     //   $this->addSql('ALTER INDEX uniq_8d93d649aa08cb10 RENAME TO inx_unq__user__login');
    }
}
