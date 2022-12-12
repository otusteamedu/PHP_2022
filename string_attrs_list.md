## Список названий атрибутов имеющих строковый тип

```sql
SELECT `name`
FROM attributes
WHERE attribute_type_id = 2;
```

### 10 000 записей

Результат: 2 строки.

![10 000](./images/string_attrs_list/result_10000.png)

#### Анализ:

Табличный вывод:

```sql
EXPLAIN 
SELECT `name`
FROM attributes
WHERE attribute_type_id = 2;
```

![explain](./images/string_attrs_list/explain_10000.png)

Вывод дерева:

```sql
EXPLAIN FORMAT=TREE
SELECT `name`
FROM attributes
WHERE attribute_type_id = 2;
```

![explain tree](./images/string_attrs_list/explain_tree_10000.png)

```sql
EXPLAIN ANALYZE
SELECT `name`
FROM attributes
WHERE attribute_type_id = 2;
```

![explain analyze](./images/string_attrs_list/analyze_10000.png)

### 1 000 000 записей

![explain analyze](./images/string_attrs_list/analyze_1000000.png)

Оптимизация не требуется.