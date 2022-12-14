<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <style>
        body {text-align: center;}
        h1 {margin-top: 20%;}
    </style>
</head>
<body>
<h1>Все игроки</h1>

  <table border="1">
  <thead>
  <tr>
    <th>ID</th>
    <th>Имя</th>
    <th>Фамилия</th>
    <th>Запрос на список компаний</th>
    </tr>
  </thead>
  <tbody>
<?php
    foreach ($massif_users as $users) {
        echo "<tr>
                <th>{$users['user_id']}</th>  
                <th>{$users['user_name']}</th>
                <th>{$users['user_surname']}</th>
                <th>
                    <a href=/userviewer/userCompanies?user_id={$users['user_id']}>
                        Ссылка
                    </a>
                </th>
             </tr> ";
    }
?>

</body>
</html>
