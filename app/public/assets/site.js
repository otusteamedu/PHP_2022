function check() {
    let string = document.getElementById('str-input').value;

    fetch('/', {
            method: 'POST',
            body: JSON.stringify({
                string: string
            })
        })
        .then(result => result.json())
        .then(json => resultCallback(json, string))
}

function resultCallback(res, string) {
    const successOutline = 'border-success',
        errorOutline = 'border-danger';

    let success = res.code === 200,
        card = document.getElementById('check-result'),
        title = document.getElementById('check-result-title'),
        text = document.getElementById('check-result-text');

    console.log(res)
    card.removeAttribute('hidden');

    if (success) {
        if (card.classList.contains(errorOutline)) {
            card.classList.remove(errorOutline)
        }
        card.classList.add(successOutline)
        title.innerText = 'Проверка пройдена успешна!';
        text.innerText = 'В строке ' + string + ' скобки расположны корректно!';

    } else {
        if (card.classList.contains(successOutline)) {
            card.classList.remove(successOutline)
        }
        card.classList.add(errorOutline)
        title.innerText = 'Ошибка! ' + res.message;
        text.innerText = 'Содержимое запроса: "' + string + '". Проверьте правильность ввода!';
    }
}