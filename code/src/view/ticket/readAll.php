<style>
    .tickets {
        display: flex;
        justify-content: space-evenly;
        flex-wrap: wrap;
    }
    .ticket {
        border: 2px solid gray;
        padding: 25px;
    }
</style>

<hr>

<h1>Search result:</h1>

<div class="tickets">
    <?php foreach ($result as $res) { ?>
        <div class="ticket">
            <p>Ticket ID: <?= $res["id"] ?></p>
            <p>Price: <?= $res["price"] ?></p>
            <p>Seat number: <?= $res["seat"] ?></p>
            <p>Session ID: <?= $res["sessionId"] ?></p>
        </div>
    <?php } ?>
</div>
