create table if not exists film (
   id int(11) unsigned auto_increment not null
  ,constraint pk_film primary key (id)
) engine=InnoDB collate=utf8_general_ci
;

alter table film add
  name varchar(256) not null
;

alter table film add
  duration int(11) unsigned not null
;

alter table film add
  description text not null
;

alter table film add unique index ix_iq_film (
  name
);
