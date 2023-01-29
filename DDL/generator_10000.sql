-- генератор на 10000 записей
insert into movies(
    id, name, description, duration, is_deleted
)
select
    gs.id,
    random_string((2+random()*48)::integer),
    random_string((1+random()*254)::integer),
    (90+random()*90)::integer,
    (random() < 0.1)::bool
from
    generate_series(1, 10000) as gs(id);