<?php

/**
Задача:
- поправить скрипт, который должен обработать 100.000 строчек чего-либо,
  но из-за ограничения памяти падает на 1000 строчек
  (подсказка: использовать memory_limit для ограничения потребления памяти скриптом)
- то есть нужно обрабатывать корректно данные произвольного объема
- посмотреть, как происходит потребление и утечка памяти в скриптах
- в качестве пимера: будем обрабатывать большой CSV-файл,
  в котором нам нужно прочитать данные из одного столбца и записать их в новый файл;
- для оптиммального использования памяти исходный файл будем читать построчно (вопспольуемся Итератором)
 */

/**
 * Используем Паттерн Итератор
 *
 * Пример: Так как PHP уже имеет встроенный интерфейс Итератора, который
 * предоставляет удобную интеграцию с циклами foreach, очень легко создать
 * собственные итераторы для обхода практически любой мыслимой структуры данных.
 *
 * Этот пример паттерна Итератор предоставляет лёгкий доступ к CSV-файлам.
 */

/**
 * Итератор CSV-файлов.
 */
class CsvIterator implements Iterator
{
    const ROW_SIZE = 4096;

    /**
     * Указатель на CSV-файл.
     * @var resource
     */
    protected $filePointer = null;

    /**
     * Текущий элемент, который возвращается на каждой итерации.
     * @var array
     */
    protected $currentElement = null;

    /**
     * Счётчик строк.
     *
     * @var int
     */
    protected $rowCounter = null;

    /**
     * Разделитель для CSV-файла.
     *
     * @var string
     */
    protected $delimiter = null;

    /**
     * Конструктор пытается открыть CSV-файл. Он выдаёт исключение при ошибке.
     * @param string $file CSV-файл.
     * @param string $delimiter Разделитель.
     * @throws Exception
     */
    public function __construct($file, $delimiter = ',')
    {
        try {
            $this->filePointer = fopen($file, 'rb');
            $this->delimiter = $delimiter;
        } catch (Exception $e) {
            throw new Exception('The file "' . $file . '" cannot be read.');
        }
    }

    /**
     * Этот метод сбрасывает указатель файла.
     */
    public function rewind(): void
    {
        $this->rowCounter = 0;
        rewind($this->filePointer);
    }

    /**
     * Этот метод возвращает текущую CSV-строку в виде двумерного массива.
     * Возвращается текущая CSV-строка в виде двумерного массива.
     * @return array
     */
    public function current() : array
    {
        $this->currentElement = fgetcsv($this->filePointer, self::ROW_SIZE, $this->delimiter);
        $this->rowCounter++;
        //var_dump($this->currentElement); die();
        return (is_array($this->currentElement) ? $this->currentElement : []);
    }

    /**
     * Этот метод возвращает номер текущей строки.
     * @return int Номер текущей строки.
     */
    public function key(): int
    {
        return $this->rowCounter;
    }

    /**
     * Этот метод проверяет, достигнут ли конец файла.
     * @return bool Возвращает true при достижении EOF, в ином случае false.
     */
    public function next(): bool
    {
        if (is_resource($this->filePointer)) {
            return !feof($this->filePointer);
        }

        return false;
    }

    /**
     * Этот метод проверяет, является ли следующая строка допустимой.
     * @return bool Если следующая строка является допустимой.
     */
    public function valid(): bool
    {
        if (!$this->next()) {
            if (is_resource($this->filePointer)) {
                fclose($this->filePointer);
            }

            return false;
        }

        return true;
    }
}

class CsvImport {
    /**
     * Save data from CSV
     * @param $fileFrom
     * @param $fileTo
     * @param int column num to read
     * @return int readed lines count
     */
    public function saveData(string $fileFrom, string $fileTo, int $num) : int
    {
        $cnt = 0;

        try {
            // delete prev result
            @unlink($fileTo);
            // file to read
            $csv    = new CsvIterator($fileFrom, ";");
            // file to write
            $handle = fopen($fileTo, "a");
            // iterate through csv lines
            foreach ($csv as $row) {
                if(isset($row[$num])) {
                    $cell = $row[$num];
                    fwrite($handle, $cell . "\n");
                    $cnt++;
                }
            }
            fclose($handle);
        } catch(Exception $e) {
            return 0;
        }

        return $cnt;
    }
}

/**
 * Клиентский код.
 */

echo "[ Current memory limit: " . ini_get("memory_limit") . " ] \n";
echo "[ Set new memory limit ... ]\n";
ini_set("memory_limit", "1M");
echo "[ New memory limit: " . ini_get("memory_limit") . " ] \n";

echo "[ START IMPORT ... ]\n";
$csv = new CsvImport();
$cnt = $csv->saveData('import.csv', 'result.csv', 1);
echo "[ Lines written: $cnt ]\n";
echo "[ DONE ]\n";

