insert into film (id, name, length)
values
    (1, 'Пираты силиконовой долины', 120),
    (2, 'Ангелы Чарли', 105),
    (3, 'Терминатор 2', 130)
;

insert into film_attribute_value (film_id, attribute_id, v_date)
values
    (1, 13, current_date - interval '3 days'),
    (1, 14, current_date),
    (1, 15, current_date + interval '29 days'),
    (1, 16, current_date - interval '30 days'),
    (1, 9, current_date - interval '5 days'),
    (1, 10, current_date),
    (1, 11, current_date - interval '30 days'),
    (2, 13, current_date - interval '2 days'),
    (2, 14, current_date),
    (2, 15, current_date + interval '20 days'),
    (2, 16, current_date - interval '20 days'),
    (2, 9, current_date - interval '3 days'),
    (2, 10, current_date),
    (3, 13, current_date - interval '2 days'),
    (3, 14, current_date),
    (3, 15, current_date + interval '20 days'),
    (3, 16, current_date - interval '20 days'),
    (3, 9, current_date - interval '3 days'),
    (3, 10, current_date),
    (3, 11, current_date - interval '6 days')


