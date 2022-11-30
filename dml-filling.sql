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

insert into `attributes` (`id`, `attribute_type_id`, `name`) values (1, 1, 'Дата премьеры в России');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (2, 1, 'Дата премьеры в Мире');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (3, 2, 'Режисер');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (4, 3, 'Краткое описание');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (5, 1, 'Дата старта продаж DVD');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (6, 4, 'Бюджет');
insert into `attributes` (`id`, `attribute_type_id`, `name`) values (7, 6, 'Оскар');

insert into `attribute_film` (`film_id`, `attribute_id`, `val_date`) values (1, 1 , '1993-10-01');