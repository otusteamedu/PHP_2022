<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Бургерная</title>
</head>
<body>
<div>
    <h3>
        {{ $message }}
    </h3>
    <ul>

        <li><a href="{{route('hotdog', ['sauce' => 'ketchup'])}}">Хот-дог с кетчупом</a></li>
        <li><a href="{{route('hotdog', ['sauce' => 'mustard'])}}">Хот-дог с горчицей</a></li>
    </ul>
</div>
@isset($burger)

    <div>
        <h4>{{ $burger->getTitle() }}</h4>
        <p>Состав: {{ $burger->getComposition() }}</p>
    </div>
@endisset
</body>
</html>
