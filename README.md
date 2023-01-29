# Elasticsearch PHP in Docker

## Setup

### Run containers (console)
```
docker-compose up -d --build
```

### Create index with mapping and analyzer (e.g. Postman)
```
PUT localhost:9200/otus-shop
```

```json
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
                }
            },
            "analyzer": {
                "my_russian": {
                    "tokenizer": "standard",
                    "filter": [
                        "lowercase",
                        "ru_stop",
                        "ru_stemmer"
                    ]
                }
            }
        }
    },
    "mappings": {
        "properties": {
            "category": {
                "type": "keyword"
            },
            "price": {
                "type": "integer"
            },
            "sku": {
                "type": "keyword"
            },
            "stock": {
                "type": "nested",
                "properties": {
                    "shop": {
                        "type": "keyword"
                    },
                    "stock": {
                        "type": "short"
                    }
                }
            },
            "title": {
                "type": "text",
                "analyzer": "my_russian"
            }
        }
    }
}
```

### Exec PHP container (console)
```
docker exec -it php bash
```

### Import bookstore data (console)
```
curl \
    --location \
    --insecure \
    --request POST 'http://elastic:9200/_bulk' \
    --header 'Content-type: application/json' \
    --data-binary "@bulk.json"
```

## Usage

### Bookstore search
```
php app.php [--option.name "option.value"]
```

### Possible option.name values:
- title - *string*
- stock.stock - *string*
- price - *string*
- category - *string*
- limit - *integer*

## Example

### Search by all params

    php app.php --title рыцори --stock.stock 1 --price "..2000" --category "Исторический роман" --limit 29

### Special price and stock usage *(Price example)*


#### If you want to search by more than:

    php app.php --price value

#### If you want to search by less than:

    php app.php --price ..value

#### You can specify price:

    php app.php --price minval..maxval