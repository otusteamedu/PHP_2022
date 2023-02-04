<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event</title>
</head>
<body>

<style>
    body {
        background-color: aliceblue;
    }
    main {
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
    }
    form {
        border: 2px solid gray;
        padding: 50px;
        background-color: beige;
        margin-bottom: 25px;
    }
</style>

<main>
    <form action="/event/create/" method="post">
        <h2>Create event</h2>

        <p><i>Enter each param on a new line:</i></p>
        <p><textarea name="param" id="param" cols="30" rows="10" placeholder="param1=1"></textarea></p>

        <p><i><b>Score:</b></i></p>
        <p><input type="text" name="score" id="score" placeholder="1000"></p>

        <button type="submit">Submit</button>
    </form>

    <form action="/event/update/" method="post">
        <h2>Update event</h2>

        <p><i>Enter <b>id</b> for update:</i></p>
        <p><input type="text" name="id" id="id" placeholder="1"></p>

        <p><i>Enter each param on a new line:</i></p>
        <p><textarea name="param" id="param" cols="30" rows="10" placeholder="param1=1"></textarea></p>

        <p><i><b>Score:</b></i></p>
        <p><input type="text" name="score" id="score" placeholder="1000"></p>

        <button type="submit">Submit</button>
    </form>

    <form action="/event/read/" method="post">
        <h2>Read event</h2>

        <p><i>Enter <b>id</b> for read:</i></p>
        <p><input type="text" name="id" id="id" placeholder="1"></p>

        <button type="submit">Submit</button>
    </form>

    <form action="/event/delete/" method="post">
        <h2>Delete event</h2>
        
        <p><input type="checkbox" name="clear" id="clear" value="1"><i>Clear all events?</i></p>

        <p><i><small>(If not clear all events)</small><br>Enter <b>id</b> for delete:</i></p>
        <p><input type="text" name="id" id="id" placeholder="1"></p>

        <button type="submit">Submit</button>
    </form>

    <form action="/event/search/" method="post">
        <h2>Search priority event</h2>

        <p><i>Enter each param on a new line:</i></p>
        <p><textarea name="param" id="param" cols="30" rows="10" placeholder="param1=1"></textarea></p>

        <button type="submit">Submit</button>
    </form>

</main>

</body>
</html>