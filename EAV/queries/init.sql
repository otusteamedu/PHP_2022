-- INIT MovieAttributeType VALUES --

INSERT INTO "MovieAttributeType"(id, "Type") VALUES (1, 'date');
INSERT INTO "MovieAttributeType"(id, "Type") VALUES (2, 'text');
INSERT INTO "MovieAttributeType"(id, "Type") VALUES (3, 'bool');

-- INIT MovieAttribute VALUES --

INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (1, 'user review', 2);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (2, 'imdb review', 2);

INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (3, 'nika award', 3);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (4, 'saturn award', 3);

INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (5, 'World premier', 1);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (6, 'Russia premier', 1);

INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (7, 'start promo TV', 1);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (8, 'start promo social', 1);
INSERT INTO "MovieAttribute"(id, "Name", "MovieAttributeType") VALUES (9, 'start sales', 1);

-- INIT for Movie 1 --
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueText") VALUES (1, 1, 1, 'Ерунда полная, про какое-то железо');
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueText") VALUES (2, 1, 2, 'Шедевр');
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueBool") VALUES (3, 1, 3, true);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueBool") VALUES (4, 1, 4, false);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (5, 1, 5, CURRENT_DATE - 300);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (6, 1, 6, CURRENT_DATE - 250);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (7, 1, 7, CURRENT_DATE - 500);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (8, 1, 8, CURRENT_DATE - 400);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (9, 1, 9, CURRENT_DATE - 320);

-- INIT for Movie 2 --
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueText") VALUES (10, 2, 1, 'Не стоит того, думала с Дикаприо, а там другой кто-то');
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueText") VALUES (11, 2, 2, 'Фильм супер, всем советую');
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueBool") VALUES (12, 2, 3, false);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueBool") VALUES (13, 2, 4, true);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (14, 2, 8, CURRENT_DATE);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (15, 2, 9, CURRENT_DATE + 20);

-- INIT for Movie 3 --
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueText") VALUES (16, 3, 2, 'Под пиво и чипсы');
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (17, 3, 7, CURRENT_DATE);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (18, 3, 9, CURRENT_DATE + 20);

-- INIT for Movie 4 --
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueText") VALUES (19, 4, 1, 'Отличное кино на вечер');
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueBool") VALUES (20, 4, 3, true);
INSERT INTO "MovieAttributeValue"(id, "Movie", "MovieAttribute", "ValueDate") VALUES (21, 4, 9, CURRENT_DATE + 20);