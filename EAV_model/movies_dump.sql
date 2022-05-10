create table public.movie (
	id serial4 NOT NULL,
	"name" varchar NOT NULL,
	CONSTRAINT movie_pk PRIMARY KEY (id)
);

create table public.movie_attribute_type (
	id serial4 NOT NULL,
	type_name varchar NOT NULL,
	CONSTRAINT movie_attribute_type_pk PRIMARY KEY (id)
);

create table public.movie_attribute (
	id serial4 NOT NULL,
	"name" varchar NOT NULL,
	type_id int4 NOT NULL,
	CONSTRAINT movie_attribute_pk PRIMARY KEY (id),
	CONSTRAINT movie_attribute_fk FOREIGN KEY (type_id) REFERENCES public.movie_attribute_type(id) ON DELETE RESTRICT ON UPDATE CASCADE
);

create table public.movie_attribute_value (
	id serial4 NOT NULL,
	attribute_id int4 NOT NULL,
	movie_id int4 NOT NULL,
	value_text varchar NULL,
	value_number int4 NULL,
	value_date date NULL,
	CONSTRAINT movie_attribute_value_pk PRIMARY KEY (id),
	CONSTRAINT movie_attribute_id_fk FOREIGN KEY (attribute_id) REFERENCES public.movie_attribute(id) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT movie_attribute_value_fk FOREIGN KEY (attribute_id) REFERENCES public.movie_attribute(id) ON DELETE RESTRICT ON UPDATE CASCADE,
	CONSTRAINT movie_id_fk FOREIGN KEY (movie_id) REFERENCES public.movie(id) ON DELETE RESTRICT ON UPDATE CASCADE
);


CREATE INDEX movie_attribute_type_type_name ON movie_attribute_type(type_name);


insert into movie (id, name) values (1, 'Harishchandrachi Factory');
insert into movie (id, name) values (2, 'Road, The');
insert into movie (id, name) values (3, 'Mood Indigo (L''écume des jours)');
insert into movie (id, name) values (4, 'Let the Bullets Fly');
insert into movie (id, name) values (5, 'Day of the Falcon');
insert into movie (id, name) values (6, 'Horse Boy, The');
insert into movie (id, name) values (7, 'Exorcist II: The Heretic');
insert into movie (id, name) values (8, 'Alexander and the Terrible, Horrible, No Good, Very Bad Day');
insert into movie (id, name) values (9, 'Sweet and Lowdown');
insert into movie (id, name) values (10, 'Белое солнце пустыни');
insert into movie (id, name) values (11, 'Ménage (Tenue de soirée)');


insert into movie_attribute_type (id, type_name) values (1, 'Дата');
insert into movie_attribute_type (id, type_name) values (2, 'Текст');
insert into movie_attribute_type (id, type_name) values (3, 'Сумма');
insert into movie_attribute_type (id, type_name) values (4, 'Логическое значение');


insert into movie_attribute (id, name, type_id) values (1, 'Слоган', 2);
insert into movie_attribute (id, name, type_id) values (2, 'Сборы в США', 3);
insert into movie_attribute (id, name, type_id) values (3, 'Рецензия', 2);
insert into movie_attribute (id, name, type_id) values (4, 'Дата премьеры в России', 1);
insert into movie_attribute (id, name, type_id) values (5, 'Дата номинирования на Оскар', 1);
insert into movie_attribute (id, name, type_id) values (6, 'Дата начала продажи билетов', 1);
insert into movie_attribute (id, name, type_id) values (7, 'Дата запуска рекламы на ТВ', 1);
insert into movie_attribute (id, name, type_id) values (8, 'Дата релиза на DVD', 1);
insert into movie_attribute (id, name, type_id) values (9, 'Сборы в России', 3);
insert into movie_attribute (id, name, type_id) values (10, 'Старт показа', 1);


insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (1, 1, 1, 'Mirounga angustirostris', null, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (2, 1, 2, 'Speotyte cuniculata', null, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (3, 1, 3, 'Turtur chalcospilos', null, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (4, 1, 4, 'Haliaetus vocifer', null, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (5, 1, 5, 'Phasianus colchicus', null, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (6, 1, 6, 'Butorides striatus', null, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (9, 1, 9, 'Tayassu pecari', null, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (10, 1, 10, 'Felis wiedi or Leopardus weidi', null, null);


insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (11, 2, 2, null, 55555555, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (12, 2, 4, null, 300000, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (13, 2, 5, null, 100000, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (14, 2, 7, null, 20000000, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (15, 2, 9, null, 123123123, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (16, 2, 10, null, 3412341241, null);


insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (17, 3, 2, null, 'Eastern white pelican', null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (18, 3, 4, null, 'Bohor reedbuck', null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (19, 3, 5, null, 'Golden-mantled ground squirrel', null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (20, 3, 7, null, 'Pampa gray fox', null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (21, 3, 9, null, 'American badger', null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (22, 3, 10, null, 'Malabar squirrel', null);



insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (23, 4, 2, null, null, '1999-07-13');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (24, 4, 4, null, null, '2000-11-14');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (25, 4, 5, null, null, '1995-09-17');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (26, 4, 7, null, null, '1997-01-18');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (27, 4, 9, null, null, '1998-02-13');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (28, 4, 10, null, null, '1993-04-01');


insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (29, 5, 1, null, null, '1998-06-13');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (30, 5, 3, null, null, '2001-11-22');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (31, 5, 6, null, null, '1996-09-18');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (32, 5, 8, null, null, '1998-01-19');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (33, 5, 9, null, null, '1999-02-21');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (34, 5, 10, null, null, '1994-04-02');



insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (63, 6, 1, null, null, '1999-07-01');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (64, 6, 4, null, null, '2002-12-02');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (65, 6, 5, null, null, '1997-10-03');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (66, 6, 8, null, null, '1999-02-04');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (67, 6, 6, null, null, '2000-03-05');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (68, 6, 2, null, null, '1995-04-06');



insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (35, 7, 2, null, null, '2000-08-02');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (36, 7, 3, null, null, '2003-01-03');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (37, 7, 4, null, null, '1998-11-04');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (38, 7, 6, null, null, '2000-03-05');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (39, 7, 8, null, null, '2001-04-06');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (40, 7, 10, null, null, '1996-05-07');



insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (41, 8, 1, null, null, '2001-09-03');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (42, 8, 2, null, null, '2004-02-04');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (43, 8, 4, null, null, '1999-12-05');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (44, 8, 5, null, null, '2001-04-06');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (45, 8, 6, null, null, '2002-05-07');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (46, 8, 7, null, null, '1997-06-08');



insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (47, 9, 2, null, 111111, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (48, 9, 4, null, 222222, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (49, 9, 5, null, 333333, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (50, 9, 7, null, 444444, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (51, 9, 9, null, 555555, null);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (52, 9, 10, null, 6666666, null);


insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (53, 10, 2, null, null, current_date);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (54, 10, 4, null, null, current_date);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (55, 10, 5, null, null, current_date);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (56, 10, 7, null, null, current_date);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (57, 10, 9, null, null, current_date);
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (58, 10, 10, null, null, current_date);

insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (59, 10, 1, null, null, current_date + INTERVAL '20 day');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (60, 10, 3, null, null, current_date + INTERVAL '20 day');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (61, 10, 6, null, null, current_date + INTERVAL '20 day');
insert into movie_attribute_value (id, attribute_id, movie_id, value_text, value_number, value_date) values (62, 10, 8, null, null, current_date + INTERVAL '20 day');