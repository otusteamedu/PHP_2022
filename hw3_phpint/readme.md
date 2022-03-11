# What is it
Memory usage limit examples written on PHP

# Task source
Otus PHP Pro course: https://fas.st/wRyRs  
Lesson 3: PHP Internal structure

# Task description
Read data from BIG file import.csv
Get 1-st column data from here
Output all data from this column to result.csv
(*) we have memory limitation: only 1Mb for script execution is allowed

# Author
Mikhail Ikonnikov <mishaikon@gmail.com>

# How to run

## Create csv file
php run.php

## Run script with bad memory usage
php memory_limit_error.php

## Run script with food memory usage
php memory_limit_ok.php

## Usage example
> php run.php
[ START CREATING CSV ... ]
[ File with 100000 lines created ]
[ DONE ]

> php memory_limit_error.php
[ Current memory limit: 128M ]
[ Set new memory limit ... ]
[ New memory limit: 1M ]
[ START IMPORT ... ]
PHP Fatal error:  Allowed memory size of 2097152 bytes exhausted (tried to allocate 3301488 bytes) in E:\OpenServer
\OSPanel\domains\codexamps\src\mishaikon\phpexp\Courses\otus_php_pro\lesson3_phpint\memory_limit_error.php on line
27

> php memory_limit_ok.php
[ Current memory limit: 128M ]
[ Set new memory limit ... ]
[ New memory limit: 1M ]
[ START IMPORT ... ]
[ Lines written: 100000 ]
[ DONE ]
