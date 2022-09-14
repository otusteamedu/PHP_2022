create table if not exists attribute (
   name       varchar(150) not null
  ,entity_id  bigint unsigned not null
  ,id         char(26) not null
  ,type       varchar(100) not null
  ,constraint pk_attribute primary key (name, entity_id, id)
);

alter table attribute add unique index ix_uq_attribute__id (
  id
);

alter table attribute add index ix_uq_attribute__entity_id (
  entity_id
);
