## Число фильмов с оскаром

```sql
SELECT COUNT(*) AS films_with_oscar
FROM attribute_film
WHERE attribute_id = 6
  AND val_bool = true;
```

### 10 000 записей

Результат: 1 строка.

![10 000](./images/oscar_films_count/result_10000.png)

#### Анализ:

Табличный вывод:

```sql
EXPLAIN
SELECT COUNT(*) AS films_with_oscar
FROM attribute_film
WHERE attribute_id = 6
  AND val_bool = true;
```

![explain](./images/oscar_films_count/explain_10000.png)

Вывод дерева:

```sql
EXPLAIN FORMAT=TREE
SELECT COUNT(*) AS films_with_oscar
FROM attribute_film
WHERE attribute_id = 6
  AND val_bool = true;
```

![explain tree](./images/oscar_films_count/explain_tree_10000.png)

```sql
EXPLAIN ANALYZE
SELECT COUNT(*) AS films_with_oscar
FROM attribute_film
WHERE attribute_id = 6
  AND val_bool = true;
```

![explain analyze](./images/oscar_films_count/analyze_10000.png)

### 1 000 000 записей

![explain analyze](./images/oscar_films_count/analyze_1000000.png)

Создан индекс
```sql
CREATE INDEX idx_val_bool
ON attribute_film (val_bool);
```

![explain analyze](./images/oscar_films_count/analyze_with_index.png)

Итоговое время выполнения уменьшилось.