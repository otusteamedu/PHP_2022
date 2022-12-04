-- Get all films with today events.

SELECT
    films.id as film_id,
    films.name as film_name,
    (
        SELECT
            string_agg (concat(attributes.name, ' (' , values.v_datetime::varchar, ')'), ' ; ') dates
        FROM values
                 LEFT JOIN attributes ON values.attribute_id = attributes.id
                 LEFT JOIN attribute_types ON attributes.type_id = attribute_types.id
        WHERE
                values.film_id = films.id
          and v_datetime is not null
          and v_datetime::date = now()::date
    and attribute_types.name = 'datetime'
    ) as today
FROM films

/*

При 10000 фильмах:
Seq Scan on films  (cost=0.00..23604903.00 rows=10000 width=62)
  SubPlan 1
    ->  Aggregate  (cost=2360.46..2360.47 rows=1 width=32)
          ->  Nested Loop  (cost=0.00..2360.45 rows=1 width=524)
                Join Filter: (attributes.type_id = attribute_types.id)
                ->  Nested Loop  (cost=0.00..2339.15 rows=1 width=528)
                      Join Filter: ("values".attribute_id = attributes.id)
                      ->  Seq Scan on "values"  (cost=0.00..2326.00 rows=1 width=12)
                            Filter: ((v_datetime IS NOT NULL) AND (film_id = films.id) AND ((v_datetime)::date = (now())::date))
                      ->  Seq Scan on attributes  (cost=0.00..11.40 rows=140 width=524)
                ->  Seq Scan on attribute_types  (cost=0.00..21.25 rows=4 width=4)
                      Filter: ((name)::text = 'datetime'::text)
 */
