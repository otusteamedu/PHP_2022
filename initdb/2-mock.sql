INSERT INTO films (id, name) VALUES (1, 'The godfather');
INSERT INTO films (id, name) VALUES (2, 'The Godfather Part II');

INSERT INTO film_attribute_types (id, type) VALUES (1, 'Рецензия');
INSERT INTO film_attribute_types (id, type) VALUES (2, 'Премия');
INSERT INTO film_attribute_types (id, type) VALUES (3, 'Важная дата');
INSERT INTO film_attribute_types (id, type) VALUES (4, 'Служебная дата');
INSERT INTO film_attribute_types (id, type) VALUES (5, 'Сумма');


INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (1, 'Рецензии критиков', 1);
INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (2, 'Отзыв неизвестной киноакадемии', 1);

INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (3, 'Оскар', 2);
INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (4, 'Эмми', 2);

INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (5, 'Мировая премьера', 3);
INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (6, 'Премьера в РФ', 3);

INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (7, 'Начало продажи билетов', 4);
INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (8, 'Запуск рекламы на ТВ', 4);
INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (9, 'Остановка рекламы на ТВ', 4);

INSERT INTO film_attributes (id, label, film_attribute_type_id) VALUES (10, 'Кассовые сборы', 5);

INSERT INTO film_values (film_id, attribute_id, value_text) VALUES (1, 1, 'С другой стороны реализация намеченных плановых заданий играет важную роль в формировании дальнейших направлений развития. Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности влечет за собой процесс внедрения и модернизации систем массового участия. С другой стороны рамки и место обучения кадров способствует подготовки и реализации существенных финансовых и административных условий. Задача организации, в особенности же укрепление и развитие структуры позволяет выполнять важные задания по разработке новых предложений. Таким образом постоянное информационно-пропагандистское обеспечение нашей деятельности влечет за собой процесс внедрения и модернизации систем массового участия. Идейные соображения высшего порядка, а также новая модель организационной деятельности позволяет оценить значение форм развития.');
INSERT INTO film_values (film_id, attribute_id, value_text) VALUES (1, 2, 'Идейные соображения высшего порядка, а также новая модель организационной деятельности представляет собой интересный эксперимент проверки систем массового участия. Задача организации, в особенности же рамки и место обучения кадров позволяет выполнять важные задания по разработке форм развития. Товарищи! начало повседневной работы по формированию позиции позволяет выполнять важные задания по разработке существенных финансовых и административных условий. Значимость этих проблем настолько очевидна, что постоянный количественный рост и сфера нашей активности способствует подготовки и реализации форм развития. Значимость этих проблем настолько очевидна, что дальнейшее развитие различных форм деятельности требуют определения и уточнения систем массового участия.');
INSERT INTO film_values (film_id, attribute_id, value_boolean) VALUES (1, 3, true);
INSERT INTO film_values (film_id, attribute_id, value_boolean) VALUES (1, 4, false);
INSERT INTO film_values (film_id, attribute_id, value_date) VALUES (1, 5, now() - interval '5 days');
INSERT INTO film_values (film_id, attribute_id, value_date) VALUES (1, 6, now() - interval '4 days');
INSERT INTO film_values (film_id, attribute_id, value_date) VALUES (1, 7, now());
INSERT INTO film_values (film_id, attribute_id, value_date) VALUES (1, 8, now());
INSERT INTO film_values (film_id, attribute_id, value_date) VALUES (1, 9, now() + interval '20 days');
INSERT INTO film_values (film_id, attribute_id, value_num) VALUES (1, 10, 121111111.5922);
