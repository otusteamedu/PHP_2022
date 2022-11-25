<?
//счетчик количества посещений
session_start();
$_SESSION['visit'] = !empty($_SESSION['visit']) ? (int)$_SESSION['visit'] + 1 : 1;

try {
    if (!isset($_POST['string']))
        throw new ErrorException('Parameter not defined');
    setResponse(checkBrackets($_POST['string']));
} catch (ErrorException $e) {
    setResponse(false, $e->getMessage());
}

/** Проверка правильности скобочной последовательности
 * @param string $string
 * @return bool
 */
function checkBrackets(string $string): bool
{
    if (empty($string))
        return false;
    $arBrackets = (mb_str_split(preg_replace('/[^\(\)]/i', '', $string)));
    $counter = 0;
    foreach ($arBrackets as $bracket) {
        if ($bracket === '(')
            $counter++;
        else
            $counter--;
        if ($counter < 0) return false;
    }
    return $counter === 0;
}

/** Формирование ответа
 * @param bool $status
 * @param string $msg
 * @return void
 */
function setResponse(bool $status, string $msg = ''): void
{
    header($status ? "HTTP/1.1 200 OK" : "HTTP/1.1 400 Bad Request");
    echo $msg ?: ($status ? 'Successful check' : 'Unsuccessful check');
    echo "\r\n";
    echo "Сервер: " . $_SERVER['HOSTNAME'] . "\r\n";
    echo "Сессия: " . session_id() . "\r\n";
    echo "Посещение: " . $_SESSION['visit'] . "\r\n";
}
