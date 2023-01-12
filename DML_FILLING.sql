INSERT INTO `movies` (`id`, `title`) VALUES(1, 'Один дома');
INSERT INTO `movies` (`id`, `title`) VALUES(2, 'Один дома 2');
INSERT INTO `movies` (`id`, `title`) VALUES(3, 'Один дома 3');
INSERT INTO `movies` (`id`, `title`) VALUES(4, 'Back to the Future');

insert into `attribute_types` (`id`, `name`, `field`) values (1, 'дата', 'val_date');
insert into `attribute_types` (`id`, `name`, `field`) values (2, 'строка', 'val_string');
insert into `attribute_types` (`id`, `name`, `field`) values (4, 'целое число', 'val_integer');
insert into `attribute_types` (`id`, `name`, `field`) values (5, 'число с плавающей точкой', 'val_float');
insert into `attribute_types` (`id`, `name`, `field`) values (6, 'логическое', 'val_bool');

insert into `attributes` (`id`, `attribute_type_id`, `name`) values (1, 1, 'Дата премьеры в Мире');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (3, 2, 'Режисер');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (4, 2, 'Краткое описание');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (5, 4, 'Возрастное ограничение');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (6, 6, 'Оскар');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (7, 1, 'Запуск рекламы');

insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (1, 1, '1990-11-01');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (2, 1, '1992-03-25');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (3, 1, '1997-11-13');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (4, 1, '2002-06-06');

insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (1, 2, '1991-04-18');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (2, 2, '1993-06-11');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (3, 2, '1994-07-04');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (4, 2, '1995-08-29');

insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_string`) values (1, 3, 'Крис Коламбус');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_string`) values (2, 3, 'Крис Коламбус');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_string`) values (3, 3, 'Крис Коламбус');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_string`) values (4, 3, 'Крис Коламбус');

insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_string`) values (1, 4, 'Американское семейство отправляется из Чикаго в Европу...');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_string`) values (2, 4, 'Самый маленький герой Америки устраивает большой переполох в Нью-Йорке...');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_string`) values (3, 4, 'Сюжет картины развивается вокруг маленького Алекса Прюита...');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_string`) values (4, 4, 'Мечта любого маленького хулигана - это когда родителей нет дома...');

insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_integer`) values (1, 5, 16);
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_integer`) values (2, 5, 16);
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_integer`) values (3, 5, 16);
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_integer`) values (4, 5, 12);

insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_bool`) values (1, 6, false);
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_bool`) values (2, 6, false);
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_bool`) values (3, 6, true);
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_bool`) values (4, 6, true);

insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (1, 7, '1990-10-01');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (2, 7, '1992-00-25');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (3, 7, '1997-10-13');
insert into `attribute_movie` (`movie_id`, `attribute_id`, `val_date`) values (4, 7, '2002-05-06');