INSERT INTO films
VALUES (1, 'Белое солнце пустыни'),
       (2, 'Терминатор 2'),
       (3, 'Чужие');


INSERT INTO attribute_types
VALUES (1, 'Отзывы', 'text'),
       (2, 'Премии', 'boolean'),
       (3, 'Важные даты', 'date'),
       (4, 'Служебные даты', 'date');


INSERT INTO attributes
VALUES (1, 'Отзыв критика Х', 1),
       (2, 'Отзыв критика Y', 1),
       (3, 'Оскар', 2),
       (4, 'Ника', 2),
       (5, 'Мировая премьера', 3),
       (6, 'Премьера в РФ ', 3),
       (7, 'Старт продаж билетов', 4),
       (8, 'Старт рекламы на ТВ', 4);


INSERT INTO attribute_values
VALUES (1, 1, 2, 'Отличный фильм', NULL, NULL, NULL),
       (2, 1, 4, '', NULL, TRUE, NULL),
       (3, 1, 6, '', '2023-06-03', NULL, NULL),
       (4, 1, 7, '', '2023-06-23', NULL, NULL),
       (5, 2, 1, 'Веха в истории кино', NULL, NULL, NULL),
       (6, 2, 3, '', NULL, TRUE, NULL),
       (7, 2, 5, '', '2023-06-23', NULL, NULL),
       (8, 2, 8, '', '2023-06-03', NULL, NULL),
       (9, 1, 8, '', '2023-06-23', NULL, NULL),
       (10, 1, 3, '', NULL, TRUE, NULL);