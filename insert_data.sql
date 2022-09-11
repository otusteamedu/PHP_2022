INSERT INTO movie (id, name)
VALUES (1, 'Властелин колец 3: Возвращение Короля'),
       (2, 'Терминатор 2: Судный день'),
       (3, 'Побег из Шоушенка');

INSERT INTO attribute_type (id, name)
VALUES (1, 'Премия'),
       (2, 'Важные даты'),
       (3, 'Служебные даты'),
       (4, 'Рецензия');

INSERT INTO attribute (id, name, type_id)
VALUES (1, 'Рецензия критиков', 4),
       (2, 'Рецензия зрителей', 4),
       (3, 'Оскар', 1),
       (4, 'Хьюго', 1),
       (5, 'Премия Американского общества кинооператоров', 1),
       (6, 'Премьера в мире', 2),
       (7, 'Премьера в России', 2),
       (8, 'Дата начала продажи билетов', 3),
       (9, 'Дата запуска рекламы', 3);

INSERT INTO value (attribute_id, movie_id, text)
VALUES (1, 1,
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ab alias architecto cupiditate delectus enim ex hic in ipsum, minus modi odit perferendis, porro possimus, recusandae reiciendis repudiandae. Aperiam aspernatur commodi consequatur debitis eum expedita, fugiat id magni, necessitatibus officia pariatur porro quae quam quo quod temporibus totam unde voluptates!'),
       (1, 2,
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam corporis, exercitationem nam nisi quas qui quis veniam? Alias eveniet laudantium minima quis veniam! A, aliquam corporis deserunt doloremque earum eligendi illum ipsam laudantium minus necessitatibus nulla odit officiis omnis optio praesentium reprehenderit repudiandae saepe sunt temporibus ullam ut voluptate voluptatum.'),
       (1, 3,
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores dolorem dolorum eligendi esse, iure magni molestiae nihil officia omnis praesentium quam quisquam repudiandae, sapiente tempore ut vel voluptas voluptatem? Deserunt explicabo in nisi quasi qui repellat, unde! Accusamus amet, cupiditate ea fugiat impedit in inventore tempore voluptate. Ad, aut earum!');

INSERT INTO value (attribute_id, movie_id, text)
VALUES (2, 1,
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium at deserunt, doloribus ducimus expedita fugiat nesciunt sed sunt suscipit voluptatem?'),
       (2, 2,
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusantium assumenda commodi, dolores ex fugit iure porro quis quisquam ratione vitae.'),
       (2, 3,
        'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci aliquam dolore, ducimus ipsa iusto laboriosam magnam minus saepe similique voluptatibus.');

INSERT INTO value (attribute_id, movie_id, bool)
VALUES (3, 1, true),
       (4, 1, true),
       (5, 1, true),
       (3, 2, true),
       (4, 2, true),
       (3, 2, true),
       (3, 3, true);

INSERT INTO value (attribute_id, movie_id, date)
VALUES (6, 1, '2003-12-01'),
       (6, 2, '1991-07-01'),
       (6, 3, '1994-09-10');

INSERT INTO value (attribute_id, movie_id, date)
VALUES (7, 1, '2004-01-22'),
       (7, 2, '1991-12-25'),
       (7, 3, '2019-10-24');

INSERT INTO value (attribute_id, movie_id, date)
VALUES (8, 1, current_date),
       (8, 2, current_date),
       (8, 3, current_date + INTERVAL '20 day');

INSERT INTO value (attribute_id, movie_id, date)
VALUES (9, 1, current_date),
       (9, 2, current_date),
       (9, 3, current_date + INTERVAL '20 day');
