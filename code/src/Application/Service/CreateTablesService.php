<?php

declare(strict_types=1);

namespace Nikolai\Php\Application\Service;

use PDO;

class CreateTablesService
{
    const CREATE_TABLES_AND_INDEXES_SQL = [
        'CREATE TABLE cinema_hall (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id));',
        'CREATE TABLE film (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, base_price DECIMAL NOT NULL, PRIMARY KEY(id));',
        'CREATE TABLE place (id SERIAL NOT NULL, row INT NOT NULL, col INT NOT NULL, PRIMARY KEY(id));',
        'CREATE UNIQUE INDEX place__row_col__ind ON place (row, col);',
        'CREATE TABLE cinema_hall_place_relation (id SERIAL NOT NULL, cinema_hall_id INT NOT NULL, place_id INT NOT NULL, PRIMARY KEY(id));',
        'CREATE INDEX cinema_hall_place_relation__cinema_hall_id__ind ON cinema_hall_place_relation (cinema_hall_id);',
        'CREATE INDEX cinema_hall_place_relation__place_id__ind ON cinema_hall_place_relation (place_id);',
        'ALTER TABLE cinema_hall_place_relation ADD CONSTRAINT cinema_hall_place_relation__cinema_hall_id__fk FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall (id) NOT DEFERRABLE INITIALLY IMMEDIATE;',
        'ALTER TABLE cinema_hall_place_relation ADD CONSTRAINT cinema_hall_place_relation__place_id__fk FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE;',
        'CREATE UNIQUE INDEX cinema_hall_place_relation__cinema_hall_id_place_id__ind ON cinema_hall_place_relation (cinema_hall_id, place_id);',
        'CREATE TABLE schedule (id SERIAL NOT NULL, begin_session TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, film_id INT NOT NULL, cinema_hall_id INT NOT NULL, PRIMARY KEY(id));',
        'CREATE INDEX schedule__film_id__ind ON schedule (film_id);',
        'CREATE INDEX schedule__cinema_hall_id__ind ON schedule (cinema_hall_id);',
        'ALTER TABLE schedule ADD CONSTRAINT schedule__film_id__fk FOREIGN KEY (film_id) REFERENCES film (id);',
        'ALTER TABLE schedule ADD CONSTRAINT schedule__cinema_hall_id__fk FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall (id);',
        'CREATE TABLE ticket (id SERIAL NOT NULL, schedule_id INT NOT NULL, cinema_hall_place_relation_id INT NOT NULL, price DECIMAL NOT NULL, status BOOLEAN, PRIMARY KEY(id));',
        'CREATE INDEX ticket__schedule_id__ind ON ticket (schedule_id);',
        'CREATE INDEX ticket__cinema_hall_place_relation_id__ind ON ticket (cinema_hall_place_relation_id);',
        'ALTER TABLE ticket ADD CONSTRAINT ticket__schedule_id__fk FOREIGN KEY (schedule_id) REFERENCES schedule (id);',
        'ALTER TABLE ticket ADD CONSTRAINT ticket__cinema_hall_place_relation_id__fk FOREIGN KEY (cinema_hall_place_relation_id) REFERENCES cinema_hall_place_relation (id);',
        'CREATE UNIQUE INDEX ticket__schedule_id_cinema_hall_place_relation_id__ind ON ticket (schedule_id, cinema_hall_place_relation_id);'
    ];

    public function __construct(private PDO $pdo) {}

    public function execute()
    {
        foreach (self::CREATE_TABLES_AND_INDEXES_SQL as $sql) {
            $statement = $this->pdo->prepare($sql);
            $statement->execute();
        }
        fwrite(STDOUT, 'Таблицы созданы!' . PHP_EOL);
    }
}