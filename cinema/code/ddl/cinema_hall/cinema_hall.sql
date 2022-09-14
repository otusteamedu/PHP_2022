create table if not exists cinema_hall (
   id int(11) unsigned auto_increment not null
  ,constraint pk_cinema_hall primary key (id)
) engine=InnoDB collate=utf8_general_ci
;

alter table cinema_hall add
  code varchar(128) not null
;

alter table cinema_hall add unique index ix_uq_code (
  code
);
