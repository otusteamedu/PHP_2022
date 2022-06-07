# PHP_2022

**Create**
http://otus.local/v1/report/create?name=test&url=http://test.ua

Params:
{"name": "test", "url": "http://test.ua"}

**Update**
http://otus.local/v1/report/update/<id>

Params:
{"name": "test", "url": "http://test.ua"}


**Delete**
http://otus.local/v1/report/delete/<id>

Response get header with x-id=<id>