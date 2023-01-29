# ДЗ Приложение верификации email

Для тестирования приложения достаточно отправить POST запрос вида:

    curl --location --request POST 'http://mysite.local' \
    --form 'email_list[]="test@bk.ru"' \
    --form 'email_list[]="23123.fdf@213dddd.ru"'