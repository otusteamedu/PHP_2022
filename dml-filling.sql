INSERT INTO `films` (`id`, `title`) VALUES(1, 'The Green Mile');
INSERT INTO `films` (`id`, `title`) VALUES(2, 'The Shawshank Redemption');
INSERT INTO `films` (`id`, `title`) VALUES(3, 'Forrest Gump');
INSERT INTO `films` (`id`, `title`) VALUES(4, 'Back to the Future');

insert into `attribute_types` (`id`, `name`, `field`) values (1, 'дата', 'val_date');
insert into `attribute_types` (`id`, `name`, `field`) values (2, 'строка', 'val_string');
insert into `attribute_types` (`id`, `name`, `field`) values (3, 'текст', 'val_text');
insert into `attribute_types` (`id`, `name`, `field`) values (4, 'целое', 'val_int');
insert into `attribute_types` (`id`, `name`, `field`) values (5, 'с плавающей точкой', 'val_float');
insert into `attribute_types` (`id`, `name`, `field`) values (6, 'логическое', 'val_bool');

insert into `attributes` (`id`, `attribute_type_id`, `name`) values (1, 1, 'Дата премьеры в Мире');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (2, 1, 'Дата премьеры в России');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (3, 2, 'Режисер');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (4, 3, 'Краткое описание');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (5, 4, 'Возраст');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (6, 6, 'Оскар');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (7, 1, 'Запуск рекламы');

insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (1, 1, '1999-12-06');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (2, 1, '1994-09-10');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (3, 1, '1994-06-23');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (4, 1, '1985-07-03');

insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (1, 2, '2000-04-18');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (2, 2, '2019-10-24');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (3, 2, '2020-02-13');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (4, 2, '2013-06-10');

insert into `attribute_film` (`film_id`, `attribute_id`, `val_string`) values (1, 3, 'Фрэнк Дарабонт');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_string`) values (2, 3, 'Фрэнк Дарабонт');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_string`) values (3, 3, 'Роберт Земекис');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_string`) values (4, 3, 'Роберт Земекис');

insert into `attribute_film` (`film_id`, `attribute_id`, `val_text`) values (1, 4, 'Пол Эджкомб — начальник блока смертников...');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_text`) values (2, 4, 'Бухгалтер Энди Дюфрейн обвинён в...');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_text`) values (3, 4, 'Сидя на автобусной остановке, Форрест Гамп...');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_text`) values (4, 4, '1999-05-07');

insert into `attribute_film` (`film_id`, `attribute_id`, `val_int`) values (1, 5, 16);
insert into `attribute_film` (`film_id`, `attribute_id`, `val_int`) values (2, 5, 16);
insert into `attribute_film` (`film_id`, `attribute_id`, `val_int`) values (3, 5, 16);
insert into `attribute_film` (`film_id`, `attribute_id`, `val_int`) values (4, 5, 12);

insert into `attribute_film` (`film_id`, `attribute_id`, `val_bool`) values (1, 6, false);
insert into `attribute_film` (`film_id`, `attribute_id`, `val_bool`) values (2, 6, false);
insert into `attribute_film` (`film_id`, `attribute_id`, `val_bool`) values (3, 6, true);
insert into `attribute_film` (`film_id`, `attribute_id`, `val_bool`) values (4, 6, true);

insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (1, 7, '2022-12-01');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (2, 7, '2022-12-01');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (3, 7, '2022-12-21');
insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (4, 7, '2022-12-21');