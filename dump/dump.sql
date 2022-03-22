CREATE TABLE "public.Films" (
                                "id" serial NOT NULL,
                                "name" varchar(500) NOT NULL,
                                "active" BOOLEAN NOT NULL,
                                CONSTRAINT "Films_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );



CREATE TABLE "public.Attributes" (
                                     "id" serial NOT NULL,
                                     "name" varchar(500) NOT NULL,
                                     "type" integer NOT NULL,
                                     CONSTRAINT "Attributes_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );



CREATE TABLE "public.AttributeTypes" (
                                         "id" serial NOT NULL,
                                         "name" varchar(255) NOT NULL UNIQUE,
                                         "value_type" varchar(255) NOT NULL,
                                         CONSTRAINT "AttributeTypes_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );



CREATE TABLE "public.Values" (
                                 "id" serial NOT NULL,
                                 "film_id" integer NOT NULL,
                                 "value_integer" integer,
                                 "value_text" TEXT,
                                 "value_boolean" BOOLEAN,
                                 "value_float" FLOAT,
                                 "value_date" DATE,
                                 "attribute_id" integer NOT NULL,
                                 CONSTRAINT "Values_pk" PRIMARY KEY ("id")
) WITH (
      OIDS=FALSE
    );



ALTER TABLE "Attributes" ADD CONSTRAINT "Attributes_fk0" FOREIGN KEY ("type") REFERENCES "AttributeTypes"("id");

ALTER TABLE "Values" ADD CONSTRAINT "Values_fk0" FOREIGN KEY ("film_id") REFERENCES "Films"("id");
ALTER TABLE "Values" ADD CONSTRAINT "Values_fk1" FOREIGN KEY ("attribute_id") REFERENCES "Attributes"("id");



insert into public.public.AttributeTypes (id, name, value_type)
values  (1, 'text', 'text'),
        (2, 'integer', 'integer'),
        (3, 'bool', 'boolean'),
        (4, 'date', 'datetime');



insert into public.public.Films (id, name, active)
values  (1, 'Назад в будущее', true),
        (2, 'Интерстеллар', true);



insert into public.public.Attributes (id, name, type)
values  (1, 'Оскар', 4),
        (2, 'Золотой глобус', 4),
        (3, 'Мировая премьера', 4),
        (4, 'Премьера в России', 4),
        (5, 'Страна', 1),
        (6, 'Жанр', 1),
        (7, 'Рейтинг MPAA', 1),
        (8, 'Дата начала продажи билетов', 4),
        (9, 'Дата запуска рекламы на Радио', 4),
        (10, 'Дата запуска рекламы на ТВ', 4);



insert into public.public.Values (id, film_id, value_integer, value_text, value_boolean, value_float, value_date, attribute_id)
values  (13, 2, null, null, null, null, '2014-12-24', 1),
        (14, 2, null, null, null, null, '2015-08-10', 2),
        (15, 2, null, null, null, null, '2014-10-26', 3),
        (16, 2, null, null, null, null, '2014-11-06', 4),
        (17, 2, null, 'США', null, null, null, 5),
        (18, 2, null, 'Канада', null, null, null, 5),
        (19, 2, null, 'фантастика', null, null, null, 6),
        (20, 2, null, 'PG-13', null, null, null, 7),
        (21, 2, null, null, null, null, '2014-11-06', 8),
        (22, 2, null, null, null, null, '2014-10-26', 9),
        (23, 2, null, null, null, null, '2014-10-26', 10),
        (24, 1, null, null, null, null, null, 1),
        (25, 1, null, null, null, null, null, 2),
        (26, 1, null, null, null, null, '1984-07-03', 3),
        (27, 1, null, null, null, null, '2013-12-10', 4),
        (28, 1, null, 'США', null, null, null, 5),
        (29, 1, null, 'фантастика', null, null, null, 6),
        (30, 1, null, 'PG', null, null, null, 7),
        (31, 1, null, null, null, null, '2013-12-10', 8),
        (32, 1, null, null, null, null, '2013-11-30', 9),
        (33, 1, null, null, null, null, '2013-11-30', 10);
