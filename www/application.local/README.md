#Добавление событий:
> POST http://application.local?route=event/add

в body запроса должен быть параметр events, внутри которого json с массивом эвентов

#Поиск самого приоритетного события

> POST http://application.local?route=event/find

в body запроса должен быть параметр conditions, внутри которого json с массивом условий

# Удаление всех событий
> POST http://application.local?route=event/delete_all

# Переключение хранилищ здесь
> app\models\Event\EventModel->setStorageAdapter()
