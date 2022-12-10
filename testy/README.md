# PHP, Nginx, Elasticsearch and Docker


## Description
This is console app for books searching via Elasticsearch

## Installation

- Set the vm.max_map_count setting in the current context and the /etc/sysctl.conf file.

``` sudo sysctl -w vm.max_map_count=262144```
- Run containers

``` docker-compose up -d --build --remove-orphans```
- Change permissions to avoid problems

``` chmod +xw src/```
- Go into php container
``` make run```

- Install dependencies
``` composer install```

- Use Postman collection json file for next requests /dump/otus-Elasticsearch-bookshop.postman_collection.json

- Use Postman to add new index ```http://localhost/otus-shop```
- Use Postman request ```http://localhost/otus-shop/_mapping/``` to create mapping from file /dump/mapping.json.
- Use Postman request ```http://localhost/otus-shop/books/_bulk``` to download dump from file /dump/books.json
- Test if it works in your browser: ```htttp://localhost:8080```


## Using


- Go into php container
``` make run```

Inside of existing container run app 
- run app
```php index.php [--longoption="..."]``` or
```php index.php [-shortoption...]```

##Options

Use short or long options to filter search results 

- 't' or 'title',
- 'i' or 'sku',
- 'c' or 'category',
- 'l' or 'low_price',
- 'h' or 'high_price',
- 'g' or 'limit',
- 'f' or 'fuzziness',
- 's' or 'stock'