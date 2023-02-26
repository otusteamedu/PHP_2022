<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Заказать банковскую выписку</title>
</head>
<body>
    <form id="bank_statement" action="/api/bank/statement" method="POST">
        <label>
            E-mail
            <input type="text" name="email">
        </label>
        <label>
            С
            <input type="date" name="date_from" value="<?=date('Y-m-d')?>">
        </label>
        <label>
            по
            <input type="date" name="date_to" value="<?=date('Y-m-d')?>">
        </label>
        <input type="submit" value="Заказать">
        <p class="result"></p>
    </form>

    <style>
        label {
            display: block;
            margin-bottom: 10px;
        }
    </style>

    <script>
        const form = document.querySelector('#bank_statement');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const params = {
                email: form.querySelector('input[name=email]').value,
                date_from: form.querySelector('input[name=date_from]').value,
                date_to: form.querySelector('input[name=date_to]').value
            };

            const response = await fetch(form.getAttribute('action'), {
                method: form.getAttribute('method'),
                body: JSON.stringify(params),
                headers: {'Content-Type': 'application/json; charset=utf-8'}
            })

            console.log(response)

            const result = await response.json();

            form.querySelector('.result').innerText = result.message;
        })
    </script>
</body>
</html>