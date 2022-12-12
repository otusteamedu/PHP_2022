## Общее число фильмов

```sql
SELECT COUNT(*) AS film_count
FROM films;
```

### 10 000 записей

Результат: 1 строка (коичество фильмов 1250, т.к. 
на каждый фильм приходиться несколько атрибутов).

![10 000](./images/total_films_num/result_10000.png)

#### Анализ:

Табличный вывод:

```sql
EXPLAIN
SELECT COUNT(*) AS film_count
FROM films;
```

![explain](./images/total_films_num/explain_10000.png)

Вывод дерева:

```sql
EXPLAIN FORMAT=TREE
SELECT COUNT(*) AS film_count
FROM films;
```

![explain tree](./images/total_films_num/explain_tree_10000.png)

```sql
EXPLAIN ANALYZE
SELECT COUNT(*) AS film_count
FROM films;
```

![explain analyze](./images/total_films_num/analyze_10000.png)

### 1 000 000 записей

EXPLAIN ANALYZE:

![explain analyze](./images/total_films_num/analyze_1000000.png)

Оптимизация не требуется.