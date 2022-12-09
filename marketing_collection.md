## Сбор служебных данных  для маркетинга: фильм, тип атрибута, атрибут, значение о конкретном фильме 
### (последние 15 строк)

```sql
SELECT films.title AS "title",
                 attribute_types.name AS "attr_type",
                 attributes.name AS "attr_name",
                 CASE
                     WHEN attribute_types.field = "val_string" THEN attribute_film.val_string
                     WHEN attribute_types.field = "val_int" THEN attribute_film.val_int
                     WHEN attribute_types.field = "val_bool" THEN attribute_film.val_bool
                     WHEN attribute_types.field = "val_date" THEN attribute_film.val_date
                     WHEN attribute_types.field = "val_float" THEN attribute_film.val_float
                     END  AS "value"
          FROM films
                   JOIN attribute_film ON films.id = attribute_film.film_id
                   JOIN attributes ON attribute_film.attribute_id = attributes.id
                   JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id
          ORDER BY films.id DESC
          LIMIT 15;
```

### 10 000 записей

Результат: 15 строк.

![10 000](./images/marketing_collection/result_10000.png)

#### Анализ:

Табличный вывод:

```sql
EXPLAIN
SELECT films.title AS "title",
       attribute_types.name AS "attr_type",
       attributes.name AS "attr_name",
       CASE
           WHEN attribute_types.field = "val_string" THEN attribute_film.val_string
           WHEN attribute_types.field = "val_int" THEN attribute_film.val_int
           WHEN attribute_types.field = "val_bool" THEN attribute_film.val_bool
           WHEN attribute_types.field = "val_date" THEN attribute_film.val_date
           WHEN attribute_types.field = "val_float" THEN attribute_film.val_float
           END  AS "value"
FROM films
         JOIN attribute_film ON films.id = attribute_film.film_id
         JOIN attributes ON attribute_film.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id
ORDER BY films.id DESC
LIMIT 15;
```

![explain](./images/marketing_collection/explain_10000.png)

Вывод дерева:

```sql
EXPLAIN FORMAT=TREE
SELECT films.title AS "title",
       attribute_types.name AS "attr_type",
       attributes.name AS "attr_name",
       CASE
           WHEN attribute_types.field = "val_string" THEN attribute_film.val_string
           WHEN attribute_types.field = "val_int" THEN attribute_film.val_int
           WHEN attribute_types.field = "val_bool" THEN attribute_film.val_bool
           WHEN attribute_types.field = "val_date" THEN attribute_film.val_date
           WHEN attribute_types.field = "val_float" THEN attribute_film.val_float
           END  AS "value"
FROM films
         JOIN attribute_film ON films.id = attribute_film.film_id
         JOIN attributes ON attribute_film.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id
ORDER BY films.id DESC
LIMIT 15;
```

![explain tree](./images/marketing_collection/explain_tree_10000.png)

```sql
EXPLAIN ANALYZE
SELECT films.title AS "title",
       attribute_types.name AS "attr_type",
       attributes.name AS "attr_name",
       CASE
           WHEN attribute_types.field = "val_string" THEN attribute_film.val_string
           WHEN attribute_types.field = "val_int" THEN attribute_film.val_int
           WHEN attribute_types.field = "val_bool" THEN attribute_film.val_bool
           WHEN attribute_types.field = "val_date" THEN attribute_film.val_date
           WHEN attribute_types.field = "val_float" THEN attribute_film.val_float
           END  AS "value"
FROM films
         JOIN attribute_film ON films.id = attribute_film.film_id
         JOIN attributes ON attribute_film.attribute_id = attributes.id
         JOIN attribute_types ON attributes.attribute_type_id = attribute_types.id
ORDER BY films.id DESC
LIMIT 15;
```

![explain analyze](./images/marketing_collection/analyze_10000.png)