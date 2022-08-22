<?
echo 'Lesson_1';
echo '<br>';

try {
    $mysqli = new mysqli(getenv('BASE_TYPE'), getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), getenv('MYSQL_DATABASE'));
    if ($mysqli->connect_errno)
        throw new Exception($mysqli->connect_error);
    else {
        printf("Connection success \n");
        $mysqli->close();
    }

} catch (Exception $e) {
    printf("Connection error: \n".$e->getMessage());
}
