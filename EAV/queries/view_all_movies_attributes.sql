CREATE VIEW movies_attributes AS
SELECT m."Name"                                                                             AS movie,
       m_attr."Name"                                                                        AS attribute,
       CONCAT(m_attr_val."ValueBool", m_attr_val."ValueDate", m_attr_val."ValueText")::text AS value
FROM "Movie" AS m
         INNER JOIN "MovieAttributeValue" AS m_attr_val on m.id = m_attr_val."Movie"
         INNER JOIN "MovieAttribute" AS m_attr on m_attr_val."MovieAttribute" = m_attr.id
         INNER JOIN "MovieAttributeType" AS m_attr_type on m_attr_type.id = m_attr."MovieAttributeType"
ORDER BY movie ASC;

SELECT *
FROM movies_attributes;

DROP VIEW movies_attributes;