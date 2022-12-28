<?php

declare(strict_types=1);

namespace Ppro\Hw13\Repositories;

use Ppro\Hw13\Data\EventDTO;
use Ppro\Hw13\Data\ParamsDTO;
use Ppro\Hw13\Register;
use Redis;

class RedisRepository implements RepositoryInterface
{
    const KEY_SEPARATOR = ":";
    const LINK_EVENTS_ID_SEPARATOR = ":";
    const PARAMS_HASH_PREFIX = 'params';
    const EVENTS_HASH_PREFIX = 'events';
    const EVENT_LIST_KEY = 'eventList'; //список - справочник всех событий
    const PARAM_LIST_KEY = 'paramList'; //список - справочник всех параметров
    const EVENT_TEMP_SORT_SET_PREFIX = 'tempEventList';

    private Redis $redis;
    private string $tempEventSetKey;

    public function __construct()
    {
        $reg = Register::instance();
        $this->redis = new Redis();
        try {
            $this->redis->connect($reg->getValue('host'), (int)$reg->getValue('port'), 10);
        } catch (Exception $e) {
            throw new \Exception("Cannot connect to redis server:" . $e->getMessage());
        }
    }

    public function addEvent(EventDTO $event): void
    {
        //получаем уникальный ключ для события с помощью списка
        $eventKey = $this->getEventKey($event);

        //Пишем в хеш всю информацию по событию: ключ -  префикс:{ID в списке событий}:{количество привязанных параметров}
        $this->fillEventInfoHash($eventKey, $event);

        //Заполняем хеш, содержащий привязку событий к параметрам: params:paramName = [paramValue => список ID привязанных событий]
        $this->linkEventToParamHash($event, $eventKey);
    }

    public function findEvent(ParamsDTO $params): array
    {
        //получаем по каждому из параметров массив привязанных к параметру событий
        $arLinkEvents = $this->findLinkEvents($params);

        //подсчитываем кол-во всех привязанных к событию параметров
        if (!empty($arLinkEvents)) {
            $arLinkEvents = array_count_values($arLinkEvents);
        }

        //ищем по событиям элементы с указанным ID и корректным кол-вом совпадающих параметров, записываем их в упорядоченное множество
        $this->findMatchEvents($arLinkEvents);

        return $this->findEventByPriority();
    }

    public function removeEvents()
    {
        $keys1 = $this->redis->keys(self::PARAMS_HASH_PREFIX . self::KEY_SEPARATOR . '*');
        $this->redis->del($keys1);
        $keys2 = $this->redis->keys(self::EVENTS_HASH_PREFIX . self::KEY_SEPARATOR . '*');
        $this->redis->del($keys2);
        $keys3 = $this->redis->keys(self::EVENT_TEMP_SORT_SET_PREFIX . self::KEY_SEPARATOR . '*');
        $this->redis->del($keys3);
        $this->redis->del(self::EVENT_LIST_KEY);
        $this->redis->del(self::PARAM_LIST_KEY);
    }

    /** Выбирает необходимое количество событий согласно приоритету
     * @param int $eventCount
     * @return array
     * @throws \RedisException
     */
    private function findEventByPriority(int $eventCount = 1): array
    {
        $events = $this->redis->zRangeByScore($this->getEventPrioritySetKey(), '-inf', '+inf', ['withscores' => FALSE, 'limit' => [0, $eventCount]]);
        $this->redis->del($this->tempEventSetKey);
        return $events;
    }

    /** Получает id события из справочника
     * @param EventDTO $event
     * @return int|mixed|Redis
     * @throws \RedisException
     */
    private function getEventKey(EventDTO $event): mixed
    {
        $eventKey = $this->redis->rawCommand('lpos', self::EVENT_LIST_KEY, $event->getname());
        if ($eventKey === false) {
            $this->redis->rPush(
              self::EVENT_LIST_KEY,
              $event->getname()
            );
            $eventKey = $this->redis->rawCommand('lpos', self::EVENT_LIST_KEY, $event->getname());
        }
        if (!isset($eventKey) || $eventKey === false)
            throw new \Exception('Add event error');
        return $eventKey;
    }

