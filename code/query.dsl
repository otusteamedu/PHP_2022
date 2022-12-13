/*Создание индекса с возможностью полнотекстового поиска в русском тексте*/
DELETE otus-shop
PUT otus-shop
{
  "settings": {
    "analysis": {
      "filter": {
        "ru_stop": {
          "type": "stop",
          "stopwords": "_russian_"
        },
        "ru_stemmer": {
          "type": "stemmer",
          "language": "russian"
        },
        "en_stem": {
          "type": "stemmer",
          "language": "english"
        },
        "en_pos": {
          "type": "stemmer",
          "language": "possessive_english"
        },
        "ngram": {
          "type": "edge_ngram",
          "min_gram": 1,
          "max_gram": 20
        }
      },


      "analyzer": {
        "my_ru_stemmer": {
          "type": "custom",
          "tokenizer": "standard",
          "filter": ["lowercase", "ru_stop", "ru_stemmer", "en_pos"]
        },
        "my_ngram_index": {
          "type": "custom",
          "tokenizer": "standard",
          "filter": ["lowercase", "ru_stop", "ngram"]
        },
        "my_ngram_search": {
          "type": "custom",
          "tokenizer": "standard",
          "filter": ["lowercase"]
        }
      }
    }
  },
  "mappings": {
      "properties": {
        "title": {
          "type": "text",
          "analyzer": "my_ru_stemmer"
        },
         "category": {
                  "type": "text",
                  "analyzer": "my_ru_stemmer"
                }
      }

  }
}
/*Запросы*/
GET /otus-shop/_search
{
    "query":
    {
        "match": {
        "category": "роман"
        }
    }
}

GET /otus-shop/_search
{
    "query": {
        "bool":
        {
            "must": [

              { "match": { "title": "рыцарь" } }
              ],
            "filter": [
            { "match": { "category": "Исторический" } },
            { "range": { "price": { "lte": 2500 } } },
            { "range": { "stock.stock": { "gt": 0 } } }
            ]
        }
    }
}

GET /otus-shop/_search
{
    "query": {
        "bool":
        {
            "must": [

              { "match": { "title":
                            {
                            "query": "рыцарь" ,
                            "fuzziness": "auto"
                            }
                        }
              },
              { "match": { "category": "Исторический роман" } }
              ],
            "filter": [

            { "range": { "price": { "lte": 2500 } } },
            { "range": { "stock.stock": { "gt": 0 } } }
            ]
        }
    }
}
/**/

GET /otus-shop/_search
{
    "query": {
        "bool":
        {
            "must": [

              { "match": { "title":
                            {
                            "query": "рыцорC" ,
                            "fuzziness": "auto"
                            }
                        }
              }


              ],
            "filter": [

              {
              "match_phrase": {
             "category": "Исторический роман"
             }
             },


            { "range": { "price": { "lte": 2500 } } },
            { "range": { "stock.stock": { "gt": 0 } } }
            ]
        }
    }
}








