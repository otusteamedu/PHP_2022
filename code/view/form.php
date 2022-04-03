<form action="" method="post">
    <input type="hidden" name="youtube[action]" value="add_channel">

    <div style="display: flex;">
        <label for="add_channel">Add a youtube channel</label>
        <input type="text" id="add_channel" name="youtube[name]" style="margin-left: 10px; width: 250px;">
        <button type="submit" style="margin-left: 10px">Add</button>
    </div>
</form>

<hr>

<form action="" method="post">
    <input type="hidden" name="youtube[action]" value="get_channels">

    <div style="display: flex;">
        <label for="get_channels">List of channels with likes/dislikes</label>
        <button id="get_channels" type="submit" style="margin-left: 10px">Show</button>
    </div>
</form>

<hr>

<form action="" method="post">
    <input type="hidden" name="youtube[action]" value="get_top_rated_channels">

    <div style="display: flex;">
        <label for="get_top_rated_channels">Get 3 top-rated channels</label>
        <button id="get_top_rated_channels" type="submit" style="margin-left: 10px">Show</button>
    </div>
</form>
