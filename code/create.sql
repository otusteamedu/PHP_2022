/* Создание таблицы cinema_hall (залы кинотетра) */
CREATE TABLE cinema_hall (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id));

/* Создание таблицы film (фильмы): длительность фильма - в минутах */
CREATE TABLE film (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, base_price DECIMAL NOT NULL, PRIMARY KEY(id));

/* Создание таблицы place (места в залах): row - ряд, col - место в ряду */
CREATE TABLE place (id SERIAL NOT NULL, row INT NOT NULL, col INT NOT NULL, PRIMARY KEY(id));
CREATE UNIQUE INDEX place__row_col__ind ON place (row, col);

/* Создание таблицы cinema_hall_place_relation (отношение залов и мест) */
CREATE TABLE cinema_hall_place_relation (id SERIAL NOT NULL, cinema_hall_id INT NOT NULL, place_id INT NOT NULL, PRIMARY KEY(id));
CREATE INDEX cinema_hall_place_relation__cinema_hall_id__ind ON cinema_hall_place_relation (cinema_hall_id);
CREATE INDEX cinema_hall_place_relation__place_id__ind ON cinema_hall_place_relation (place_id);
ALTER TABLE cinema_hall_place_relation ADD CONSTRAINT cinema_hall_place_relation__cinema_hall_id__fk FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
ALTER TABLE cinema_hall_place_relation ADD CONSTRAINT cinema_hall_place_relation__place_id__fk FOREIGN KEY (place_id) REFERENCES place (id) NOT DEFERRABLE INITIALLY IMMEDIATE;
CREATE UNIQUE INDEX cinema_hall_place_relation__cinema_hall_id_place_id__ind ON cinema_hall_place_relation (cinema_hall_id, place_id);

/* Создание таблицы schedule (расписание сеансов) */
CREATE TABLE schedule (id SERIAL NOT NULL, begin_session TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, film_id INT NOT NULL, cinema_hall_id INT NOT NULL, PRIMARY KEY(id));
CREATE INDEX schedule__film_id__ind ON schedule (film_id);
CREATE INDEX schedule__cinema_hall_id__ind ON schedule (cinema_hall_id);
ALTER TABLE schedule ADD CONSTRAINT schedule__film_id__fk FOREIGN KEY (film_id) REFERENCES film (id);
ALTER TABLE schedule ADD CONSTRAINT schedule__cinema_hall_id__fk FOREIGN KEY (cinema_hall_id) REFERENCES cinema_hall (id);

/* Создание таблицы ticket (билеты на сеансы): status - статус билета: true - продан, иначе - место свободно */
CREATE TABLE ticket (id SERIAL NOT NULL, schedule_id INT NOT NULL, cinema_hall_place_relation_id INT NOT NULL, price DECIMAL NOT NULL, status BOOLEAN, PRIMARY KEY(id));
CREATE INDEX ticket__schedule_id__ind ON ticket (schedule_id);
CREATE INDEX ticket__cinema_hall_place_relation_id__ind ON ticket (cinema_hall_place_relation_id);
ALTER TABLE ticket ADD CONSTRAINT ticket__schedule_id__fk FOREIGN KEY (schedule_id) REFERENCES schedule (id);
ALTER TABLE ticket ADD CONSTRAINT ticket__cinema_hall_place_relation_id__fk FOREIGN KEY (cinema_hall_place_relation_id) REFERENCES cinema_hall_place_relation (id);
CREATE UNIQUE INDEX ticket__schedule_id_cinema_hall_place_relation_id__ind ON ticket (schedule_id, cinema_hall_place_relation_id);

/* Создание таблицы price_setting (коэффициенты цен для билетов) */
CREATE TABLE price_setting (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, coefficient DECIMAL NOT NULL, PRIMARY KEY(id));

/* Создание таблицы ticket_price_setting_relation (отношения билетов и коэффициентов цен) */
CREATE TABLE ticket_price_setting_relation (id SERIAL NOT NULL, ticket_id INT NOT NULL, price_setting_id INT NOT NULL, PRIMARY KEY(id));
CREATE INDEX ticket_price_setting_relation__ticket_id__ind ON ticket_price_setting_relation (ticket_id);
CREATE INDEX ticket_price_setting_relation__price_setting_id__ind ON ticket_price_setting_relation (price_setting_id);
ALTER TABLE ticket_price_setting_relation ADD CONSTRAINT ticket_price_setting_relation__ticket_id__fk FOREIGN KEY (ticket_id) REFERENCES ticket (id);
ALTER TABLE ticket_price_setting_relation ADD CONSTRAINT ticket_price_setting_relation__price_setting_id__fk FOREIGN KEY (price_setting_id) REFERENCES price_setting (id);
CREATE UNIQUE INDEX ticket_price_setting_relation__ticket_id_price_setting_id__ind ON ticket_price_setting_relation (ticket_id, price_setting_id);

/* Создание таблицы log для отладки скрипта по добавлению тестовыхданных и тригера*/
CREATE TABLE log (id SERIAL NOT NULL, tbl VARCHAR(100), txt VARCHAR(2048), PRIMARY KEY(id));
CREATE INDEX log__tbl__ind ON log (tbl);

/**
    Триггер, который проверяет, что билет создан или обновлен к месту, которое есть в данном зале
 */
CREATE OR REPLACE FUNCTION verify_cinema_hall_place_relation() RETURNS trigger AS $verify_cinema_hall_place_relation$
DECLARE
    cinema_hall_id_ticket INT;
    cinema_hall_place_relation_id INT;
BEGIN
    SELECT cinema_hall_id FROM schedule WHERE id = NEW.schedule_id INTO cinema_hall_id_ticket;

    SELECT id FROM cinema_hall_place_relation
    WHERE id = NEW.cinema_hall_place_relation_id AND cinema_hall_id = cinema_hall_id_ticket
    INTO cinema_hall_place_relation_id;

    IF cinema_hall_place_relation_id IS NULL THEN
        RAISE EXCEPTION 'В зале с cinema_hall_id: % нет места с cinema_hall_place_relation_id: %', cinema_hall_id_ticket, NEW.cinema_hall_place_relation_id;
    END IF;

    RETURN NEW;
END;
$verify_cinema_hall_place_relation$ LANGUAGE plpgsql;

CREATE TRIGGER verify_cinema_hall_place_relation BEFORE INSERT OR UPDATE ON ticket
    FOR EACH ROW EXECUTE PROCEDURE verify_cinema_hall_place_relation();
