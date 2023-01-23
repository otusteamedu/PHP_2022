INSERT INTO attribute_type (at_type)
VALUES ('bool'),
       ('int'),
       ('varchar'),
       ('text'),
       ('datetime');
INSERT INTO attribute (a_title,a_at_id)
VALUES ('review',4),
       ('award_oscar',1),
       ('award_nika',1),
       ('important_date_world_premier',5),
       ('important_date_russia_premier',5),
       ('service_date_sale_start',5),
       ('service_date_advertising_company_end',5);
INSERT INTO cinema (c_title)
VALUES ('Аватар'),
       ('Чебурашка'),
       ('Бэтмен'),
       ('Человек-паук'),
       ('Терминатор');
INSERT INTO attribute_value (av_c_id, av_a_id, av_value_bool, av_value_int, av_value_varchar, av_value_text,
                             av_value_datetime)
VALUES (1, 1, null, null, null, 'Неплохо', null),
       (2, 1, null, null, null, 'Хорошо', null),
       (1, 2, true, null, null, null, null),
       (3, 2, false, null, null, null, null),
       (1, 4, null, null, null, null, now()),
       (4, 6, null, null, null, null, now() + interval '20 days'),
       (5, 7, null, null, null, null, now() + interval '19 days'),
       (2, 7, null, null, null, null, now() + interval '21 days'),
       (3, 7, null, null, null, null, now());

