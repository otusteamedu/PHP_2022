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
<h1>Все компании игрока</h1>

  <table border="1">
  <thead>
  <tr>
    <th>Компании:</th>
   </tr>
  </thead>
  <tbody>
<?php
    foreach ($array_companies as $companies) {
        echo "<tr>
        <th>{$companies['company_name']}</th>  
        </tr> ";
    }
?>
<p><a href='/index/index'>На главную</a></p>
</body>
</html>