    /** Получает id параметра из справочника
     * @param string $paramName
     * @return mixed
     * @throws \RedisException
     */
    private function getParamKey(string $paramName): mixed
    {
        $paramKey = $this->redis->rawCommand('lpos', self::PARAM_LIST_KEY, $paramName);
        if ($paramKey === false) {
            $this->redis->rPush(
              self::PARAM_LIST_KEY,
              $paramName
            );
            $paramKey = $this->redis->rawCommand('lpos', self::PARAM_LIST_KEY, $paramName);
        }
        if (!isset($paramKey) || $paramKey === false)
            throw new \Exception('Add param error');
        return $paramKey;
    }

    /** Заполняет хеш с полным описанием события
     * @param mixed $eventKey
     * @param EventDTO $event
     * @return string
     * @throws \RedisException
     */
    private function fillEventInfoHash(mixed $eventKey, EventDTO $event): void
    {
        $hashKey = self::EVENTS_HASH_PREFIX . self::KEY_SEPARATOR . $eventKey . self::KEY_SEPARATOR . count($event->getParams());
        $this->redis->hSet($hashKey, 'key', $eventKey);
        $this->redis->hSet($hashKey, 'name', $event->getName());
        $this->redis->hSet($hashKey, 'priority', (string)$event->getPriority());
        $this->redis->hSet($hashKey, 'params', serialize($event->getParams()));
    }

    /** Привязывает событие к хешу параметра
     * @param EventDTO $event
     * @param mixed $eventKey
     * @return void
     * @throws \RedisException
     */
    private function linkEventToParamHash(EventDTO $event, mixed $eventKey): void
    {
        foreach ($event->getParams() as $param) {
            $paramId = $this->getParamKey($param[0]);
            $hashKey = self::PARAMS_HASH_PREFIX . self::KEY_SEPARATOR . $paramId;
            $linkEventsId = $this->redis->hGet($hashKey, $param[1]);
            $linkEventsId = $linkEventsId ? $linkEventsId . self::LINK_EVENTS_ID_SEPARATOR . $eventKey : (string)$eventKey;
            $this->redis->hSet($hashKey, $param[1], $linkEventsId);
        }
    }

    /** Находит события, приивязанные к искомым параметрам
     * @param ParamsDTO $params
     * @param mixed $arLinkEvents
     * @return array
     * @throws \RedisException
     */
    private function findLinkEvents(ParamsDTO $params): array
    {
        $arLinkEvents = [];
        foreach ($params->getParams() as $param) {
            $paramKey = $this->getParamKey($param[0]);
            $hashKey = self::PARAMS_HASH_PREFIX . self::KEY_SEPARATOR . $paramKey;
            $linkEventsString = $this->redis->hGet($hashKey, $param[1]);
            if ($linkEventsString !== false)
                $linkEventsArray = explode(self::LINK_EVENTS_ID_SEPARATOR, $linkEventsString);
            if (!empty($linkEventsArray))
                $arLinkEvents = array_merge($arLinkEvents, $linkEventsArray);
        }
        return $arLinkEvents;
    }

    /** Находит события, удовлетворяющие всем параметрам
     * @param array $arLinkEvents
     * @return void
     * @throws \RedisException
     */
    private function findMatchEvents(array $arLinkEvents): void
    {
        $setKey = $this->getEventPrioritySetKey();
        foreach ($arLinkEvents as $linkEventId => $paramCount) {
            $hashKey = self::EVENTS_HASH_PREFIX . self::KEY_SEPARATOR . $linkEventId . self::KEY_SEPARATOR . $paramCount;
            if ($this->redis->exists($hashKey)) {
                $name = $this->redis->hGet($hashKey, 'name');
                $priority = $this->redis->hGet($hashKey, 'priority');
                if (!empty($name) && !empty($priority))
                    $this->redis->zAdd(
                      $setKey,
                      $priority,
                      $name
                    );
            }
        }
    }

    /** генерирует ключ для упорядоченного множества выбранных событий
     * @return string
     * @throws \RedisException
     */
    private function getEventPrioritySetKey(): string
    {
        if (empty($this->tempEventSetKey))
            do {
                $this->tempEventSetKey = self::EVENT_TEMP_SORT_SET_PREFIX . self::KEY_SEPARATOR . rand();
            } while ($this->redis->exists($this->tempEventSetKey));
        return $this->tempEventSetKey;
    }
}