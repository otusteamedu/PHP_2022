<?php

declare(strict_types=1);

namespace App\EventListener;


use App\Entity\YoutubeStatistics;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Events;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;

/**
 *
 */
class YoutubeStatisticsSubscriber implements EventSubscriberInterface
{

    /**
     * @var Client
     */
    private Client $elasticsearch;

    /**
     * @throws \Elastic\Elasticsearch\Exception\AuthenticationException
     */
    public function __construct()
    {
        $this->elasticsearch = ClientBuilder::create()
            ->setHosts(["{$_ENV['ES_HOST']}:{$_ENV['ES_PORT']}"])
            ->build();
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
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function postPersist(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof YoutubeStatistics) {
            return;
        }

        $this->elasticsearch->index(
            array_merge($this->generateElasticSearchParams($entity), [
                'body' => $entity->toSearchArray(),
            ])
        );
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function postRemove(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof YoutubeStatistics) {
            return;
        }

        $this->elasticsearch->index(
            array_merge($this->generateElasticSearchParams($entity), [
                'body' => $entity->toSearchArray(),
            ])
        );
    }

    /**
     * @param LifecycleEventArgs $args
     * @return void
     * @throws \Elastic\Elasticsearch\Exception\ClientResponseException
     * @throws \Elastic\Elasticsearch\Exception\MissingParameterException
     * @throws \Elastic\Elasticsearch\Exception\ServerResponseException
     */
    public function postUpdate(LifecycleEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity instanceof YoutubeStatistics) {
            return;
        }

        $param = array_merge($this->generateElasticSearchParams($entity), [
            'body' => $entity->toSearchArray(),
        ]);

        $this->elasticsearch->index(
            array_merge($this->generateElasticSearchParams($entity), [
                'body' => $entity->toSearchArray(),
            ])
        );
    }

    /**
     * @param YoutubeStatistics $entity
     * @return array
     */
    private function generateElasticSearchParams(YoutubeStatistics $entity): array
    {
        return [
            'index' => $entity->getSearchIndex(),
            'type' => $entity->getSearchType(),
            'id' => $entity->getId(),
        ];
    }
}