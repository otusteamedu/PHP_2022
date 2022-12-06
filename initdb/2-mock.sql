INSERT INTO halls (name, count_rows, count_seats_in_row) VALUES ('first', 10, 10);
INSERT INTO halls (name, count_rows, count_seats_in_row) VALUES ('second', 20, 10);
INSERT INTO halls (name, count_rows, count_seats_in_row) VALUES ('third', 30, 10);

INSERT INTO films (name, duration, beginning_of_distribution, end_of_distribution) VALUES ('Матрица', 60,'2022-01-01', '2022-01-05' );
INSERT INTO films (name, duration, beginning_of_distribution, end_of_distribution) VALUES ('Матрица: Перезагрузка', 80, '2022-01-01', '2022-01-05');
INSERT INTO films (name, duration, beginning_of_distribution, end_of_distribution) VALUES ('Матрица: Революция', 180, '2022-01-01', '2022-01-05' );


INSERT INTO sectors (name, markup_percentage) VALUES ('standard', 0);
INSERT INTO sectors (name, markup_percentage) VALUES ('first_row', 25);
INSERT INTO sectors (name, markup_percentage) VALUES ('last_row', 50);

-- Заполнение таблицы мест
INSERT INTO rows_seats (hall_id, seat, row, sector_id)
SELECT halls.id,  seat, row,
       CASE
           WHEN row = 1 THEN 2
           WHEN row = count_seats_in_row THEN 3
           ELSE 1
        END AS sector_id
FROM halls, generate_series(1, count_seats_in_row) seat,  generate_series(1, count_rows) row;


-- Заполнение таблицы показов
INSERT INTO screening (beginning_date_time, hall_id, film_id)
SELECT  screening_begining, id, id FROM films,
generate_series(
    beginning_of_distribution,
    end_of_distribution + interval '1 day',
    duration * interval '1 min'
) as screening_begining
WHERE extract(hour from screening_begining) between 12 AND 23;


-- Заполнение таблицы билетов
INSERT INTO tickets(sold, price, screening_id, rows_seats_id)
SELECT
    (round(random())::int)::boolean as sold,
    (100 + (100 * sectors.markup_percentage / 100))::numeric as price,
    screening.id as screening_id,
    rs.id
FROM screening
         RIGHT OUTER JOIN rows_seats rs on screening.hall_id = rs.hall_id
         JOIN sectors on rs.sector_id = sectors.id