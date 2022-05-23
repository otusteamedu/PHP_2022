# PHP_2022

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

Разрабатываем часть интернет-ресторана. Продаёт он фаст-фуд.

1. Абстрактная фабрика будет отвечать за генерацию базового продукта-прототипа: бургер, сэндвич или хот-дог
2. При готовке каждого типа продукта используется Прототип, а Декоратор будет добавлять составляющие к базовому продукту либо по рецепту, либо по пожеланию клиента (салат, лук, перец и т.д.)
3. Итератор проходится по каждому элементу продукта и валидирует его качество.
4. Стратегия будет отвечать за то, что нужно приготовить.
5. Все сущности должны по максимуму генерироваться через DI.