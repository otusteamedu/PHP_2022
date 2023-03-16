<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230316221235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course (id BIGSERIAL NOT NULL, title VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE lesson (id BIGSERIAL NOT NULL, course_id BIGINT DEFAULT NULL, title VARCHAR(100) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX inx__lesson__course_id ON lesson (course_id)');
        $this->addSql('CREATE TABLE score (id BIGSERIAL NOT NULL, student_id BIGINT DEFAULT NULL, task_id BIGINT DEFAULT NULL, score INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX inx__score__student_id ON score (student_id)');
        $this->addSql('CREATE INDEX inx__score__task_id ON score (task_id)');
        $this->addSql('CREATE INDEX inx__score__student_id__task_id__created_at ON score (student_id, task_id, created_at)');
        $this->addSql('CREATE TABLE skill (id BIGSERIAL NOT NULL, title VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE student (id BIGSERIAL NOT NULL, user_id BIGINT DEFAULT NULL, full_name VARCHAR(256) NOT NULL, age INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B723AF33A76ED395 ON student (user_id)');
        $this->addSql('CREATE TABLE student_course (id BIGSERIAL NOT NULL, course_id BIGINT DEFAULT NULL, student_id BIGINT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_98A8B739591CC992 ON student_course (course_id)');
        $this->addSql('CREATE INDEX IDX_98A8B739CB944F1A ON student_course (student_id)');
        $this->addSql('CREATE TABLE task (id BIGSERIAL NOT NULL, lesson_id BIGINT DEFAULT NULL, title VARCHAR(100) NOT NULL, text VARCHAR(512) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX inx__task__lesson_id ON task (lesson_id)');
        $this->addSql('CREATE TABLE task_skills (id BIGSERIAL NOT NULL, task_id BIGINT DEFAULT NULL, skill_id BIGINT DEFAULT NULL, percent INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX inx__task_skills__task_id ON task_skills (task_id)');
        $this->addSql('CREATE INDEX inx__task_skills__skill_id ON task_skills (skill_id)');
        $this->addSql('CREATE INDEX inx__task_skills__all ON task_skills (task_id, skill_id, percent)');
        $this->addSql('CREATE TABLE "user" (id BIGSERIAL NOT NULL, login VARCHAR(32) NOT NULL, password VARCHAR(100) NOT NULL, is_active BOOLEAN NOT NULL, email VARCHAR(100) DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, roles VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649AA08CB10 ON "user" (login)');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_32993751CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE score ADD CONSTRAINT FK_329937518DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student ADD CONSTRAINT FK_B723AF33A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739591CC992 FOREIGN KEY (course_id) REFERENCES course (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE student_course ADD CONSTRAINT FK_98A8B739CB944F1A FOREIGN KEY (student_id) REFERENCES student (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_skills ADD CONSTRAINT FK_EE9892A38DB60186 FOREIGN KEY (task_id) REFERENCES task (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE task_skills ADD CONSTRAINT FK_EE9892A35585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lesson DROP CONSTRAINT FK_F87474F3591CC992');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_32993751CB944F1A');
        $this->addSql('ALTER TABLE score DROP CONSTRAINT FK_329937518DB60186');
        $this->addSql('ALTER TABLE student DROP CONSTRAINT FK_B723AF33A76ED395');
        $this->addSql('ALTER TABLE student_course DROP CONSTRAINT FK_98A8B739591CC992');
        $this->addSql('ALTER TABLE student_course DROP CONSTRAINT FK_98A8B739CB944F1A');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25CDF80196');
        $this->addSql('ALTER TABLE task_skills DROP CONSTRAINT FK_EE9892A38DB60186');
        $this->addSql('ALTER TABLE task_skills DROP CONSTRAINT FK_EE9892A35585C142');
        $this->addSql('DROP TABLE course');
        $this->addSql('DROP TABLE lesson');
        $this->addSql('DROP TABLE score');
        $this->addSql('DROP TABLE skill');
        $this->addSql('DROP TABLE student');
        $this->addSql('DROP TABLE student_course');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_skills');
        $this->addSql('DROP TABLE "user"');
    }
}
