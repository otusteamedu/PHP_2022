<?php

echo "Hello, Otus!<br>".date("Y-m-d H:i:s")."<br><br>";

echo "Hostname " . $_SERVER['HOSTNAME'];

function bracketValidation($string)
{
    if(!$string) {
        http_response_code(400);
        return 'Строка пустая';
    }
    
    $counter = 0;
    
    $openBracket = ['('];
    $closedBracket = [')'];

    $length = strlen($string);

    for($i = 0; $i<$length; $i++)
    {
        $char = $string[$i];

        if(in_array($char, $openBracket))
        {
            $counter ++;
        }
        elseif(in_array($char, $closedBracket))
        {
            $counter --;
        }
    }

    if($counter != 0)
    {
        return 'Строка не валидна';
        http_response_code(400);
    }
    
    return 'Строка валидна';
}


if($_POST['string']){
   echo bracketValidation($_POST['string']);
}

