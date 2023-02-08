<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket</title>
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
    <form action="/ticket/create/" method="post">
        <h2>Create ticket</h2>

        <p><i><b>Price:</b></i></p>
        <p><input type="text" name="price" id="price" placeholder="1000"></p>

        <p><i><b>Seat number:</b></i></p>
        <p><input type="text" name="seat" id="seat" placeholder="1"></p>

        <p><i><b>Session ID:</b></i></p>
        <p><input type="text" name="sessionId" id="sessionId" placeholder="1"></p>

        <button type="submit">Submit</button>
    </form>

    <form action="/ticket/update/" method="post">
        <h2>Update ticket</h2>
        <p><i>Enter <b>id</b> for update:</i></p>
        <p><input type="text" name="id" id="id" placeholder="1"></p>

        <p><i><b>Price:</b></i></p>
        <p><input type="text" name="price" id="price" placeholder="1000"></p>

        <p><i><b>Seat number:</b></i></p>
        <p><input type="text" name="seat" id="seat" placeholder="1"></p>

        <p><i><b>Session ID:</b></i></p>
        <p><input type="text" name="sessionId" id="sessionId" placeholder="1"></p>

        <button type="submit">Submit</button>
    </form>

    <form action="/ticket/read/" method="post">
        <h2>Find ticket</h2>

        <p>
            <label>
                <input type="checkbox" name="getAll" id="getAll" value="1">
                <i>Find all tickets?</i>
            </label>
        </p>

        <p><i>Enter <b>id</b> for read:</i></p>
        <p><input type="text" name="id" id="id" placeholder="1"></p>

        <button type="submit">Submit</button>
    </form>

    <form action="/ticket/delete/" method="post">
        <h2>Delete ticket</h2>

        <p>
            <label>
                <input type="checkbox" name="clear" id="clear" value="1">
                <i>Clear all tickets?</i>
            </label>
        </p>

        <p><i><small>(If not clear all events)</small><br>Enter <b>id</b> for delete:</i></p>
        <p><input type="text" name="id" id="id" placeholder="1"></p>

        <button type="submit">Submit</button>
    </form>

</main>
</body>
</html>