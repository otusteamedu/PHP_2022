-- Создание таблиц halls, seats, films из предыдущих заданий
CREATE TABLE halls
(
    id         BIGSERIAL PRIMARY KEY,
    title      VARCHAR(100) NOT NULL,
    capacity   INT          NOT NULL,
    created_at TIMESTAMP default CURRENT_TIMESTAMP
);

CREATE TABLE seats
(
    id      BIGSERIAL PRIMARY KEY,
    row     INT    NOT NULL,
    number  INT    NOT NULL,
    hall_id BIGINT NOT NULL,
    CONSTRAINT fk_hall
        FOREIGN KEY (hall_id)
            REFERENCES halls (id)
);

CREATE TABLE films
(
    id           BIGSERIAL PRIMARY KEY,
    title        VARCHAR(300) NOT NULL,
    director     VARCHAR(200) NOT NULL,
    stars        text         NOT NULL,
    description  text         NOT NULL,
    duration_min int          NOT NULL,
    release_data TIMESTAMP    NOT NULL,
    is_active    BOOLEAN      NOT NULL,
    created_at   TIMESTAMP default CURRENT_TIMESTAMP
);

CREATE TABLE film_sessions
(
    id         BIGSERIAL PRIMARY KEY,
    film_id    BIGINT NOT NULL,
    hall_id    BIGINT NOT NULL,
    time_start TIME   NOT NULL,
    time_end   TIME   NOT NULL,
    CONSTRAINT fk_film
        FOREIGN KEY (film_id)
            REFERENCES films (id),
    CONSTRAINT fk_hall
        FOREIGN KEY (hall_id)
            REFERENCES halls (id),
    UNIQUE (film_id, hall_id, time_start)
);

-- функция для генерации рандомных строк
Create or replace function random_string(length integer) returns text as
$$
declare
    chars  text[]  := '{0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z,a,b,c,d,e,f,g,h,i,j,k,l,m,n,o,p,q,r,s,t,u,v,w,x,y,z}';
    result text    := '';
    i      integer := 0;
begin
    if length < 0 then
        raise exception 'Given length cannot be less than 0';
    end if;
    for i in 1..length
        loop
            result := result || chars[1 + random() * (array_length(chars, 1) - 1)];
        end loop;
    return result;
end;
$$ language plpgsql;

-- Запросы для заполнения таблиц тестовыми данными
INSERT INTO halls (title, capacity, created_at)
select random_string(10), floor(random() * 400 + 1)::int, CURRENT_TIMESTAMP
from generate_series(1, 1000000);

INSERT INTO seats (row, number, hall_id)
select floor(random() * 100 + 1)::int, floor(random() * 100 + 1)::int, floor(random() * 1000000 + 1)::int
from generate_series(1, 10000000);

INSERT INTO films (title, director, stars, description, duration_min, release_data, is_active, created_at)
select random_string(10),
       random_string(10),
       random_string(10),
       random_string(10),
       floor(random() * 100 + 1)::int,
       NOW() + (random() * (NOW() + '100 days' - NOW())) + '20 days',
       random() < 0.1,
       CURRENT_TIMESTAMP
from generate_series(1, 100000);

INSERT INTO film_sessions (film_id, hall_id, time_start, time_end)
select floor(random() * 100000 + 1)::int,
       floor(random() * 1000000 + 1)::int,
       NOW() + (random() * (NOW() + '100 days' - NOW())) + '20 days',
       NOW() + (random() * (NOW() + '100 days' - NOW())) + '20 days'
from generate_series(1, 1000000);

-- Запросы для анализа
-- Простые
SELECT id, title
FROM films
WHERE is_active;
SELECT *
FROM halls
WHERE capacity > 100;
SELECT id, title, release_data
FROM films
WHERE release_data BETWEEN now() AND now() + INTERVAL '2 month';
-- Сложные
select *
from film_sessions fs
         join films f on fs.film_id = f.id
where f.title = 'asdf';

select *
from film_sessions fs
         join halls h on fs.hall_id = h.id
         join films f on fs.film_id = f.id
where f.id = 1
  and h.id = 1
  and fs.time_start > '14:00';

select count(*)
from films f
         join film_sessions fs on f.id = fs.film_id
         join halls h on fs.hall_id = h.id
         join seats s on h.id = s.hall_id
where f.id = 1;
