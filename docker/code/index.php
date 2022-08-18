<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body style="padding:0 20%">
<form action="#" style="display: flex; flex-direction: column; padding: 10px">
    <h3>session_id: <?=session_id()?></h3>
    <input type="text" name="http" style="margin: 6px">
    <button style='margin: 6px'>Generate())</button>
    <input type="submit" value="Send" style='margin: 6px'>
</form>
<div class="res" style="border:1px solid gray;margin:20px; padding:20px"></div>
<script>
    const fetchApi = async (string) => await fetch(
      './api.php', {method: 'POST', body: JSON.stringify({string})}
    );

    document.querySelector('button').addEventListener('click', (ev) => {
        ev.preventDefault();
        const left = '(';
        const right = ')';
        const input = document.querySelector('input[name="http"]');
        input.value = '';
        for (let i = Math.floor(Math.random() * 30 + 1); i >= 0; i--) {
          input.value += Math.floor(Math.random() * 2) ? left : right;
        }
    });

    const fetchHandler = (ev) => {
        ev.preventDefault();
        const button = ev.currentTarget;
        button.removeEventListener('click', fetchHandler);
        fetchApi(document.querySelector('input[name="http"]').value)
          .then( async (res) => {
            const resDiv = document.querySelector('.res');
            if (res.status === 200) {
              res = await res.json();
              resDiv.innerHTML = `<div>Status: ${200}</div><div>SessionID: ${res}</div>`;
            } else {
              resDiv.innerHTML = `<div>Status: ${res.status}</div><div>Response: ${res.statusText}</div>`;
            }
            button.addEventListener('click', fetchHandler);
          })
    };
    document.querySelector('input[value="Send"]').addEventListener('click', fetchHandler);
</script>
</body>
</html>




