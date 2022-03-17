CREATE TABLE "film" (
	"film_id" serial NOT NULL,
	"film_name" varchar(255) NOT NULL,
	CONSTRAINT "film_pk" PRIMARY KEY ("film_id")
) WITH (
  OIDS=FALSE
);

CREATE TABLE "attr_type" (
	"type_id" serial NOT NULL,
	"type_name" varchar(255) NOT NULL,
	"t_type_id" integer,
	CONSTRAINT "attr_type_pk" PRIMARY KEY ("type_id")
) WITH (
  OIDS=FALSE
);

CREATE TABLE "attribute" (
	"attr_id" serial NOT NULL,
	"attr_name" varchar(255) NOT NULL UNIQUE,
	"attr_type_id" integer NOT NULL,
	CONSTRAINT "attribute_pk" PRIMARY KEY ("attr_id")
) WITH (
  OIDS=FALSE
);

CREATE TABLE "attr_value" (
	"attr_value_id" serial NOT NULL,
	"attr_id"   serial NOT NULL,
	"text_val"  text NULL,
	"bool_val"  boolean NULL,
	"date_val"  timestamp NULL,
	"int_val"   integer NULL,
	"float_val" float NULL,
	"film_id"   integer NOT NULL,
	CONSTRAINT "attr_value_pk" PRIMARY KEY ("attr_value_id")
) WITH (
  OIDS=FALSE
);

ALTER TABLE "attr_type" ADD CONSTRAINT "attr_type_fk0" FOREIGN KEY ("type_id") REFERENCES "attr_type"("type_id");

ALTER TABLE "attribute" ADD CONSTRAINT "attribute_fk0" FOREIGN KEY ("attr_type_id") REFERENCES "attr_type"("type_id");

ALTER TABLE "attr_value" ADD CONSTRAINT "attr_value_fk0" FOREIGN KEY ("attr_id") REFERENCES "attribute"("attr_id");
ALTER TABLE "attr_value" ADD CONSTRAINT "attr_value_fk1" FOREIGN KEY ("film_id") REFERENCES "film"("film_id");

INSERT INTO film (film_id, film_name) VALUES
(1, 'Матрица'),
(2, 'Брат'),
(3, 'Брат 2'),
(4, 'Терминатор'),
(5, 'Терминатор 2'),
(6, 'Зеленая миля'),
(7, 'Зеленая книга'),
(8, 'Оно'),
(9, 'Собачья жизнь'),
(10, 'Малышка на миллион');

INSERT INTO attr_type (type_id, type_name, t_type_id) VALUES
(1, 'text', null),
(2, 'date', null),
(3, 'integer', null),
(4, 'boolean', null),
(5, 'рецензии', 1),
(6, 'премия', 4),
(7, 'важные даты', 2),
(8, 'служебные даты', 2),
(9, 'статистика', 3);

INSERT INTO attribute (attr_id, attr_name, attr_type_id) VALUES
(1, 'рецензии критиков', 5),
(2, 'рецензии киноакадемии', 5),
(3, 'рецензии пользователей', 5),
(4, 'Оскар', 6),
(5, 'Ника', 6),
(6, 'Золотой глобус', 5),
(7, 'Мировая премьера', 7),
(8, 'Премьера в России', 7),
(9, 'Дата начала продажи билетов', 8),
(10, 'Дата запуска рекламы', 8),
(11, 'Сборы в мире', 9),
(12, 'Сборы в России', 9),
(13, 'Количество рецензий', 9);

INSERT INTO attr_value (attr_value_id, attr_id, text_val, bool_val, date_val, film_id) VALUES
(1, 1, 'Рецензия критика 1', null, null, 1),
(2, 1, 'Рецензия критика 2', null, null, 1),
(3, 1, 'Рецензия критика 1', null, null, 2),
(4, 1, 'Рецензия критика 2', null, null, 2),
(5, 2, 'Рецензия киноакадемии 1', null, null, 3),
(6, 2, 'Рецензия киноакадемии 2', null, null, 3),
(7, 4, null, true, null, 5),
(8, 5, null, true, null, 5),
(9, 9, null, null, CURRENT_DATE, 1),
(10, 9, null, null, CURRENT_DATE, 2),
(11, 9, null, null, CURRENT_DATE, 3),
(12, 9, null, null, (CURRENT_DATE + '20 days'::interval day), 4),
(13, 9, null, null, (CURRENT_DATE + '20 days'::interval day), 5),
(14, 4, null, false, null, 9);
