# PHP_2022
### HW_6
***
####Вызов

```
$validator = new Email\Validator($filePath, $checkMx);
$validator->validateFile();
```

* **$filePath** - путь к файлу с Email
* **$checkMx** - флаг дополнительной проверки домена по MX записи, по умолчанию false - без проверки по MX


* **Validator->validEmail** - массив Email, прошедших проверку