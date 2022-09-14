create table if not exists cinema_hall_seat_price_history (
   id int(11) unsigned auto_increment not null
  ,constraint pk_cinema_hall_seat_price_history primary key (id)
) engine=InnoDB collate=utf8_general_ci
;

alter table cinema_hall_seat_price_history add
  cinema_hall_seat_id int(11) unsigned not null
;

alter table cinema_hall_seat_price_history add
  price decimal(16, 2) unsigned not null
;

alter table cinema_hall_seat_price_history add
  created_at datetime not null default CURRENT_TIMESTAMP
;

alter table cinema_hall_seat_price_history add index ix_cinema_hall_seat_id (
  cinema_hall_seat_id
);
