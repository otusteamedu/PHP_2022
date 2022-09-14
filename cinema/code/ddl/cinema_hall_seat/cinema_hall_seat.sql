create table if not exists cinema_hall_seat (
   id int(11) unsigned auto_increment not null
  ,constraint pk_cinema_hall_seat primary key (id)
) engine=InnoDB collate=utf8_general_ci
;

alter table cinema_hall_seat add
  row int(11) unsigned not null
;

alter table cinema_hall_seat add
  number int(11) unsigned not null
;

alter table cinema_hall_seat add
  cinema_hall_id int(11) unsigned not null
;

alter table cinema_hall_seat add
  price decimal(16, 2) unsigned not null
;

-- если мы не хотим место продавать, например, соц. дистанция во время COVID-19
alter table cinema_hall_seat add
  is_available tinyint(1) unsigned not null
;

alter table cinema_hall_seat add unique index ix_uq_seat (
   row
  ,number
  ,cinema_hall_id
);

alter table cinema_hall_seat add index ix_cinema_hall_id (
  cinema_hall_id
);

alter table cinema_hall_seat add index ix_available (
  is_available
);
