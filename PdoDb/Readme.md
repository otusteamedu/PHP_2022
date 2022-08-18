# BdoDB

PHP Pdo singleton class.

INSERT, UPDATE, SELECT etc. to/from MYSQL DataBase using PHP.


## Installation

run

`composer require sbbs8668/pdo-db`


## Usage

Add `require_once __DIR__ . '/vendor/autoload.php';` to the `php` file.


Set up the DB connection parameters with the `.env` file.


Example of a `.env` file:

`DB_HOST=localhost`

`DB_PORT=3306`

`DB_NAME=db_name`

`DB_USER=db_user`

`DB_PSWD=db_password`


Then use it like this:

`$db_config = parse_ini_file('.env');`

`$db = PdoDb::getInstance($db_config);`


## Examples how to use:

`index.php`


## License
[MIT](https://choosealicense.com/licenses/mit/)
