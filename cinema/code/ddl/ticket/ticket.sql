create table if not exists ticket (
   id int(11) unsigned auto_increment not null
  ,constraint pk_ticket primary key (id)
) engine=InnoDB collate=utf8_general_ci
;

alter table ticket add
  cinema_hall_seat_id int(11) unsigned not null
;

alter table ticket add
  film_session_id int(11) unsigned not null
;

-- цена на место может меняться во времени, 
-- необходимо фиксировать по какой цене был продан билет
alter table ticket add
  price_on_sale decimal(16, 2) unsigned not null
;

alter table ticket add unique index ix_uq_ticket (
   film_session_id
  ,cinema_hall_seat_id
);

alter table ticket add index ix_cinema_hall_seat_id (
  cinema_hall_seat_id
);
