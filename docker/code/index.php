<?php
session_start();
?>
<!DOCTYPE html>
<html>
<body style="padding:0 20%">
<form action="#" style="display: flex; flex-direction: column; padding: 10px">
    <h3 style='margin: 0'>session_id: <?=session_id()?></h3>
    <h3 style='margin: 0'>host_name: <?=$_SERVER['HOSTNAME']?></h3>
    <input type="text" name="http" style="margin: 6px">
    <button style='margin: 6px'>Generate())</button>
    <input type="submit" value="Send" style='margin: 6px'>
</form>
<div class="res" style="border:1px solid gray;margin:20px; padding:20px"></div>
<script>
    const fetchApi = async (string) => await fetch(
      './BracketCountApi.php', {method: 'POST', body: JSON.stringify({string})}
    );

    document.querySelector('button').addEventListener('click', (ev) => {
        ev.preventDefault();
        const left = '(';
        const right = ')';
        const input = document.querySelector('input[name="http"]');
        input.value = '';
        for (let i = Math.floor(Math.random() * 30 + 1); i >= 0; i--) {
          input.value += Math.round(Math.random()) ? left : right;
        }
        if (input.value.length % 2) {
          input.value = input.value.substring(0, input.value.length - 1);
        }
    });

    const fetchHandler = (ev) => {
        ev.preventDefault();
        const button = ev.currentTarget;
        const input = document.querySelector('input[name="http"]');
        if (!input.value) {
          return;
        }
        button.removeEventListener('click', fetchHandler);
        fetchApi(input.value)
          .then( async (res) => {
            const resDiv = document.querySelector('.res');
            if (res.status === 200) {
              const text = await res.json();
              resDiv.innerHTML = `<div style='font-weight: 700'>Status: ${200}</div><div style='font-weight: 700'>SessionID: ${text[0]}</div><div style='font-weight: 700'>HostName: ${text[1]}</div>`;
            } else {
              resDiv.innerHTML = `<div style='font-weight: 700'>Status: ${res.status}</div><div style='font-weight: 700'>Response: ${res.statusText}</div>`;
            }

            res.headers.forEach((value, title) => {
              resDiv.innerHTML += `<div>${title}: ${value}</div>`;
            });

            button.addEventListener('click', fetchHandler);
          })
    };
    document.querySelector('input[value="Send"]').addEventListener('click', fetchHandler);
</script>
</body>
</html>




