INSERT INTO `films` (`title`) VALUES('The Green Mile');
INSERT INTO `films` (`title`) VALUES('The Shawshank Redemption');
INSERT INTO `films` (`title`) VALUES('Forrest Gump');
INSERT INTO `films` (`title`) VALUES('Back to the Future');

insert into attribute_types (`id`, `name`, `field`) values (1, 'дата', 'val_date');
insert into attribute_types (`id`, `name`, `field`) values (2, 'строка', 'val_string');
insert into attribute_types (`id`, `name`, `field`) values (3, 'текст', 'val_text');
insert into attribute_types (`id`, `name`, `field`) values (4, 'целое', 'val_int');
insert into attribute_types (`id`, `name`, `field`) values (5, 'с плавающей точкой', 'val_float');
insert into attribute_types (`id`, `name`, `field`) values (6, 'логическое', 'val_bool');

insert into attributes (`attribute_type_id`, `name`) values (1, 'Дата премьеры в России');
insert into attributes (`attribute_type_id`, `name`) values (1, 'Дата премьеры в Мире');