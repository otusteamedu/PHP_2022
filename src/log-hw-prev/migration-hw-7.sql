create table film
(
    id     serial primary key,
    name   varchar(256) not null,
    length int          not null
);

create table hall
(
    id   smallserial primary key,
    name varchar(32) unique not null
);

create table seat
(
    id              serial primary key,
    raw_number      smallint not null,
    raw_seat_number smallint not null,
    hall_id         smallint,

    unique (raw_number, raw_seat_number, hall_id),
    foreign key (hall_id) references hall (id)
);

create table film_session
(
    id        serial primary key,
    film_id   smallint  not null,
    hall_id   smallint  not null,
    begins_at timestamp not null,
    ends_at   timestamp not null,

    unique (hall_id, begins_at),
    foreign key (film_id) references film (id),
    foreign key (hall_id) references hall (id)
);

create table ticket_status
(
    id   smallserial primary key,
    name varchar(32)
);

create table ticket
(
    id               serial primary key,
    film_session_id  int,
    seat_id          int,
    cost             float    not null,
    ticket_status_id smallint not null default 1,

    unique (film_session_id, seat_id),
    foreign key (film_session_id) references film_session (id),
    foreign key (seat_id) references seat (id),
    foreign key (ticket_status_id) references ticket_status (id)
);

/**
  После код ревью добавил в таблицу с фильмами
  столбец base_price - базовая цена, а также
  столбец price_coefficient - коеффицент умножения
  в зависимости от сеанса.
  Так как это миграция, добавляем пустое дефолтное значение
  */

alter table film add column base_price decimal(6,2) default 0.0;
alter table film_session add column coefficient decimal(2,1) not null default 0.0;
