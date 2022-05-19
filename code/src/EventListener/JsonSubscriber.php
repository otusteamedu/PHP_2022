<?php

declare(strict_types=1);

namespace App\EventListener;


use App\Entity\JsonEvent;
use App\Repository\RedisRepository;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;

/**
 * JsonSubscriber
 */
class JsonSubscriber implements EventSubscriberInterface
{

    public RedisRepository $redis;

    public function __construct()
    {
        $this->redis = new RedisRepository();
    }

    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    /**
     * @return array|string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof JsonEvent) {
            return;
        }

        $this->redis->set($entity->getName(), $entity->getValue());
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof JsonEvent) {
            return;
        }

        $this->redis->del($entity->getName());
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof YoutubeStatistics) {
            return;
        }

        $this->redis->set($entity->getName(), $entity->getValue());
    }
}