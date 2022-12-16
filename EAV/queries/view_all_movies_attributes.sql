CREATE VIEW movies_attributes AS
SELECT m."Name"           AS movie,
       m_attr."Name"      AS attribute,
       attr."Value"::text AS value
FROM "Movie" AS m
         INNER JOIN "MovieAttributeValue" AS m_attr_val on m.id = m_attr_val."Movie"
         INNER JOIN "MovieAttribute" AS m_attr on m_attr_val."MovieAttribute" = m_attr.id
         INNER JOIN "MovieAttributeType" AS m_attr_type on m_attr_type.id = m_attr."MovieAttributeType",
     "AttributeValueDate" as attr
WHERE m_attr_type."Type" = 'date'
  AND m_attr_val."ValueId" = attr.id
UNION
SELECT m."Name"           AS movie,
       m_attr."Name"      AS attribute,
       attr."Value"::text AS value
FROM "Movie" AS m
         INNER JOIN "MovieAttributeValue" AS m_attr_val on m.id = m_attr_val."Movie"
         INNER JOIN "MovieAttribute" AS m_attr on m_attr_val."MovieAttribute" = m_attr.id
         INNER JOIN "MovieAttributeType" AS m_attr_type on m_attr_type.id = m_attr."MovieAttributeType",
     "AttributeValueBool" as attr
WHERE m_attr_type."Type" = 'bool'
  AND m_attr_val."ValueId" = attr.id
UNION
SELECT m."Name"           AS movie,
       m_attr."Name"      AS attribute,
       attr."Value"::text AS value
FROM "Movie" AS m
         INNER JOIN "MovieAttributeValue" AS m_attr_val on m.id = m_attr_val."Movie"
         INNER JOIN "MovieAttribute" AS m_attr on m_attr_val."MovieAttribute" = m_attr.id
         INNER JOIN "MovieAttributeType" AS m_attr_type on m_attr_type.id = m_attr."MovieAttributeType",
     "AttributeValueText" as attr
WHERE m_attr_type."Type" = 'text'
  AND m_attr_val."ValueId" = attr.id
ORDER BY movie ASC;

SELECT *
FROM movies_attributes;

DROP VIEW movies_attributes;