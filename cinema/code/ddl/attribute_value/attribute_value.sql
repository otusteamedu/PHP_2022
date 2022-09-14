create table if not exists attribute_value (
   entity_instance_id bigint unsigned not null
  ,attribute_id char(26) not null
  ,id char(26) not null
  ,text_value text null
  ,bool_value tinyint(1) unsigned null
  ,float_value decimal(16, 2) null
  ,int_value bigint null
  ,datetime_value datetime null
  ,constraint pk_attribute_value primary key (entity_instance_id, attribute_id, id)
);

alter table attribute_value add unique index ix_uq_attribute_value__id (
  id
);

alter table attribute_value add unique index ix_uq_attribute_value__attribute_id (
  attribute_id
);