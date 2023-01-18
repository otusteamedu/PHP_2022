# Курс OTUS PHP_2022, ДЗ к Уроку №14: "Паттерны проектирования"

## Задача

### Цель
Набор задач на реализацию изученных паттернов. 
Требуется решить минимум 5 задач.

### Описание/пошаговая инструкция выполнения домашнего задания
Выберите 5 из 12 паттернов:
- Абстрактная фабрика
- Адаптер 
- Декоратор
- Инверсия зависимости 
- Фабричный метод 
- Итератор 
- Маппер 
- Наблюдатель 
- Прокси 
- Прототип 
- Стратегия
- Посетитель
- Запросите задачи у преподавателя
- Реализуйте паттерн на базе предложенного кода.

## Решение
Мы реализуем следующие **6** паттернов (по 2 паттерна кадого из 3х типов), на примере решения реальных задач:

Разрабатываем прототип работы кухни фастфуд-ресторана.

Будем использовать следюущие паттерны: 
1. **Абстрактная фабрика** ~ готовит блюдо 
Будет отвечать за генерацию базового продукта-прототипа: бургер, сэндвич или хот-дог 
2. **Декоратор** ~ добавляет ингриденты к блюду
при готовке каждого типа продукта будет добавлять составляющие 
к базовому продукту либо по рецепту, либо по пожеланию клиента 
(салат, лук, перец и т.д.)
3. **Наблюдатель** ~ наблюдает за процессом и делает оповещения 
Подписывается на статус приготовления и отправляет оповещения о том, 
что изменился статус приготовления продукта.
4. **Прокси** ~ проверяет продукт на соответствие стандарту 
Используется для навешивание ДО и ПОСЛЕ событий на процесс готовки. 
Например, если бургер не соответствует стандарту, ПОСЛЕ событие утилизирует его.
5. **Стратегия** ~ решает, что будет приготовлено 
будет отвечать за то, что нужно приготовить.

(*) Все сущности должны по максимуму генерироваться через DI (~ Dependency Injection).

### Деплоймент / запуск проекта
```
# make checkout
git clone https://github.com/otusteamedu/PHP_2022.git
cd PHP2022
git checkout MIkonnikov_hw14

# setup composer libs
cd code 
composer install && composer update

# run docker
cd ../
docker-compose build
docker-compose up -d

# go into container
docker exec -it app bash

# run App
php App.php Cook dish=Sandwich
```

### Что/как можно приготовить?

Пример запуска:
```
php App.php Cook dish=HotDog ingredient=Pepper ingredient=Onion
```

**Параметр dish**: доступные блюда см. в ``code/src/Application/Factory/хххFactory.php``:  
- Burger
- HotDog
- Sandwich

**Параметр ingredient**: доступные ингридиенты: ```/code/src/Domain/Decorator/xxx.php```
- Onion
- Pepper
- Salad

### Пример запуска
**Пример №1**
```
php App.php Cook dish=Sandwich

PreCookEventListener, event: PreCookEvent
PreCookEventListener2, event: PreCookEvent
Состояние: Новый Составной сэндвич
Наблюдатель: SandwichObserver, Состояние: Добавляем ингридиенты в Составной сэндвич
Состояние: Добавляем ингридиенты в Составной сэндвич
Наблюдатель: SandwichObserver, Состояние: Составной сэндвич готов
Состояние: Составной сэндвич готов
PostCookEventListener, event: PostCookEvent

Стоимость Составной сэндвич: 250
```

**Пример №2**
```
php App.php Cook dish=HotDog ingredient=Pepper ingredient=Onion

Прокси: Начинаем готовить Составной хотдог
PreCookEventListener, event: PreCookEvent                               
PreCookEventListener2, event: PreCookEvent                              
Состояние: Новый Составной хотдог                                       
Наблюдатель: HotDogObserver, Состояние: Варим сосиску в Составной хотдог
Состояние: Варим сосиску в Составной хотдог                             
Наблюдатель: HotDogObserver, Состояние: Добавляем соусы в Составной хотдог
Состояние: Добавляем соусы в Составной хотдог
Наблюдатель: HotDogObserver, Состояние: Режим булочку в Составной хотдог
Состояние: Режим булочку в Составной хотдог
Наблюдатель: HotDogObserver, Состояние: Добавляем ингридиенты в Составной хотдог
Состояние: Добавляем ингридиенты в Составной хотдог
Наблюдатель: HotDogObserver, Состояние: Составной хотдог готов
Состояние: Составной хотдог готов
PostCookEventListener, event: PostCookEvent

Стоимость Составной хотдог Перец Лук: 185
```

