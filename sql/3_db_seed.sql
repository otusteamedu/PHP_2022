insert into hall
values (1, 'Red Room'),
       (2, 'Love'),
       (3, 'Relax'),
       (4, 'Liberty'),
       (5, 'VIP');

insert into seat_type
values (1, 'Regular', 0),
       (2, 'D-Box', 150),
       (3, 'Couch', 500),
       (4, 'VIP', 500),
       (5, 'Beanbag chair', 100);

do
$$
    begin
        for i in 1..5
            loop
                for j in 1..6
                    loop
                        for k in 1..10
                            loop
                                insert into seat (hall_id, seat_type_id, row_number, seat_number)
                                values (i, random_integer(1, 5), j, k);
                            end loop;
                    end loop;
            end loop;
    end;
$$;

insert into status
values (1, 'Booked'),
       (2, 'Prepaid'),
       (3, 'Cancelled'),
       (4, 'Free');

insert into movie(id, name, duration, base_price)
select gs.id,
       random_string((1 + random() * 29)::integer),
       random_integer(60, 360),
       random_integer(250, 1000)
from generate_series(1, 10000) as gs(id);

insert into movie_attribute_type (id, name)
values (1, 'string'),
       (2, 'integer'),
       (3, 'boolean'),
       (4, 'float'),
       (5, 'datetime');

insert into movie_attribute (id, name, attribute_type_id)
values (1, 'Official Review', 1),
       (2, 'Unknown Person Review', 1),
       (3, 'Oscar', 3),
       (4, 'MTV Award', 3),
       (5, 'Cannes Golden Palm', 3),
       (6, 'World Premiere', 5),
       (7, 'Russia Premiere', 5),
       (8, 'USA Premiere', 5),
       (9, 'Netflix Start', 5),
       (10, 'Sales Start', 5),
       (11, 'Sales End', 5),
       (12, 'Promotion Start', 5),
       (13, 'Promotion End', 5);

insert into movie_attribute_value (id, movie_id, movie_attribute_id, value_datetime)
select gs.id,
       random_integer(1, 10000),
       random_integer(6, 13),
       random_timestamp()
from generate_series(1, 10000) as gs(id);

insert into session
select gs.id,
       random_integer(1, 10000),
       random_integer(1, 5),
       random_timestamp(),
       random() * 2 + 1
from generate_series(1, 300) as gs(id);

insert into seat_session
select gs.id,
       random_integer(1, 300),
       random_integer(1, 300)
from generate_series(1, 200) as gs(id);

insert into ticket
select gs.id,
       random_timestamp(),
       random_integer(500, 1000)::numeric,
       random_string((1 + random() * 29)::integer)
from generate_series(1, 200) as gs(id);

insert into ticket_status
select gs.id,
       random_integer(1, 200),
       random_integer(1, 200),
       random_integer(1, 4)
from generate_series(1, 200) as gs(id);