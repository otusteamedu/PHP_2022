SET random_page_cost = 1.1;

-- simple bool_attribute_title
EXPLAIN SELECT * FROM bool_attribute_title;

-- simple movie_date_attribute_today
EXPLAIN SELECT * FROM movie_date_attribute_today;

-- simple movie_with_five_prefix
EXPLAIN SELECT * FROM movie_with_five_prefix;

-- with join marketing_attr_view
EXPLAIN SELECT * FROM marketing_attr_view;

-- with join events_attr_view
EXPLAIN SELECT * FROM events_attr_view;

-- with join most_truthful_attribute
EXPLAIN SELECT * FROM most_truthful_attribute;