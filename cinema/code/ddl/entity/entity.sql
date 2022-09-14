create table if not exists entity (
   id bigint unsigned not null auto_increment
  ,constraint pk_entity primary key (id)
);

alter table entity add
  name varchar(255) not null
;

alter table entity add unique index ix_uq_entity__name (
  name
);
