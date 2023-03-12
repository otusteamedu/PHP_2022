<div class="back-url">
    <a href="/">&larr; на главную</a>
</div>
<div class="form-request-wrapper">
<h3>Отправить заявку</h3>
<form class="request-form" method="post">
    <input type="text" value="" name="name" placeholder="Введите ФИО" required/>
    <input type="email" value="" name="email" placeholder="Введите Email" required/>
    <input type="date" value="" name="date" placeholder="Введите дату" required/>
    <input type="submit" value="Отправить" />
</form>
</div>
<div class="form-feedback-wrapper<?=isset($content['feedbackStatus']) ? ($content['feedbackStatus'] === true ? '-success' : '-error') : ''?>">
    <?=$content['feedbackString'] ?? '';?>
</div>

