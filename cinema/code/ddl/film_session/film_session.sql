create table if not exists film_session (
   id int(11) unsigned auto_increment not null
  ,constraint pk_film_session primary key (id)
) engine=InnoDB collate=utf8_general_ci
;

alter table film_session add
  film_id int(11) unsigned not null
;

alter table film_session add
  cinema_hall_id int(11) unsigned not null
;

alter table film_session add
  start_date datetime not null
;

alter table film_session add unique index ix_uq_session (
   film_id
  ,cinema_hall_id
  ,start_date
);

alter table film_session add index ix_cinema_hall_id (
  cinema_hall_id
);

alter table film_session add index ix_start_date (
  start_date
);
